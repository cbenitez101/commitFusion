<?php /* Smarty version Smarty-3.1.18, created on 2015-06-09 18:18:34
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/tickets/facebook.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12807466255575fcf4467f46-84196592%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99b84e41e2721a340c1f48c8593c6f9df1b4a09a' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/tickets/facebook.tpl',
      1 => 1433870248,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12807466255575fcf4467f46-84196592',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5575fcf44694b2_40440366',
  'variables' => 
  array (
    'cols' => 0,
    'facebook' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5575fcf44694b2_40440366')) {function content_5575fcf44694b2_40440366($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
?><div class="float_left">
    <?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit hotspottable" id="table-search-fb"','loop'=>$_smarty_tpl->tpl_vars['facebook']->value),$_smarty_tpl);?>

</div><?php }} ?>
