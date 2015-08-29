<?php /* Smarty version Smarty-3.1.18, created on 2015-08-29 08:27:17
         compiled from "/volume1/web/www-sb/templates/contabilidad/historial.tpl" */ ?>
<?php /*%%SmartyHeaderCode:105205332555e15ed5da7189-78681288%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '882242ce0d4e8183721cd9021e2276db19cff573' => 
    array (
      0 => '/volume1/web/www-sb/templates/contabilidad/historial.tpl',
      1 => 1440829858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '105205332555e15ed5da7189-78681288',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cols' => 0,
    'tabla' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e15ed5e0b6f8_47795183',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e15ed5e0b6f8_47795183')) {function content_55e15ed5e0b6f8_47795183($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/volume1/web/www-sb/includes/../libs/plugins/function.html_table.php';
?><div class="float_left">
    <?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit hisorialtable" id="table-search"','loop'=>$_smarty_tpl->tpl_vars['tabla']->value),$_smarty_tpl);?>

</div><?php }} ?>
