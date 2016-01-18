<?php /* Smarty version Smarty-3.1.18, created on 2016-01-18 11:31:58
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/lotes.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1019356165569cbf1eb55210-87119080%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e27b6f06b2198d368313ea840e78168122290168' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/lotes.tpl',
      1 => 1453111140,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1019356165569cbf1eb55210-87119080',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cols' => 0,
    'lotes' => 0,
    'local' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_569cbf1ebae553_85719554',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569cbf1ebae553_85719554')) {function content_569cbf1ebae553_85719554($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
?><div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Lotes</h1>
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
						<?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit lotestable hover"
						id="table-search" width="100%"','loop'=>$_smarty_tpl->tpl_vars['lotes']->value),$_smarty_tpl);?>

					</div>
				</div>
				<div class="row">
					<div class="col-md-1 col-md-offset-11">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">
							Crear
						</button>
					</div>
				</div>
				<div class="modal fade" id="modal_lote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Lote</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<input class="perfil" type="hidden" name="loteid" id="modal_loteid">
						            <div class="form-group">
										<label>Id Hotspot</label>
										<select class="form-control" name="idlote" id="modal_loteidperfil">
											<option value="">Perfil</option>
                                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['local']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" data-duracion="<?php echo $_smarty_tpl->tpl_vars['item']->value['Duracion'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['ServerName'];?>
</option>
                                            <?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label>Duración</label>
										<select class="form-control" name="duracion" id="modal_loteduracion" disabled>
											<option value="">Seleccione una duración</option>
                                            <option value="300">5 minutos</option>
                                            <option value="600">10 minutos</option>
                                            <option value="900">15 minutos</option>
                                            <option value="1800">30 minutos</option>
                                            <option value="3600">1 hora</option>
                                            <option value="7200">2 horas</option>
                                            <option value="14400">4 horas</option>
                                            <option value="21600">6 horas</option>
                                            <option value="28800">8 horas</option>
                                            <option value="43200">12 horas</option>
                                            <option value="86400">1 día</option>
                                            <option value="172800">2 días</option>
                                            <option value="259200">3 días</option>
                                            <option value="345600">4 días</option>
                                            <option value="432000">5 días</option>
                                            <option value="518400">6 días</option>
                                            <option value="604800">7 días</option>
                                            <option value="691200">8 días</option>
                                            <option value="777600">9 días</option>
                                            <option value="864000">10 días</option>
                                            <option value="950400">11 días</option>
                                            <option value="1036800">12 días</option>
                                            <option value="1123200">13 días</option>
                                            <option value="1209600">14 días</option>
                                            <option value="1296000">15 días</option>
                                            <option value="1382400">16 días</option>
                                            <option value="1468800">17 días</option>
                                            <option value="1555200">18 días</option>
                                            <option value="1641600">19 días</option>
                                            <option value="1728000">20 días</option>
                                            <option value="1814400">21 días</option>
                                            <option value="1900800">22 días</option>
                                            <option value="1987200">23 días</option>
                                            <option value="2073600">24 días</option>
                                            <option value="2160000">25 días</option>
                                            <option value="2246400">26 días</option>
                                            <option value="2332800">27 días</option>
                                            <option value="2419200">28 días</option>
                                            <option value="2505600">29 días</option>
                                            <option value="2592000">30 días</option>
                                            <option value="2678400">31 días</option>
                                            <option value="5184000">2 meses</option>
                                            <option value="7776000">3 meses</option>
                                            <option value="10368000">4 meses</option>
                                            <option value="12960000">5 meses</option>
                                            <option value="15552000">6 meses</option>
                                            <option value="18144000">7 meses</option>
                                            <option value="20736000">8 meses</option>
                                            <option value="23328000">9 meses</option>
                                            <option value="25920000">10 meses</option>
                                            <option value="28512000">11 meses</option>
                                            <option value="31104000">1 año</option>
										</select>
									</div>
									<div class="form-group">
										<label>Costo</label>
										<input class="form-control" name="Costo" id="modal_lotecosto">
									</div>
									<div class="form-group">
										<label>Precio</label>
										<input class="form-control" name="precio" id="modal_loteprecio">
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
</div><?php }} ?>
