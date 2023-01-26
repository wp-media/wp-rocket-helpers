<?php
defined('ABSPATH') || exit;
class IPChecker
{
    private $hosts = array(
        '146.59.192.120',
        'wp-rocket.me',
        '109.234.160.58',
        '51.83.15.135',
        '51.210.39.196',
        'cpcss.wp-rocket.me',
        '141.94.254.72',
        '141.94.252.17',
        '51.178.134.82',
        '135.125.180.130',
        '141.95.202.69',
        '162.19.138.231',
        '162.19.73.17',
        '141.94.133.225',
        '141.94.134.63',
        '15.235.11.139',
        '15.235.14.231',
        '15.235.50.215',
        '15.235.50.217',
        '15.235.82.194',
        '15.235.82.233',
        'saas.wp-rocket.me',
        '152.228.165.39',
        '146.59.251.59',
        'rocketcdn.me',
    );
    public function run() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return $this->windows();
        } else {
            return $this->notWindows();
        }
    }
    private function windows() {
        // Not supported at the moment
        return 'windows';
    }
    private function notWindows() {
        $responses = array();
        foreach ($this->hosts as $host) {
            if (!function_exists('shell_exec')) {
                return 'no-shell-exec';
            }
            $output = shell_exec("ping -c 1 -q $host");
            $connected = strpos($output, '1 received');
            $responses[$host] = $connected && $connected !== 0;
        }
        return $responses;
    }
}