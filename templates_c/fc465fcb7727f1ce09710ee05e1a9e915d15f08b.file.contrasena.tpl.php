<?php /* Smarty version Smarty-3.1.18, created on 2014-10-20 13:59:08
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/contrasena.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17334080435440d22a6b6e84-62590380%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc465fcb7727f1ce09710ee05e1a9e915d15f08b' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/contrasena.tpl',
      1 => 1413809943,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17334080435440d22a6b6e84-62590380',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5440d22a70db60_13543344',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5440d22a70db60_13543344')) {function content_5440d22a70db60_13543344($_smarty_tpl) {?><div class="align_center">
    <div>
        Introduzca su correo electrónico:
        <input type="text" name="email" id="mail">
    </div>
    <input type="button" name="enviar" value="Enviar" onclick="event.preventDefault();$.ajax({url: '<?php echo @constant('DOMAIN');?>
/send_mail', type: 'POST', data:{correoelec: $('#mail').val()}}).done(function (data){alert(data.trim());});window.location='<?php echo @constant('DOMAIN');?>
'">
</div><?php }} ?>
