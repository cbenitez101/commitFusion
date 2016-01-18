<?php /* Smarty version Smarty-3.1.18, created on 2016-01-18 11:31:52
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2075843936569cbf182830a1-62196675%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd717c9ef6665efd5fd1843feb6b0f8a1129b650b' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/menu.tpl',
      1 => 1453111140,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2075843936569cbf182830a1-62196675',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cols' => 0,
    'users' => 0,
    'menus' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_569cbf182cfa23_26632900',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569cbf182cfa23_26632900')) {function content_569cbf182cfa23_26632900($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
?><div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Menus</h1>
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
						<?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit menutable hover"
						id="table-search" width="100%"','loop'=>$_smarty_tpl->tpl_vars['users']->value),$_smarty_tpl);?>

					</div>
				</div>
				<div class="row">
					<div class="col-md-1 col-md-offset-10">
						<button type="button" class="btn btn-danger action" data-toggle="modal" data-target="#modal_borrar">Eliminar</button>
					</div>
					<div class="col-md-1">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_menu">
							Crear
						</button>
					</div>
				</div>
				<div class="modal fade" id="modal_menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Menu</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<div class="form-group">
										<label>Nombre</label>
										<input  class="form-control" name="menuname" id="modal_menuname">
									</div>
								</form>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="button" class="btn btn-primary action" data-dismiss="modal">Guardar</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<div class="modal fade" id="modal_borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Menu</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<div class="form-group">
										<label>borrar</label>
										<select class="form-control" name="menuname" id="modal_menunameborrar">
                                            <option value="">Menu</option>
                                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                                            <?php } ?>
										</select>
									</div>
								</form>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="button" class="btn btn-danger action" data-dismiss="modal">Eliminar</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
		</div>
	</div>
</div>


<?php }} ?>
