<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('alert_main')) {
    function alert_main($msg)
    {
        $baseURL = 'base_url';

        echo <<< HTML
                <script type="text/javascript">
                    alert('{$msg}');
                    window.location = "{$baseURL()}";
                </script>
                HTML;
    }
}

if (!function_exists('alert')) {
    function alert($msg, string $url = '')
    {
        $CI = &get_instance();
        $CI->load->view('common/alert', ['msg' => $msg, 'url' => $url]);
    }
}
