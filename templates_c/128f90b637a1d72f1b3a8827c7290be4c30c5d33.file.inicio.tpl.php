<?php /* Smarty version Smarty-3.1.18, created on 2016-01-18 11:03:03
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/inicio.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1616982133569cb857f2a3a4-85955872%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '128f90b637a1d72f1b3a8827c7290be4c30c5d33' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/inicio.tpl',
      1 => 1453111140,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1616982133569cb857f2a3a4-85955872',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cols' => 0,
    'users' => 0,
    'gastos' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_569cb857f40684_46387076',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569cb857f40684_46387076')) {function content_569cb857f40684_46387076($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
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
