<?php
//error_reporting(E_ERROR);
//error_reporting(E_ALL);
//error_reporting(0);
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('Atlantic/Canary');
/*
 * Load the settings
 */
require_once __DIR__.'/includes/settings.php';
/*
 * Display the site
 */
asort($includeheader['js']);
$smarty->assign('includeheaderjs', $includeheader['js']);
$smarty->assign('includeheadercss', $includeheader['css']);
//$smarty->assign('includebody', str_replace(array("  ", "   ", "    ","     "), " ", str_replace(array("\n", "\t"), "", $includebody)));
$smarty->assign('includebody',$includebody);
$smarty->display('header.tpl');
if ((TEMPLATE_NAME != 'login') && (TEMPLATE_NAME != 'contrasena')) $smarty->display('menu.tpl');
$smarty->display(TEMPLATE_NAME.(((TEMPLATE_NAME != 'login') && (TEMPLATE_NAME != 'contrasena') && (TEMPLATE_NAME != 'inicio'))?'/'.TEMPLATE_NAME:'').'.tpl');
$smarty->display('footer.tpl');

$smarty->assign('title', 'Servibyte - '.TEMPLATE_NAME);
