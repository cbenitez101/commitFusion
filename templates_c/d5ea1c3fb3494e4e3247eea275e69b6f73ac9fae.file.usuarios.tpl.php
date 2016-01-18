<?php /* Smarty version Smarty-3.1.18, created on 2016-01-18 11:30:52
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/usuarios.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1034130528569cbedc805629-23924564%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd5ea1c3fb3494e4e3247eea275e69b6f73ac9fae' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/usuarios.tpl',
      1 => 1453111140,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1034130528569cbedc805629-23924564',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cols' => 0,
    'usuarios' => 0,
    'colu' => 0,
    'tabla' => 0,
    'colmenu' => 0,
    'tablamenu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_569cbedc82e576_52668418',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569cbedc82e576_52668418')) {function content_569cbedc82e576_52668418($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
?><div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Usuarios</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-12">
	    <div class="tab-content">
	        <div class="panel panel-default">
    			
    			<!-- /.panel-heading -->
    			<div class="panel-body">
    				<div class="dataTable_wrapper row">
    					<div class="col-md-12">
    						<?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit userstable hover"
    						id="table-search" width="100%"','loop'=>$_smarty_tpl->tpl_vars['usuarios']->value),$_smarty_tpl);?>

    					</div>
    				</div>
    				<div class="row">
    					<div class="col-md-1 col-md-offset-11">
    						<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">
    							Crear
    						</button>
    					</div>
    				</div>
    				<div class="modal fade" id="modal_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    					<div class="modal-dialog modal-lg">
    						<div class="modal-content">
    							<div class="modal-header">
    								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    								<h4 class="modal-title">Cuenta</h4>
    							</div>
    							<div class="modal-body">
    								<form data-toggle="validator" role="form">
    								    <div class="row">
    								        <div class="col-md-4">
    								            <input class="perfil" type="hidden" name="usuarioid" id="modal_usuarioid">
            									<div class="form-group">
            										<label>Nombre</label>
            										<input class="form-control" name="nombre" id="modal_usuarionombre" required>
            										<div class="help-block with-errors"></div>
            									</div>
            									<div class="form-group">
            										<label>E-Mail</label>
            										<input type="email" class="form-control" name="email" id="modal_usuarioemail" required>
            										<div class="help-block with-errors"></div>
            									</div>
            									<div class="form-group">
            										<label>
            										    Contraseña
            										</label>
            										<i id="passrefresh" class="fa fa-refresh" style="margin-left: 5px;"></i>
        										    <input id="modal_usuariopasssend" type="checkbox" name="enviapass" style="margin-left: 20px;">
        										    <i class="fa fa-envelope-o"></i>
            										<input class="form-control" name="pass" id="modal_usuariopass">
            									</div>
    								        </div><!-- /.col-md-4 -->
    								        <div class="col-md-8" id="tabholder">
    								            <ul class="nav nav-tabs" role="tablist" id="tabs">
                                        	        <li role="presentation" class="active">
                                        	            <a href="#permiso" aria-controls="permiso" role="tab" data-toggle="tab">Permisos</a>
                                                    </li>
                                        	        <li role="presentation">
                                        	            <a href="#menu" aria-controls="menu" role="tab" data-toggle="tab">Menú</a>
                                                    </li>
                                        	    </ul>
                                        	    <div class="tab-content">
	                                                <div role="tabpanel" class="tab-pane active" id="permiso">
	                                                    <?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['colu']->value,'table_attr'=>'border="0" class="tabledit permisostable hover" id="table-permisos" width="100%"','loop'=>$_smarty_tpl->tpl_vars['tabla']->value),$_smarty_tpl);?>

	                                                </div>
	                                                <div role="tabpanel" class="tab-pane" id="menu">
	                                                    <?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['colmenu']->value,'table_attr'=>'border="0" class="tabledit menutable hover" id="table-menu" width="100%"','loop'=>$_smarty_tpl->tpl_vars['tablamenu']->value),$_smarty_tpl);?>

	                                                </div>
                                                </div>
    								        </div><!-- /.col-md-8 -->
    								    </div><!-- /.row -->
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
</div><?php }} ?>
