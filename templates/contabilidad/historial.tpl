<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Historial de Informes</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			{*<div class="panel-heading">*}
				{*Historial de Informes*}
			{*</div>*}
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
					{html_table cols=$cols  table_attr='border="0" class="tabledit hisorialtable hover"
					id="table-search"'	loop=$tabla}
				</div>
			</div>
		</div>
	</div>
</div>