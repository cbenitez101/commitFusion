<?php /* Smarty version Smarty-3.1.18, created on 2014-10-16 15:48:04
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1778088191543fdaa4311822-36062586%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '741b4844abe28c4c51d33e37f9c928cac748153f' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/footer.tpl',
      1 => 1397478252,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1778088191543fdaa4311822-36062586',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'includebody' => 0,
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_543fdaa432ceb6_62132947',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_543fdaa432ceb6_62132947')) {function content_543fdaa432ceb6_62132947($_smarty_tpl) {?><?php if (count($_smarty_tpl->tpl_vars['includebody']->value)>0) {?><script type="text/javascript">/* <![CDATA[ */<?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['includebody']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
?><?php echo $_smarty_tpl->tpl_vars['data']->value;?>
<?php } ?>/* ]]> */</script><?php }?></body></html><?php }} ?>
