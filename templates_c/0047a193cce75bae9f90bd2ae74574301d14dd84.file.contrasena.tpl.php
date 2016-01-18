<?php /* Smarty version Smarty-3.1.18, created on 2015-08-31 07:14:03
         compiled from "/volume1/web/www-sb/templates/contrasena.tpl" */ ?>
<?php /*%%SmartyHeaderCode:168702124455e3f02c006096-87368624%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0047a193cce75bae9f90bd2ae74574301d14dd84' => 
    array (
      0 => '/volume1/web/www-sb/templates/contrasena.tpl',
      1 => 1441001641,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '168702124455e3f02c006096-87368624',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e3f02c09f121_56911390',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e3f02c09f121_56911390')) {function content_55e3f02c09f121_56911390($_smarty_tpl) {?><div class="align_center">
	<img class="navbar-brand"src="<?php echo @constant('DOMAIN');?>
/images/logos/<?php echo $_SESSION['cliente'];?>
<?php if (isset($_SESSION['local'])) {?>.<?php echo $_SESSION['local'];?>
<?php }?>.png" width="400px"/>
</div>
<br>
<div class="align_center">
    <div>
        Introduzca su correo electrónico:
        <input type="text" name="email" id="mail">
    </div>
    <input type="button" name="enviar" value="Enviar" onclick="event.preventDefault();$.ajax({url: '<?php echo @constant('DOMAIN');?>
/send_mail', type: 'POST', data:{correoelec: $('#mail').val()}}).done(function (data){alert(data.trim());});window.location='<?php echo @constant('DOMAIN');?>
'">
</div><?php }} ?>
