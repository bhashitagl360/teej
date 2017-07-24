<?php
    /*
        ***************************************************
            Connection File
            Project Name: Teej
            Author: Vipin Ganganiya
        ***************************************************
    */
    session_start();
    error_reporting(1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 1);
    //    print '<pre>';print_r($_SERVER);die('vip');
    /*
        ***************************************************
            Connection Vars
        ***************************************************
    */
        define('siteUrl', 'http://localhost/teej');
        define('siteAdminUrl', 'http://localhost/teej/teejfest/');

        $connection = array(
            'h' => 'localhost',
            'u' => 'root',
            'p' => '',
            'd' => 'teej',
        );
    /*
        ***************************************************
            Site Global Vars
        ***************************************************
    */

    define( 'site_title', 'Teej Taiyyari | Rajasthan Tourism' );
    define( 'documentRoot',  $_SERVER['DOCUMENT_ROOT'] );

    $gooleApi = array(
        'fonts.googleapis' => 'https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900');

    $js = array(
        'js/jquery.min.js',
        'js/masonry.pkgd.min.js',
        'js/bootstrap.min.js',
        'js/custom.js',
        );

    $css = array(
        'css/bootstrap.min.css',
        'css/reset.css',
        'css/style.css',
        );

    // Create connection
    $mysqli = new mysqli($connection['h'], $connection['u'], $connection['p'], $connection['d']);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed - Connection file : " . $mysqli->connect_error);
    }


    function get_extension($file_name){
        $ext = explode('.', $file_name);
        $ext = array_pop($ext);
        return strtolower($ext);
    }
    
    
    $aaaa= 'http://localhost/teej';
    
?>
