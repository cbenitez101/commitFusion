<?php /* Smarty version Smarty-3.1.18, created on 2015-08-29 21:10:26
         compiled from "/volume1/web/www-sb/templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:126130165755e211b2a45d27-03782715%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69cc442f16831af598b9c59d8686a40f8e681d50' => 
    array (
      0 => '/volume1/web/www-sb/templates/login.tpl',
      1 => 1440829858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126130165755e211b2a45d27-03782715',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'err_msg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e211b2a88d58_64526802',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e211b2a88d58_64526802')) {function content_55e211b2a88d58_64526802($_smarty_tpl) {?>
<div class="align_center">
    <form  id="loginformular" method="post">
        <fieldset class="margin" style="width: 400px;">
            <legend>Introduzca sus datos</legend>
            <table class="margin">
                <tr>
                    <td>Username: </td>
                    <td><input id="username" type="text" name="username" class="validate[required,custom[integer]]" /></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="userpass" class="validate[required,custom[integer]]" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><input type="submit" name="submit" value="Acceder" /></td>
                </tr>
            </table>
        </fieldset>
    <?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>

</div><?php }} ?>
