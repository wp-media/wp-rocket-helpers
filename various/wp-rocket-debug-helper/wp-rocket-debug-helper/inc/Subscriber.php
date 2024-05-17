<?php

namespace WPRocketDebugHelper;

use WPRocketDebugHelper\Dependencies\LaunchpadCore\Container\PrefixAware;
use WPRocketDebugHelper\Dependencies\LaunchpadCore\Container\PrefixAwareInterface;
use WPRocketDebugHelper\Dependencies\LaunchpadCore\Dispatcher\DispatcherAwareInterface;
use WPRocketDebugHelper\Dependencies\LaunchpadCore\Dispatcher\DispatcherAwareTrait;

class Subscriber implements PrefixAwareInterface, DispatcherAwareInterface
{
    use PrefixAware, DispatcherAwareTrait;

    /**
     * @hook wp_footer 999999999999
     */
    public function format_debug_notice()
    {
        $this->dispatcher->do_action("{$this->prefix}render_template", 'debug_notice', [
            'parameters' => [
                'constants' => $this->check_constants_defined(),
                'filters' => $this->check_filters(),
            ]
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

     public function check_functions()
     {

     }
}