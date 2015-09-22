<?php /* Smarty version Smarty-3.1.18, created on 2015-09-11 06:51:58
         compiled from "/volume1/web/www-sb/templates/contabilidad/gastos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:197977658655e3f0d74fdce9-77243566%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b3ff55febe05f59aa5daba98a01e0d2073539c14' => 
    array (
      0 => '/volume1/web/www-sb/templates/contabilidad/gastos.tpl',
      1 => 1441950691,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '197977658655e3f0d74fdce9-77243566',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e3f0d76022b6_52546150',
  'variables' => 
  array (
    'cols' => 0,
    'gastos' => 0,
    'hotspot' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e3f0d76022b6_52546150')) {function content_55e3f0d76022b6_52546150($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/volume1/web/www-sb/includes/../libs/plugins/function.html_table.php';
?><div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Gastos de los hotspots</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			
				
			
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper row">
					<div class="col-md-12">
						<?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit gastotable" id="table-search"','loop'=>$_smarty_tpl->tpl_vars['gastos']->value),$_smarty_tpl);?>

					</div>
				</div>
				<div class="row">
					<div class="col-md-1 col-md-offset-11">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">
							Crear
						</button>
					</div>
				</div>
				<div class="modal fade" id="modal_gasto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Gastos</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<input type="hidden" name="gastoid" id="modal_gastoid">
									<div class="form-group">
										<label>Hotspot</label>
										<select class="form-control" name="gastohotspot" id="modal_gastohotspot">
											<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hotspot']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['item']->value[0];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
</option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label>Cantidad</label>
										<input class="form-control" name="gastocantidad" id="modal_gastocantidad">
									</div>
									<div class="form-group">
										<label>Descripción</label>
										<input class="form-control" name="gastodescripcion" id="modal_gastodescripcion">
									</div>
									<div class="form-group">
										<label>Precio</label>
										<input class="form-control" name="gastoprecio" id="modal_gastogastoprecio">
									</div>
								</form>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="button" class="btn btn-danger action" data-dismiss="modal">Eliminar</button>
								<button type="button" class="btn btn-primary action" data-dismiss="modal">Guardar</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
		</div>
	</div>
</div>

<?php }} ?>
