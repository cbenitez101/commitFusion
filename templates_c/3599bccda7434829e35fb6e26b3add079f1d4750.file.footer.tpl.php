<?php /* Smarty version Smarty-3.1.18, created on 2015-09-11 06:51:49
         compiled from "/volume1/web/www-sb/templates/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:56951692155e211b2ac4309-04317213%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3599bccda7434829e35fb6e26b3add079f1d4750' => 
    array (
      0 => '/volume1/web/www-sb/templates/footer.tpl',
      1 => 1441950691,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '56951692155e211b2ac4309-04317213',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e211b2b5f4a1_54695049',
  'variables' => 
  array (
    'includebody' => 0,
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e211b2b5f4a1_54695049')) {function content_55e211b2b5f4a1_54695049($_smarty_tpl) {?></div></div><?php if (count($_smarty_tpl->tpl_vars['includebody']->value)>0) {?><script type="text/javascript">/* <![CDATA[ */<?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['includebody']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?><?php echo $_smarty_tpl->tpl_vars['data']->value;?>
<?php } ?>/* ]]> */</script><?php }?></body></html><?php }} ?>
