<?php
/**
 * Plugin Name: WP Rocket | CPCSS Debug Helper
 * Description: A WordPress plugin helping debug in CPCSS.
 * Plugin URI: https://github.com/wp-media/wp-rocket-helpers/tree/master/static-files/wp-rocket-static-cpcss-debug-helper/
 * Version: 1.0.0
 * Author: WP Rocket Support Team
 * Author URI: https://wp-rocket.me
 * License:	GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright 2019 WP Media <support@wp-rocket.me>
 */
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

add_action( 'admin_menu', function () {
    add_options_page( 'CPCSS Helper', 'CPCSS Helper', 'manage_options', 'cpcss-helper-plugin', 'cpcss_settings_page' );
});

function cpcss_get_public_post_types () {
    global $wpdb;
    $post_types = get_post_types(
        array(
            'public'             => true,
            'publicly_queryable' => true,
        )
    );
    $post_types[] = 'page';
    $excluded_post_types = apply_filters( 'rocket_cpcss_excluded_post_types', array() );
    $post_types = array_diff( $post_types, $excluded_post_types );
    $post_types = esc_sql( $post_types );
    $post_types = "'" . implode( "','", $post_types ) . "'";
    $rows = $wpdb->get_results( // WPCS: unprepared SQL ok.
        "
        SELECT MAX(ID) as ID, post_type
        FROM (
            SELECT ID, post_type
            FROM $wpdb->posts
            WHERE post_type IN ( $post_types )
            AND post_status = 'publish'
            ORDER BY post_date DESC
        ) AS posts
        GROUP BY post_type"
    );
    return $rows;
}

function cpcss_get_public_taxonomies() {
    global $wpdb;
    $taxonomies = get_taxonomies(
        array(
            'public'             => true,
            'publicly_queryable' => true,
        )
    );
    $excluded_taxonomies = apply_filters( 'rocket_cpcss_excluded_taxonomies', array(
        'post_format',
        'product_shipping_class',
    ) );
    $taxonomies = array_diff( $taxonomies, $excluded_taxonomies );
    $taxonomies = esc_sql( $taxonomies );
    $taxonomies = "'" . implode( "','", $taxonomies ) . "'";
    $rows = $wpdb->get_results( // WPCS: unprepared SQL ok.
        "
        SELECT MAX( term_id ) AS ID, taxonomy
        FROM (
            SELECT term_id, taxonomy
            FROM $wpdb->term_taxonomy
            WHERE taxonomy IN ( $taxonomies )
            AND count > 0
        ) AS taxonomies
        GROUP BY taxonomy
        "
    );
    return $rows;
}

function cpcss_settings_page () {
    $items = [];

    $items[] = array(
        'type' => 'front_page',
        'url'  => home_url( '/' ),
    );

    $page_for_posts = get_option( 'page_for_posts' );
    if ( 'page' === get_option( 'show_on_front' ) && ! empty( $page_for_posts ) ) {
        $items[] = array(
            'type' => 'home',
            'url'  => get_permalink( get_option( 'page_for_posts' ) ),
        );
    }
    $post_types = cpcss_get_public_post_types();
    foreach ( $post_types as $post_type ) {
        $items[] = array(
            'type' => $post_type->post_type,
            'url'  => get_permalink( $post_type->ID ),
        );
    }
    $taxonomies = cpcss_get_public_taxonomies();
    foreach ( $taxonomies as $taxonomy ) {
        $items[] = array(
            'type' => $taxonomy->taxonomy,
            'url'  => get_term_link( (int) $taxonomy->ID, $taxonomy->taxonomy ),
        );
    }
    $output = '<ul class="cpcss-urls-list">';
    foreach ($items as $item) {
        $output .= '<li data-url="' . $item['url'] . '"><strong>' . $item['type'] . ':</strong> <a href="' . $item['url'] . '" target="_blank">' . $item['url'] . '</a> <span class="cpcss-dual-ring"></span></span></li>';
    }
    $output .= '</ul>';
    ?>
        <style type="text/css">
            .cpcss-dual-ring {
                display: none;
                width: 24px;
                height: 24px;
                vertical-align: -6px;
                margin-left: 10px;
            }
            .cpcss-dual-ring.success,
            .cpcss-dual-ring.error {
                animation: none;
                font-weight: bold;
                vertical-align: 0;
            }
            .cpcss-dual-ring.success:after,
            .cpcss-dual-ring.error:after {
                display: none;
            }
            .cpcss-dual-ring.success {
                color: #3f8d19;
            }
            .cpcss-dual-ring.error {
                color: #e74c3c;
            }
            .cpcss-dual-ring:after {
                content: " ";
                display: block;
                width: 16px;
                height: 16px;
                margin: 1px;
                border-radius: 50%;
                border: 5px solid #3f8d19;
                border-color: #3f8d19 transparent #3f8d19 transparent;
                animation: cpcss-dual-ring 1.2s linear infinite;
            }
            @keyframes cpcss-dual-ring {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
            .cpcss-urls-list strong {
                display: inline-block;
                width: 100px;
                text-align: right;
            }
            .cpcss-urls-list li {
                margin: 10px 0;
                line-height: 2;
            }
            .cpcss-urls-list li.cpcss-loading .cpcss-dual-ring {
                display: inline-block;
            }
        </style>
        <div class="wrap wpforms-container">
            <?php echo $output; ?>
            <br>
            <button type="button" id="cpcss-launch-button" class="button button-primary button-hero">Launch URL Test</button>
        </div>
        <script>
            (function ($) {
                $('#cpcss-launch-button').click(function () {
                    $('.cpcss-loading').removeClass('cpcss-loading')
                    $('.cpcss-urls-list span').empty().removeClass('error').removeClass('success')
                    $('.cpcss-urls-list li').each(function () {
                        let
                            $item   = $(this)
                            , url   = $item.data('url')
                            , $span = $item.find('span')
                        
                        $item.addClass('cpcss-loading')
                        
                        $.ajax({url})
                        .done(() => $span.html('OK').addClass('success'))
                        .fail(() => $span.html('ERROR').addClass('error'))
                    })
                })
            })(jQuery)
        </script>
    <?php
}