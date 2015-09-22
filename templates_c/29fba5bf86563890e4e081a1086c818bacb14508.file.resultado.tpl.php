<?php /* Smarty version Smarty-3.1.18, created on 2015-03-17 11:27:38
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/tickets/resultado.tpl" */ ?>
<?php /*%%SmartyHeaderCode:148774210455080faa1bf2d0-53651338%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29fba5bf86563890e4e081a1086c818bacb14508' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/tickets/resultado.tpl',
      1 => 1426187476,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '148774210455080faa1bf2d0-53651338',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cols' => 0,
    'tickets' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55080faa262e53_88454162',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55080faa262e53_88454162')) {function content_55080faa262e53_88454162($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
?><div class="float_left">
    <?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit tickettable" id="table-search"','loop'=>$_smarty_tpl->tpl_vars['tickets']->value),$_smarty_tpl);?>

</div><?php }} ?>
