<?php

namespace WPRocketDebugHelper\Tests\Integration;
use ReflectionObject;
use WPMedia\PHPUnit\Integration\AjaxTestCase as WPMediaAjaxTestCase;
class AjaxTestCase extends WPMediaAjaxTestCase
{
    protected static $transients         = [];

    protected $config;

    public static function set_up_before_class() {
        parent::set_up_before_class();

        if ( ! empty( self::$transients ) ) {
            foreach ( array_keys( self::$transients ) as $transient ) {
                self::$transients[ $transient ] = get_transient( $transient );
            }
        }
    }

    public static function tear_down_after_class() {
        self::uninstallAll();

        foreach ( self::$transients as $transient => $value ) {
            if ( ! empty( $transient ) ) {
                set_transient( $transient, $value );
            } else {
                delete_transient( $transient );
            }
        }

        parent::tear_down_after_class();
    }

    public function set_up() {
        parent::set_up();

        if ( empty( $this->config ) ) {
            $this->loadTestDataConfig();
        }
    }

    public function tear_down() {
        unset( $_POST['action'], $_POST['nonce'] );
        $this->action = null;

        parent::tear_down();
    }

    public function configTestData() {
        if ( empty( $this->config ) ) {
            $this->loadTestDataConfig();
        }

        return isset( $this->config['test_data'] )
            ? $this->config['test_data']
            : $this->config;
    }

    protected function loadTestDataConfig() {
        $obj      = new ReflectionObject( $this );
        $filename = $obj->getFileName();

        $this->config = $this->getTestData( dirname( $filename ), basename( $filename, '.php' ) );
    }
}
