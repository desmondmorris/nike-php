<?php

if (!function_exists('curl_init')) {
    throw new Exception('The CURL PHP extension was not found.');
}

require(dirname(__FILE__) . '/Nike/Request.php');
require(dirname(__FILE__) . '/Nike/Nike.php');
