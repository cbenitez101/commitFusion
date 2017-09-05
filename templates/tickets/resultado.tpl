<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Resultado de búsqueda</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<input type="hidden" name="{$pagina}" id="pagina">
			<div class="panel-body">
				{if isset($empty)}
					<div class="row">
						<div class="col-md-4">No hay resultados</div>
						<div class="col-md-2 col-md-offset-6">
							<a href="/tickets/buscar">
								<i class="fa fa-rotate-left"></i> Volver
							</a>
						</div>
					</div>
					<div class="row">

					</div>
				{else}
				<div class="dataTable_wrapper row">
					<div class="col-md-12">
						{html_table cols=$cols  table_attr='border="0" class="tabledit tickettable hover" id="table-search" width="100%"' loop=$tickets}
					</div>
				</div>
				{/if}
			</div>
		</div>
	</div>
</div>