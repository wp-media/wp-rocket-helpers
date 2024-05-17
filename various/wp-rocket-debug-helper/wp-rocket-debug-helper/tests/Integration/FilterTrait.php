<?php

namespace WPRocketDebugHelper\Tests\Integration;

trait FilterTrait {

    protected $original_wp_filter;

    protected function unregisterAllCallbacksFromFilterExcept( $event_name, $method_name, $priority = 10 ) {
        global $wp_filter;
        $this->original_wp_filter = $wp_filter[ $event_name ]->callbacks;

        foreach ( $this->original_wp_filter[ $priority ] as $key => $config ) {

            // Skip if not this tests callback.
            if ( substr( $key, - strlen( $method_name ) ) !== $method_name ) {
                continue;
            }

            $wp_filter[ $event_name ]->callbacks = [
                $priority => [ $key => $config ],
            ];
        }
    }

    protected function restoreWpFilter( $event_name ) {
        global $wp_filter;
        $wp_filter[ $event_name ]->callbacks = $this->original_wp_filter;

    }
}
