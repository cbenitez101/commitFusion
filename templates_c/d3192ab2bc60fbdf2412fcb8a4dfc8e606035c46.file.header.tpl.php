<?php /* Smarty version Smarty-3.1.18, created on 2015-08-31 05:56:33
         compiled from "/volume1/web/www-sb/templates/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:85723436955e211b239aae7-85067962%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd3192ab2bc60fbdf2412fcb8a4dfc8e606035c46' => 
    array (
      0 => '/volume1/web/www-sb/templates/header.tpl',
      1 => 1440996987,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '85723436955e211b239aae7-85067962',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e211b29ed245_26410709',
  'variables' => 
  array (
    'title' => 0,
    'includeheadercss' => 0,
    'code' => 0,
    'includeheaderjs' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e211b29ed245_26410709')) {function content_55e211b29ed245_26410709($_smarty_tpl) {?><!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content=""><meta name="author" content="Servibyte SCP"><title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title><link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"><!-- MetisMenu CSS --><link href="/scripts/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet"><!-- Custom CSS --><link href="/scripts/dist/css/sb-admin-2.css" rel="stylesheet"><!-- Custom Fonts --><link href="/scripts/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"><!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --><!-- WARNING: Respond.js doesn't work if you view the page via file:// --><!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script><script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script><![endif]--><?php  $_smarty_tpl->tpl_vars['code'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['code']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['includeheadercss']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['code']->key => $_smarty_tpl->tpl_vars['code']->value) {
$_smarty_tpl->tpl_vars['code']->_loop = true;
?><?php echo $_smarty_tpl->tpl_vars['code']->value;?>
<?php } ?><script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script><!-- Metis Menu Plugin JavaScript --><script src="/scripts/bower_components/metisMenu/dist/metisMenu.min.js"></script><!-- Custom Theme JavaScript --><script src="/scripts/dist/js/sb-admin-2.js"></script><?php  $_smarty_tpl->tpl_vars['code'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['code']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['includeheaderjs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['code']->key => $_smarty_tpl->tpl_vars['code']->value) {
$_smarty_tpl->tpl_vars['code']->_loop = true;
?><?php echo $_smarty_tpl->tpl_vars['code']->value;?>
<?php } ?></head><body>
        
<?php }} ?>
