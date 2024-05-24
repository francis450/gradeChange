<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'gradeChange');
define('DB_USER', 'root');
define('DB_PASS', '');
function base_url($path = '')
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
    return rtrim($protocol . $domainName, '/') . '/' . ltrim($path, '/');
}
