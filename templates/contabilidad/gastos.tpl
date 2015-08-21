<form method="POST">
    <div>
        Añadir Gastos:
        <select name="gasto_hotspot">
            <option>HotSpot</option>
            {foreach item=item from=$hotspot }
                <option value="{$item.0}">{$item.1}</option>
            {/foreach}
        </select>
        <input type="text" name="gasto_cantidad" placeholder="Cantidad">
        <input type="text" name="gasto_descripcion" placeholder="Descripcion">
        <input type="text" name="gasto_precio" placeholder="Precio">
        <input class="ui-button" type="submit" value="Crear" name="create_gasto" />
    </div>
</form>
<div class="float_left">
    {html_table cols=$cols  table_attr='border="0" class="tabledit gastotable" id="table-search"' loop=$gastos}
</div>
<div class="modal_gasto modal_ventana">
    <input type="hidden" name="gastoid" id="modal_gastoid">
    <table>
        <tr>
            <td>
                Hotspot:
            </td>
            <td>
                <select name="gastohotspot" id="modal_gastohotspot">
                    {foreach item=item from=$hotspot }
                        <option value="{$item.0}">{$item.1}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Cantidad:
            </td>
            <td>
                <input type="text" name="gastocantidad" id="modal_gastocantidad">
            </td>
        </tr>
        <tr>
            <td>
                Descripción:
            </td>
            <td>
                <input type="text" name="gastodescripcion" id="modal_gastodescripcion">
            </td>
        </tr>
        <tr>
            <td>
                Precio:
            </td>
            <td>
                <input type="text" name="gastoprecio" id="modal_gastoprecio">
            </td>
        </tr>
    </table>
</div>