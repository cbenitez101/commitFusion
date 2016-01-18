<?php /* Smarty version Smarty-3.1.18, created on 2016-01-18 11:06:28
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:195136346569cb924b06d84-06306184%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa0771099dad8a9a4f64a37467e79e2b75f89d0a' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/login.tpl',
      1 => 1453111140,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '195136346569cb924b06d84-06306184',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'err_msg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_569cb924b6af32_03928397',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569cb924b6af32_03928397')) {function content_569cb924b6af32_03928397($_smarty_tpl) {?>
<div class="container"><div class="row"><div class="col-md-4 col-md-offset-4"><img src="<?php echo @constant('DOMAIN');?>
/images/logos/<?php echo $_SESSION['cliente'];?>
<?php if (isset($_SESSION['local'])) {?>.<?php echo $_SESSION['local'];?>
<?php }?>.png" width="100%  "></div></div><div class="row"><div class="col-md-4 col-md-offset-4"><div class="login-panel panel panel-default"><div class="panel-heading"><h3 class="panel-title">Introduzca sus datos</h3></div><div class="panel-body"><form  id="loginformular" method="post"><fieldset><div class="form-group"><input class="form-control" id="username" type="text" name="username"placeholder="Usuario" autofocus /></div><div class="form-group"><input class="form-control" type="password" name="userpass" placeholder="Contraseña" /></div><input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Acceder" /></fieldset></form></div></div><?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>
</div></div></div><?php }} ?>
