<?php /* Smarty version Smarty-3.1.18, created on 2015-09-11 06:51:49
         compiled from "/volume1/web/www-sb/templates/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:154520906755e3d881e2cfa9-83312546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '302c6e171ddf322022bb64d8de6346ab04744e10' => 
    array (
      0 => '/volume1/web/www-sb/templates/menu.tpl',
      1 => 1441950691,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '154520906755e3d881e2cfa9-83312546',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e3d88214e1b0_15955925',
  'variables' => 
  array (
    'key' => 0,
    'item' => 0,
    'submenu' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e3d88214e1b0_15955925')) {function content_55e3d88214e1b0_15955925($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_capitalize')) include '/volume1/web/www-sb/includes/../libs/plugins/modifier.capitalize.php';
?><div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<img class="navbar-brand"src="<?php echo @constant('DOMAIN');?>
/images/logos/<?php echo $_SESSION['cliente'];?>
<?php if (isset($_SESSION['local'])) {?>.<?php echo $_SESSION['local'];?>
<?php }?>.png" />
		</div>

		<ul class="nav navbar-top-links navbar-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-user">
					
					
					
					
					
					<li><a href="/salir"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
					</li>
				</ul>
				<!-- /.dropdown-user -->
			</li>
		</ul>
		<div class="navbar-default sidebar" role="navigation">
			<div class="sidebar-nav navbar-collapse">
				<ul class="nav" id="side-menu">
					<li>
						<a href="/inicio"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
					</li>
					<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_SESSION['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
						<li>
							<a href="#">
								<i class="fa
								 <?php if ($_smarty_tpl->tpl_vars['key']->value=='configuracion') {?>
									fa-gear
								<?php } elseif ($_smarty_tpl->tpl_vars['key']->value=='tickets') {?>
									fa-ticket
								<?php } elseif ($_smarty_tpl->tpl_vars['key']->value=='contabilidad') {?>
									fa-bar-chart-o
								<?php }?>
								 fa-fw"></i>
								<?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['key']->value);?>
<?php if (count($_smarty_tpl->tpl_vars['item']->value)>0) {?><span class="fa arrow"></span><?php }?></a>
							<?php if (count($_smarty_tpl->tpl_vars['item']->value)>0) {?>
							<ul class="nav nav-second-level">
							<?php }?>
							<?php  $_smarty_tpl->tpl_vars['submenu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['submenu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['submenu']->key => $_smarty_tpl->tpl_vars['submenu']->value) {
$_smarty_tpl->tpl_vars['submenu']->_loop = true;
?>
								<li>
									<a href="/<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['submenu']->value;?>
"><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['submenu']->value);?>
</a>
								</li>
							<?php } ?>
							<?php if (count($_smarty_tpl->tpl_vars['item']->value)>0) {?>
							</ul>
							<?php }?>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>
	<div id="page-wrapper">






	




    
    
    
    


    
    
    
            
                
            
            
                
            
            
                
            
        
    
    
<?php }} ?>