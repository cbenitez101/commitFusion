<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Clientes y Locales </h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-12">
	    <ul class="nav nav-tabs" role="tablist" id="tabs">
	        <li role="presentation" class="active">
	            <a href="#clientes" aria-controls="clientes" role="tab" data-toggle="tab">Clientes</a>
            </li>
	        <li role="presentation">
	            <a href="#locales" aria-controls="locales" role="tab" data-toggle="tab">Locales</a>
            </li>
	    </ul>
	    <div class="tab-content">
	        <div role="tabpanel" class="tab-pane active" id="clientes">
    	        <div class="panel panel-default">
        			<div class="panel-heading">
        				Clientes
        			</div>
        			<!-- /.panel-heading -->
        			<div class="panel-body">
        				<div class="dataTable_wrapper row">
        					<div class="col-md-12">
        						{html_table cols=$cols  table_attr='border="0" class="tabledit userstable hover"
        						id="table-search" width="100%"' loop=$clientes}
        					</div>
        				</div>
        				<div class="row">
        					<div class="col-md-1 col-md-offset-11">
        						<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">
        							Crear
        						</button>
        					</div>
        				</div>
        				<div class="modal fade" id="modal_cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        					<div class="modal-dialog modal-lg">
        						<div class="modal-content">
        							<div class="modal-header">
        								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        								<h4 class="modal-title">Lote</h4>
        							</div>
        							<div class="modal-body">
        								<form role="form">
        									<input class="perfil" type="hidden" name="loteid" id="modal_clienteid">
        						            <div class="form-group">
        										<label>Id Hotspot</label>
        										<select class="form-control" name="idlote" id="modal_loteidperfil">
        											<option value="">Perfil</option>
                                                    {foreach item=item from=$local}
                                                        <option value="{$item.id}" data-duracion="{$item.Duracion}">{$item.ServerName}</option>
                                                    {/foreach}
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
    	    <div role="tabpanel" class="tab-pane" id="locales">
    	        <div class="panel panel-default">
        			<div class="panel-heading">
        				Locales
        			</div>
        			<!-- /.panel-heading -->
        			<div class="panel-body">
        				<div class="dataTable_wrapper row">
        					<div class="col-md-12">
        						{html_table cols=$cols  table_attr='border="0" class="tabledit localestable hover"
        						id="table-search" width="100%"' loop=$locales}
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
                                                    {foreach item=item from=$local}
                                                        <option value="{$item.id}" data-duracion="{$item.Duracion}">{$item.ServerName}</option>
                                                    {/foreach}
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
	    </div>	
	</div>
</div>

{*strip}
<form method="POST" id="fpermisos">
    <div id="permisotabla" class="float_left">
        <div class="input-filter-container"><label for="input-filter">Buscar:</label> <input type="search" id="input-filter" size="15" placeholder="search"></div>
        {html_table cols="Id, Nombre, Email" table_attr='border="0" class="tabledit" id="table-search"' loop=$users tr_attr=$tr}
        <input type="hidden" name="user" id="pusuarios" value="{$id}">
    </div>
    <div id="permisos" class="float_left">
        <div class="ptitle">Clientes &nbsp; &nbsp; Locales</div>
        {foreach item=cliente key=cnombre from=$permisos}
            <div class="cliente">
                &#x25B6;
                <input type="checkbox" cliente="{$cliente.id}" name="cliente[]" value="" {if in_array($id,$cliente['usuarios'])} checked="checked"{/if}/>{$cnombre}
                {if count($cliente['locales'])>0}
                    {foreach item=local key=lnombre from=$cliente.locales}
                        <div class="local">
                            <input type="checkbox" cliente="{$cliente.id}" local="{$local.id}" name="locales[{$cliente.id}][]" value="" {if in_array($id,$local['usuarios'])} checked="checked"{/if}/>{$lnombre}
                        </div>
                    {/foreach}
                {/if}
            </div>
        {/foreach}
    </div>
    <div class="float_clear"></div>
</form>
{/strip*}

    