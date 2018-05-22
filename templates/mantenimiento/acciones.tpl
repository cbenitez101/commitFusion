<div class="row">
	<div id="msgerror" class="alert alert-danger text-center">Ha habido un error y no se ha podido realizar la operación</div>
	<div id="msgexito" class="alert alert-success text-center">La operación se ha realizado con éxito</div>
</div>
<div class="row">
	<div class="col-lg-8">
		<h1 class="page-header"> Acciones</h1>
	</div>
	<!--<div class="col-lg-4">
		{if isset($creaServicio)} 
			<button type="button" id="eliminaServicio" class="btn btn-danger" style="margin-top:40px;">
				Eliminar Servicio
			</button>
		{/if}
	</div>-->

	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			{*<div class="panel-heading">*}
				{*Gastos de los hotspots*}
			{*</div>*}
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist" id="tabs">
        	        <li role="presentation" class="active">
        	            <a href="#radiustables" aria-controls="radius" role="tab" data-toggle="tab">Radius</a>
                    </li>
        	        <li role="presentation">
        	            <a href="#plataformatables" aria-controls="plataforma" role="tab" data-toggle="tab">Plataforma</a>
                    </li>
        		</ul>
				<div class="tab-content">
					
                    <div role="tabpanel" class="tab-pane active" id="radiustables">
                       <div class="form-group">
							<label>Radius</label>
							<select class="form-control" name="radiustables" id="selectradiusatables">
                                <option value="">Tablas de radius</option>
                                {foreach item=item from=$tablasrad}
                                    <option value="radius.{$item}">{$item}</option>
                                {/foreach}
							</select>
						</div>
						<div class="row">
							<div class="col-md-7">
								<button id="reparar_radius" type="submit" class="btn btn-success">Reparar</button>
								<button id="optimizar_radius" type="submit" class="btn btn-info">Optimizar</button>
							</div>
							<div class="col-md-offset-4 col-md-1">
								<!--<button type="submit" class="btn btn-warning">Backup</button>-->
							</div>
						</div>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="plataformatables">
                    	<div class="form-group">
							<label>Plataforma</label>
							<select class="form-control" name="plataformatables" id="selectplataformatables">
                                <option value="">Tablas de plataforma</option>
                                {foreach item=item from=$tablasplat}
                                    <option value="plataforma.{$item}">{$item}</option>
                                {/foreach}
							</select>
						</div>
						<div class="row">
							<div class="col-md-7">
								<button id="reparar_plataforma" type="submit" class="btn btn-success">Reparar</button>
								<button id="optimizar_plataforma" type="submit" class="btn btn-info">Optimizar</button>
							</div>
							<div class="col-md-offset-4 col-md-1">
								<!--<button id="" type="submit" class="btn btn-warning">Backup</button>-->
							</div>
						</div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

