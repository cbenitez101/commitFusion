<form method="POST">
    <div>
        Añadir Hotspot:
        <input type="text" name="hot_name" placeholder="ServerName">
        <input type="text" name="hot_number" placeholder="ServerNumber">
        <select name="hot_status">
            <option>Status</option>
            <option value="BLOCKED">BLOCKED</option>
            <option value="ONLINE">ONLINE</option>
            <option value="MAINTENANCE">MAINTENANCE</option>
        </select>
        <select name="hot_local">
            <option>Local</option>
            {foreach item=item from=$local}
                <option value="{$item.0}">{$item.1}</option>
            {/foreach}
        </select>
        <select name="hot_informe">
                <option>Informe</option>
                <option value="1">No Informe</option>
                <option value="2">Estadistica</option>
                <option value="3">Por Tickets</option>
        </select>
        <select name="hot_si">
            <option>Cliente</option>
            {foreach item=item from=$si}
                <option value="{$item['id']}">{$item['name']}</option>
            {/foreach}
        </select>
        <input class="ui-button" type="submit" value="Crear" name="create_hot" />
    </div>
</form>
<div class="float_left">
    {html_table cols=$cols  table_attr='border="0" class="tabledit hotspottable" id="table-search"' loop=$hotspot}
</div>
<div class="modal_hotspot modal_ventana">
    <input type="hidden" name="serverid" id="modal_serverid">
    <table>
        <tr>
            <td>
                ServerName:
            </td>
            <td>
                <input type="text" name="servername" id="modal_servername">
            </td>
        </tr>
        <tr>
            <td>
                ServerNumber:
            </td>
            <td>
                <input type="text" name="serialnumber" id="modal_servernumber">
            </td>
        </tr>
        <tr>
            <td>
                Status:
            </td>
            <td>
                <select name="serverstatus" id="modal_serverstatus">
                    <option>Select</option>
                    <option value="online">ONLINE</option>
                    <option value="blocked">BLOCKED</option>
                    <option value="maintenance">MAINTENANCE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Local:
            </td>
            <td>
                <select name="serverlocal" id="modal_serverlocal">
                    <option>Local</option>
                    {foreach item=item from=$local}
                        <option value="{$item.0}">{$item.1}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Tipo Informe:
            </td>
            <td>
                <select name="serverinforme" id="modal_serverinforme">
                        <option>Tipo</option>
                        <option value="1">No Informe</option>
                        <option value="2">Estadistica</option>
                        <option value="3">Por Tickets</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Cliente:
            </td>
            <td>
                <select name="serversi" id="modal_serversi">
                    <option>Cliente</option>
                        {foreach item=item from=$si}
                            <option value="{$item['id']}">{$item['name']}</option>
                        {/foreach}
                </select>
            </td>
        </tr>
    </table>
</div>