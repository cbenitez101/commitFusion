<?php
session_start();

require_once __DIR__.'/functions.php';                      // Load GLOBAL functions
require_once __DIR__.'/defines.php';                        // Load GLOBAL parameters
//require_once __DIR__.'/../classes/class.phpmailer.php';     // Load Mailer class
require_once (SMARTY_DIR . 'Smarty.class.php');             // Load Smarty
require 'vendor/autoload.php';                              // Telegram API
use Telegram\Bot\Api;
global $telegram;
$telegram = new Api('350404834:AAEQf-q52bLH6oEO3cNdeQlmZ6uqp1QXIp4');
global $database;
$database= new mysqli(__DBHOST__, __DBUSER__, __DBPASS__, __DBNAME__);
$radius= new mysqli(__RAHOST__, __RAUSER__, __RAPASS__, __RANAME__);
$database->query("SET NAMES 'utf8'");
include_header_file('default');
$smarty = new Smarty();                                      // Initialize new Smarty-Instance
$smarty->setTemplateDir(__DIR__.'/../templates/');
$smarty->setCompileDir(__DIR__.'/../templates_c/');
$smarty->setConfigDir(__DIR__.'/../configs/');
$smarty->setCacheDir(__DIR__.'/../cache/');
//$smarty->caching = true;
//$smarty->force_complie=false;
//$smarty->debugging = true;
$smarty->assign('title','Servibyte Platform');
//logit();
$getparams  = (isset($_GET))? $_GET : '' ;     // Get all the data from the URL
$postparams = (isset($_POST))? $_POST : '' ;   // Get all Formdata
$template_data = getTemplateData($getparams);
get_subdoamin();
if (!isLoggedIn() && ($template_data[0]!='contrasena')) {
    define(TEMPLATE_NAME, 'login');
} else {
    define(TEMPLATE_NAME, $template_data[0]);
}
require_once __DIR__.'/../controller/'.TEMPLATE_NAME.'.php';  // Load controller for the template
include_header_file('includes/'.TEMPLATE_NAME);
?>
