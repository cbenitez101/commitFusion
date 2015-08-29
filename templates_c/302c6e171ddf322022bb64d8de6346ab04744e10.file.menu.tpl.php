<?php /* Smarty version Smarty-3.1.18, created on 2015-08-29 08:26:39
         compiled from "/volume1/web/www-sb/templates/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12241245755e15eaf487dd9-89515761%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '302c6e171ddf322022bb64d8de6346ab04744e10' => 
    array (
      0 => '/volume1/web/www-sb/templates/menu.tpl',
      1 => 1440829858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12241245755e15eaf487dd9-89515761',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'item' => 0,
    'key' => 0,
    'submenu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e15eaf9b8ef9_99101621',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e15eaf9b8ef9_99101621')) {function content_55e15eaf9b8ef9_99101621($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_capitalize')) include '/volume1/web/www-sb/includes/../libs/plugins/modifier.capitalize.php';
?><script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>$(document).ready(function(){
    $(".menu  .m1 span:not('.noop')").on("click", function() {window.location='<?php echo @constant('DOMAIN');?>
/' +this.textContent.toLocaleLowerCase().trim();});
    $(".menu  .m2 span").on("click", function() {window.location='<?php echo @constant('DOMAIN');?>
/'+$(this).parent().parent().prev().text().toLocaleLowerCase().trim()+'/' +this.textContent.toLocaleLowerCase().trim();});
    $(".menu .m1 span").hover(function() {$(this).next('li .m2').css('display', 'inline');});
    $('.menu').menu({position: {my:'center bottom', at:'center bottom'}});
});</script>
<ul class="menu align_center">
    <li class="m1"><span>Inicio</span></li>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_SESSION['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
    <li class="m1"><span<?php if (count($_smarty_tpl->tpl_vars['item']->value)>0) {?> class="noop" onclick="$('.menu').menu('expand');"<?php }?>><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['key']->value);?>
</span>
            <?php if (count($_smarty_tpl->tpl_vars['item']->value)>0) {?>
                <ul>
            <?php }?>
            <?php  $_smarty_tpl->tpl_vars['submenu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['submenu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['submenu']->key => $_smarty_tpl->tpl_vars['submenu']->value) {
$_smarty_tpl->tpl_vars['submenu']->_loop = true;
?>
                <li class="m2"><span><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['submenu']->value);?>
</span></li>
            <?php } ?>
            <?php if (count($_smarty_tpl->tpl_vars['item']->value)>0) {?>
                </ul>
            <?php }?>
        </li>
    <?php } ?>
    <li class="m1"><span>Salir</span></li>
</ul><?php }} ?>
