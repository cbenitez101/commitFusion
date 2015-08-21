<?php /* Smarty version Smarty-3.1.18, created on 2015-01-22 18:10:52
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29509890054b58bb7de3978-47636807%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd717c9ef6665efd5fd1843feb6b0f8a1129b650b' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/menu.tpl',
      1 => 1421950130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29509890054b58bb7de3978-47636807',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54b58bb7efdaf7_19605750',
  'variables' => 
  array (
    'cols' => 0,
    'users' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54b58bb7efdaf7_19605750')) {function content_54b58bb7efdaf7_19605750($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
?><form method="POST">
    <div>
        Añadir menu: <input type="text" name="table_name"><input class="ui-button" type="submit" value="Crear" name="create_table" />
    </div>
</form>
<div class="float_left" id="confmenu">
    <?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit" id="table-search"','loop'=>$_smarty_tpl->tpl_vars['users']->value),$_smarty_tpl);?>

</div>

<div class="menueliminar">
    <div>¿Desea realemente eliminar el menu?</div>
</div><?php }} ?>
