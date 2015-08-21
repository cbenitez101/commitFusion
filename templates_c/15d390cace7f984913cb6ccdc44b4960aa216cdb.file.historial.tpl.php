<?php /* Smarty version Smarty-3.1.18, created on 2015-06-15 21:20:53
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/contabilidad/historial.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1665027702555eebfd0d1f46-68581300%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15d390cace7f984913cb6ccdc44b4960aa216cdb' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/contabilidad/historial.tpl',
      1 => 1434395959,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1665027702555eebfd0d1f46-68581300',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555eebfd0d2df2_26889378',
  'variables' => 
  array (
    'cols' => 0,
    'tabla' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555eebfd0d2df2_26889378')) {function content_555eebfd0d2df2_26889378($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
?><div class="float_left">
    <?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit hisorialtable" id="table-search"','loop'=>$_smarty_tpl->tpl_vars['tabla']->value),$_smarty_tpl);?>

</div><?php }} ?>
