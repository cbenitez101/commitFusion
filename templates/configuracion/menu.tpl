<form method="POST">
    <div>
        Añadir menu: <input type="text" name="table_name"><input class="ui-button" type="submit" value="Crear" name="create_table" />
    </div>
</form>
<div class="float_left" id="confmenu">
    {html_table cols=$cols  table_attr='border="0" class="tabledit" id="table-search"' loop=$users}
</div>

<div class="menueliminar">
    <div>¿Desea realemente eliminar el menu?</div>
</div>