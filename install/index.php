<?php

include "../environment.php";
if (ENVIRONMENT === "pre_installation") {
    $php_version_success = false;
    $mysql_success = false;
    $curl_success = false;
    $gd_success = false;
    $timezone_success = false;
    $allow_url_fopen = false;

    $isEnabled = true;

    $php_version_required = "7.0.0";
    $current_php_version = PHP_VERSION;

//check required php version
    if (version_compare($current_php_version, $php_version_required) >= 0) {
        $php_version_success = true;
    }

//check mySql 
    if (function_exists("mysqli_connect")) {
        $mysql_success = true;
    }

//check curl 
    if (function_exists("curl_version")) {
        $curl_success = true;
    }

    //check allow url fopen
    if (ini_get('allow_url_fopen')) {
        $allow_url_fopen = TRUE;
    } else {
        $allow_url_fopen = FALSE;
    }

    //check if all requirement is success
    if ($php_version_success && $mysql_success && $curl_success && $isEnabled) {
        $all_requirement_success = true;
    } else {
        $all_requirement_success = false;
    }

    $writeable_directories = array(
        'routes' => '/index.php',
        'env' => '/environment.php',
        'upload' => '/assets/upload',
        'category' => '/assets/upload/category',
        'carousel' => '/assets/upload/carousel',
        'profile' => '/assets/upload/profile',
        'recipes' => '/assets/upload/recipes',
    );

    foreach ($writeable_directories as $value) {
        if (!is_writeable(".." . $value)) {
            $all_requirement_success = false;
        }
    }

    $dashboard_url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    $dashboard_url = preg_replace('/install.*/', '', $dashboard_url); //remove everything after index.php
    if (!empty($_SERVER['HTTPS'])) {
        $dashboard_url = 'https://' . $dashboard_url;
    } else {
        $dashboard_url = 'http://' . $dashboard_url;
    }

    include "view/index.php";
} else {
    $new_domain = str_replace('install/', '', $domain);
    header("Location: $new_domain");
    exit(0);
}
?>