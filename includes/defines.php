<?php
/**
 * Defines the GLOBAL parameters
 */
global $includeheader;
$includeheader=array('js' => array(), 'css' => array());
global $includebody;
$includebody=array();
global $fulldomain;
//$fulldomain='/var/www/vhosts/servibyte.com/servibyte.net';
$fulldomain=getcwd();
global $mediapath;
$mediapath = $fulldomain;
date_default_timezone_set("Atlantic/Canary");
/**
 * Only these values are allowed in the first part of the URI
 * Otherwise the call is redirected to the mainpage
 */
$pages = array(
    'login',
    'inicio',
    'configuracion',
    'contrasena',
    'tickets',
    'contabilidad',
    'mantenimiento'
    );

/**
 * Settings for all pages
 */
define('SMARTY_DIR', __DIR__.'/../libs/');

define('APIKEY', md5('sbyte'));
define('DOMAIN', 'http://'.$_SERVER['SERVER_NAME'].((strstr($_SERVER['SERVER_NAME'], '192.168'))?':8080':''));
//define(DOMAIN, 'http://localhost:8888');

define('__DBHOST__', 'localhost');
define('__DBUSER__', 'platformuser');
define('__DBPASS__', 'rfC79w?3');
define('__DBNAME__', 'plataforma');

define('__RAHOST__', 'localhost');
define('__RAUSER__', 'radiususer');
define('__RAPASS__', 'Pwp+*f2b');
define('__RANAME__', 'radius');
?>
