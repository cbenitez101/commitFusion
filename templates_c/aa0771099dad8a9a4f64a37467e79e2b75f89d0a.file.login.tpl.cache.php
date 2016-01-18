<?php /* Smarty version Smarty-3.1.18, created on 2014-10-16 15:48:04
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2083144661543fdaa42eede1-29355317%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa0771099dad8a9a4f64a37467e79e2b75f89d0a' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/login.tpl',
      1 => 1412887809,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2083144661543fdaa42eede1-29355317',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'err_msg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_543fdaa4307fa5_86197189',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_543fdaa4307fa5_86197189')) {function content_543fdaa4307fa5_86197189($_smarty_tpl) {?>
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
    </form>
    <?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>

</div>
<?php }} ?>
