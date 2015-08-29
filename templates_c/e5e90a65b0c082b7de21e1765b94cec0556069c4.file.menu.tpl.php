<?php /* Smarty version Smarty-3.1.18, created on 2015-08-29 08:27:00
         compiled from "/volume1/web/www-sb/templates/configuracion/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:97683198955e15ec4134363-83572473%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5e90a65b0c082b7de21e1765b94cec0556069c4' => 
    array (
      0 => '/volume1/web/www-sb/templates/configuracion/menu.tpl',
      1 => 1440829858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '97683198955e15ec4134363-83572473',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cols' => 0,
    'users' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e15ec44ca245_50677673',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e15ec44ca245_50677673')) {function content_55e15ec44ca245_50677673($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/volume1/web/www-sb/includes/../libs/plugins/function.html_table.php';
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
