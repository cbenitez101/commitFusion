<?php /* Smarty version Smarty-3.1.18, created on 2016-01-18 11:07:48
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/contabilidad/historial.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1947781457569cb974a3d0d7-47883394%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15d390cace7f984913cb6ccdc44b4960aa216cdb' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/contabilidad/historial.tpl',
      1 => 1453111140,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1947781457569cb974a3d0d7-47883394',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cols' => 0,
    'tabla' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_569cb974a4d0c0_97810589',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569cb974a4d0c0_97810589')) {function content_569cb974a4d0c0_97810589($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
?><div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Historial de Informes</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			
				
			
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit hisorialtable hover"
					id="table-search"','loop'=>$_smarty_tpl->tpl_vars['tabla']->value),$_smarty_tpl);?>

				</div>
			</div>
		</div>
	</div>
</div><?php }} ?>
