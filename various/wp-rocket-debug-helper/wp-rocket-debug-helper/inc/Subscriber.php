<?php

namespace WPRocketDebugHelper;

use WPRocketDebugHelper\Dependencies\LaunchpadCore\Container\PrefixAware;
use WPRocketDebugHelper\Dependencies\LaunchpadCore\Container\PrefixAwareInterface;
use WPRocketDebugHelper\Dependencies\LaunchpadCore\Dispatcher\DispatcherAwareInterface;
use WPRocketDebugHelper\Dependencies\LaunchpadCore\Dispatcher\DispatcherAwareTrait;
use function WP_Rocket\Helpers\debug\render_note_minify_html;

class Subscriber implements PrefixAwareInterface, DispatcherAwareInterface
{
    use PrefixAware, DispatcherAwareTrait;

    /**
     * @hook wp_footer 999999999999
     */
    public function format_debug_notice()
    {

        $parameters = [
            'constants' => $this->check_constants_defined(),
            'filters' => $this->check_filters(),
            'functions' => $this->check_functions(),
            'conflicts' => $this->check_conflicts(),
            'ssl' => $this->check_ssl(),
        ];

        if(is_singular()) {
            $post_id = absint( $GLOBALS['post']->ID );
            $parameters['post_id'] = $post_id;
            $parameters['excluded'] = $this->check_excluded($post_id);
            $parameters['metaboxes'] = $this->check_metaboxes();
        }

        $this->dispatcher->do_action("{$this->prefix}render_template", 'debug_notice', [
            'parameters' => $parameters
        ]);
    }

    /**
     * @hook get_rocket_option_minify_html
     */
    public function disable_minification()
    {
        return false;
    }

    protected function check_constants_defined(): array
    {
        $constants = [
            'WP_CACHE',
            'DONOTCACHEPAGE',
            'DONOTMINIFY',
            'DONOTMINIFYCSS',
            'DONOTMINIFYJS',
            'ABSPATH',
        ];

        $constants_exists = [];

        foreach ($constants as $constant) {

            if( ! defined( $constant ) ) {
                $constants_exists[ $constant ] = 'not defined';
                continue;
            }

            $constant_value =  constant( $constant );

            if( ! is_bool($constant_value) && 'true' !== $constant_value && 'false' !== $constant_value ) {
                $constants_exists[ $constant ] = $constant_value;
                continue;
            }

            $constants_exists[ $constant ] = true === $constant_value || 'true' === $constant_value ? 'TRUE' : 'FALSE';
        }

        return $constants_exists;
    }

    protected function check_filters(): array
    {
        $filters = array(
            'do_rocket_generate_caching_files',
            'rocket_override_donotcachepage'
        );

        $filters_callbacks = [];

        foreach ( $filters as $filter ) {

            $html_filter = 'not set';

            global $wp_filter;

            foreach ( $wp_filter as $filter_name => $filter_value ) {
                if ( false !== strpos( $filter_name, $filter ) ) {

                    $current_filter = $filter_value->current();

                    foreach ( $current_filter as $key => $value ) {

                        $html_filter  = 'set';
                        $html_filter .= sprintf( ' (%s)', var_export( $value['function'], true ) );

                        if ( 'rocket_override_donotcachepage_on_thrive_leads' === $value['function'] ) {
                            $html_filter = sprintf( 'default (%s)', var_export( $value['function'], true ) );
                        }

                    }

                }
            }

            $filters_callbacks[$filter] = $html_filter;
        }

        return $filters_callbacks;
    }

     public function check_functions(): array
     {

         $functions = array(
             'mb_substr_count',
         );

         $functions_exists = [];

         foreach ( $functions as $function ) {
             $functions_exists [$function] = function_exists( $function );
         }

         return $functions_exists;
     }

     public function check_conflicts(): array
     {
         $conflicts = [];

         $known_plugin_conflicts = array(
             'geoip-detect/geoip-detect.php',
             'email-to-download/email-to-download.php',
             'yet-another-stars-rating/yet-another-stars-rating.php',
             'ezoic-integration/ezoic-integration.php',
             'bulk-image-alt-text-with-yoast/bulk-image-alt-text-with-yoast.php',
             'wp-facebook-open-graph-protocol/wp-facebook-ogp.php',
             'password-protected/password-protected.php',
             'wp-social-seo-booster/wpsocial-seo-booster.php',
             'cookie-law-info/cookie-law-info.php'
         );

         foreach ( $known_plugin_conflicts as $plugin ) {

             if( ! is_plugin_active( $plugin ) ) {
                 continue;
             }

             $conflicts []= $plugin;
         }

         return $conflicts;
     }

     public function check_ssl(): bool
     {
         return 1 === (int) get_rocket_option( 'cache_ssl' );
     }

     public function check_metaboxes(): array
     {

         $cache_options = array(
             'lazyload',
             'lazyload_iframes',
             'minify_html',
             'minify_css',
             'minify_js',
             'cdn',
             'async_css',
             'defer_all_js',
         );

         $metaboxes = [];

         foreach ( $cache_options as $cache_option ) {

             $value = is_rocket_post_excluded_option( $cache_option );

             $metaboxes[$cache_option] = '1' === $value;
         }

         return $metaboxes;
     }

     public function check_excluded($current_post_id)
     {
         // No way to find out if the “Never cache this page” option is checked,
         // but we can find out whether or not this post is excluded from cache.
         $excluded_post_paths = get_rocket_option( 'cache_reject_uri', array() );
         $current_post_path   = rocket_clean_exclude_file( get_permalink( $current_post_id ) );
         $maybe_post_excluded = in_array( $current_post_path, $excluded_post_paths);

         return  $maybe_post_excluded;
     }
}