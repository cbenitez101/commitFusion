<?php /* Smarty version Smarty-3.1.18, created on 2015-01-01 11:43:49
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/permisos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:480212673546e44984290c3-93407311%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '19ad259ea25158ba02aa58d66021bd578742daf9' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/permisos.tpl',
      1 => 1418856851,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '480212673546e44984290c3-93407311',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_546e4498522c65_22369406',
  'variables' => 
  array (
    'users' => 0,
    'tr' => 0,
    'id' => 0,
    'permisos' => 0,
    'cliente' => 0,
    'cnombre' => 0,
    'local' => 0,
    'lnombre' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_546e4498522c65_22369406')) {function content_546e4498522c65_22369406($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
?><form method="POST" id="fpermisos"><div id="permisotabla" class="float_left"><div class="input-filter-container"><label for="input-filter">Buscar:</label> <input type="search" id="input-filter" size="15" placeholder="search"></div><?php echo smarty_function_html_table(array('cols'=>"Id, Nombre, Email",'table_attr'=>'border="0" class="tabledit" id="table-search"','loop'=>$_smarty_tpl->tpl_vars['users']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tr']->value),$_smarty_tpl);?>
<input type="hidden" name="user" id="pusuarios" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"></div><div id="permisos" class="float_left"><div class="ptitle">Clientes &nbsp; &nbsp; Locales</div><?php  $_smarty_tpl->tpl_vars['cliente'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cliente']->_loop = false;
 $_smarty_tpl->tpl_vars['cnombre'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['permisos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cliente']->key => $_smarty_tpl->tpl_vars['cliente']->value) {
$_smarty_tpl->tpl_vars['cliente']->_loop = true;
 $_smarty_tpl->tpl_vars['cnombre']->value = $_smarty_tpl->tpl_vars['cliente']->key;
?><div class="cliente">&#x25B6;<input type="checkbox" cliente="<?php echo $_smarty_tpl->tpl_vars['cliente']->value['id'];?>
" name="cliente[]" value="" <?php if (in_array($_smarty_tpl->tpl_vars['id']->value,$_smarty_tpl->tpl_vars['cliente']->value['usuarios'])) {?> checked="checked"<?php }?>/><?php echo $_smarty_tpl->tpl_vars['cnombre']->value;?>
<?php if (count($_smarty_tpl->tpl_vars['cliente']->value['locales'])>0) {?><?php  $_smarty_tpl->tpl_vars['local'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['local']->_loop = false;
 $_smarty_tpl->tpl_vars['lnombre'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cliente']->value['locales']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['local']->key => $_smarty_tpl->tpl_vars['local']->value) {
$_smarty_tpl->tpl_vars['local']->_loop = true;
 $_smarty_tpl->tpl_vars['lnombre']->value = $_smarty_tpl->tpl_vars['local']->key;
?><div class="local"><input type="checkbox" cliente="<?php echo $_smarty_tpl->tpl_vars['cliente']->value['id'];?>
" local="<?php echo $_smarty_tpl->tpl_vars['local']->value['id'];?>
" name="locales[<?php echo $_smarty_tpl->tpl_vars['cliente']->value['id'];?>
][]" value="" <?php if (in_array($_smarty_tpl->tpl_vars['id']->value,$_smarty_tpl->tpl_vars['local']->value['usuarios'])) {?> checked="checked"<?php }?>/><?php echo $_smarty_tpl->tpl_vars['lnombre']->value;?>
</div><?php } ?><?php }?></div><?php } ?></div><div class="float_clear"></div></form>

    <?php }} ?>
