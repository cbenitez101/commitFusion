<?php /* Smarty version Smarty-3.1.18, created on 2015-10-24 09:16:45
         compiled from "/volume1/web/www-sb/templates/inicio.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28058219955e3d88218e457-92466707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd52702cd08c482049784be8e48040c933fd76d31' => 
    array (
      0 => '/volume1/web/www-sb/templates/inicio.tpl',
      1 => 1445674413,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28058219955e3d88218e457-92466707',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e3d8821cf704_46047356',
  'variables' => 
  array (
    'cols' => 0,
    'users' => 0,
    'gastos' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e3d8821cf704_46047356')) {function content_55e3d8821cf704_46047356($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/volume1/web/www-sb/includes/../libs/plugins/function.html_table.php';
?><div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Usuarios conectados
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper row">
					<div class="col-md-12">
						<?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit conectadostable hover"
						id="table-search" width="100%"','loop'=>$_smarty_tpl->tpl_vars['users']->value),$_smarty_tpl);?>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Otra cosa
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper row">
					<div class="col-md-12">
						<?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit gastotable hover"
						id="table-search" width="100%"','loop'=>$_smarty_tpl->tpl_vars['gastos']->value),$_smarty_tpl);?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div><?php }} ?>
