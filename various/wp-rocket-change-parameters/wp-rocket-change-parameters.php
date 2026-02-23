<?php
/**
 * Plugin Name: WP Rocket | Change Parameters
 * Description: Reduce the CPU usage by changing the default Preload and RUCSS parameters
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\static_files\various\change_parameters;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

add_action( 'plugins_loaded', function() {

    // Prevent fatal error if WP Rocket is disabled
    if ( ! defined( 'WP_ROCKET_VERSION' ) ) {
        return;
    }


    function set_configs() {
        
        $configs = [

        // EDIT HERE

            //PRELOAD MAXIMUM BATCH SIZE
            'rocket_preload_cache_pending_jobs_cron_rows_count' => 25,


            //PRELOAD MINIMUM BATCH SIZE
            'rocket_preload_cache_min_in_progress_jobs_count' => 3,


            //PRELOAD CRON INTERVAL
            'rocket_preload_pending_jobs_cron_interval' => 120,


            //PRELOAD DELAY BETWEEN REQUESTS:
            'rocket_preload_delay_between_requests' => 1,


            //RUCSS BATCH SIZE
            'rocket_saas_pending_jobs_cron_rows_count' => 25,

 
            //RUCSS CRON INTERVAL
            'rocket_saas_pending_jobs_cron_interval' => 120,

        // STOP EDITING
        ];

        // Must be a positive integer
        $configs['rocket_preload_delay_between_requests'] = absint( $configs['rocket_preload_delay_between_requests'] * 1000000 );

        // Set the value for the old filter in case version prior to 3.16 used
        $configs['rocket_rucss_pending_jobs_cron_rows_count'] = $configs['rocket_saas_pending_jobs_cron_rows_count'];

        return $configs;
    }


    // DO NOT EDIT ANYTHING BELOW UNLESS YOU KNOW WHAT YOU ARE DOING


    $is_after_atf_introduced = version_compare( WP_ROCKET_VERSION, '3.16', '>=' );
    $is_after_3_16_2 = version_compare( WP_ROCKET_VERSION, '3.16.2', '>=' );


    function set_custom_parameter( $custom_parameter ) {
        
        $configs = set_configs();

        if ( isset( $configs[current_filter()] ) && is_numeric( $configs[current_filter()] ) ) {
            $custom_parameter = $configs[current_filter()];
        }

        return $custom_parameter;
    }


    // Set max Preload batch size
    add_filter( 'rocket_preload_cache_pending_jobs_cron_rows_count', __NAMESPACE__ . '\set_custom_parameter' );


    // Set minimum Preload batch size (if using WP Rocket 3.16.2 or later)
    if ( $is_after_3_16_2 ) {
        add_filter( 'rocket_preload_cache_min_in_progress_jobs_count', __NAMESPACE__ . '\set_custom_parameter' );
    }


    // Set Preload Cron Interval
    add_filter( 'rocket_preload_pending_jobs_cron_interval', __NAMESPACE__ . '\set_custom_parameter' );


    // Set Preload delay between requests to the same page
    add_filter( 'rocket_preload_delay_between_requests', __NAMESPACE__ . '\set_custom_parameter' );


    // Set Remove Unused CSS batch size
    if ( $is_after_atf_introduced ) {
        add_filter( 'rocket_saas_pending_jobs_cron_rows_count', __NAMESPACE__ . '\set_custom_parameter' );
    } else {
        add_filter( 'rocket_rucss_pending_jobs_cron_rows_count', __NAMESPACE__ . '\set_custom_parameter' );
    }


    // Set Remove Unused CSS cron interval
    if ( $is_after_atf_introduced ) {
        add_filter( 'rocket_saas_pending_jobs_cron_interval', __NAMESPACE__ . '\set_custom_parameter' );
    } else {
        add_filter( 'rocket_rucss_pending_jobs_cron_interval', __NAMESPACE__ . '\set_custom_parameter' );
    }

} );