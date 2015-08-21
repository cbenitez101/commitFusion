<form method="POST">
    <div id="perfiles" class="perfiles">
        Añadir Perfil:
        <select name="per_0" id="selectsn">
            <option>Id Hotspot</option>
            {foreach item=item from=$local}
                <option value="{$item.id}">{$item.ServerName}</option>
            {/foreach}
        </select>
        <input type="text" name="per_1" placeholder="Descripción">
        <select type="text" name="per_2">
            <option>Seleccione un periodo</option>
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
        <select name="per_3">
            <option>Movilidad</option>
            <option value="Called_Station-Id">No</option>
            <option value="WISPr-Location-Name">Si</option>
        </select>
        <input type="text" name="per_4" id="inputsn" placeholder="ServerName" readonly="readonly" >
        <select name="per_5">
            <option>Modo Consumo</option>
            <option value="One-All-Session">Continuo</option>
            <option value="Max-All-Session">Real</option>
            <option value="Max-All-Mb">Megas</option>
            <option value="One-Daily-Session">Diario</option>
        </select>
        <input type="text" name="per_6" placeholder="Acct-Interim-Interval">
        <input type="text" name="per_7" placeholder="Idle-Timeout">
        <input type="text" name="per_8" placeholder="Simultaneous-Use">
        <input type="text" name="per_9" placeholder="Login-Time">
        <input type="text" name="per_10" id="datepicker" placeholder="Expiration">
        <input type="text" name="per_11" placeholder="WISPr-Bandwidth-Max-Down">
        <input type="text" name="per_12" placeholder="WISPr-Bandwidth-Max-Up">
        <input type="text" name="per_13" placeholder="TraficoDescarga">
        <input type="text" name="per_14" placeholder="Password">
        <input class="ui-button" type="submit" value="Crear" name="create_perfil" />
    </div>
</form>
<div class="float_left">
    {html_table cols=$cols  table_attr='border="0" class="tabledit perfiltable" id="table-search"' loop=$perfiles}
</div>
<div class="modal_perfil modal_ventana">
    <input type="hidden" name="serverid" id="modal_perfilid">
    <table>
        <tr>
            <td>
                Id Hotspot:
            </td>
            <td>
                <select name="per_0" id="per_0">
                    <option>Id Hotspot</option>
                    {foreach item=item from=$local}
                        <option value="{$item.id}">{$item.ServerName}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td>
                ServerName:
            </td>
            <td>
                <input type="text" name="per_1" id="per_1" placeholder="ServerName"  disabled = "disabled" >
            </td>
        </tr>
        <tr>
            <td>
                Descripción:
            </td>
            <td>
                <input type="text" name="per_2" id="per_2" placeholder="Descripción">
            </td>
        </tr>
        <tr>
            <td>
                Duración:
            </td>
            <td>
                <select type="text" name="per_3" id="per_3">
                    <option>Seleccione un periodo</option>
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
            </td>
        </tr>
        <tr>
            <td>
                Movilidad:
            </td>
            <td>
                <select name="per_4" id="per_4">
                    <option>Movilidad</option>
                    <option value="Called_Station-Id">No</option>
                    <option value="WISPr-Location-Name">Si</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Modo Consumo:
            </td>
            <td>
                <select name="per_5" id="per_5">
                    <option>Modo Consumo</option>
                    <option value="One-All-Session">Continuo</option>
                    <option value="Max-All-Session">Real</option>
                    <option value="Max-All-Mb">Megas</option>
                    <option value="One-Daily-Session">Diario</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Acct-Interim-Interval:
            </td>
            <td>
                <input type="text" name="per_6" id="per_6" placeholder="Acct-Interim-Interval">
            </td>
        </tr>
        <tr>
            <td>
                Idle-Timeout:
            </td>
            <td>
                <input type="text" name="per_7" id="per_7" placeholder="Idle-Timeout">
            </td>
        </tr>
        <tr>
            <td>
                Simultaneous-Use:
            </td>
            <td>
                <input type="text" name="per_8" id="per_8" placeholder="Simultaneous-Use">
            </td>
        </tr>
        <tr>
            <td>
                Login-Time:
            </td>
            <td>
                <input type="text" name="per_9" id="per_9" placeholder="Login-Time">
            </td>
        </tr>
        <tr>
            <td>
                Expiration:
            </td>
            <td>
                <input type="text" name="per_10" id="per_10" placeholder="Expiration">
            </td>
        </tr>
        <tr>
            <td>
                WISPr-Bandwidth-Max-Down:
            </td>
            <td>
                <input type="text" name="per_11" id="per_11" placeholder="WISPr-Bandwidth-Max-Down">
            </td>
        </tr>
        <tr>
            <td>
                WISPr-Bandwidth-Max-Up
            </td>
            <td>
                <input type="text" name="per_12" id="per_12" placeholder="WISPr-Bandwidth-Max-Up">
            </td>
        </tr>
        <tr>
            <td>
                TraficoDescarga:
            </td>
            <td>
                <input type="text" name="per_13" id="per_13" placeholder="TraficoDescarga">
            </td>
        </tr>
        <tr>
            <td>
                Password:
            </td>
            <td>
                <input type="text" name="per_14" id="per_14" placeholder="Password">
            </td>
        </tr>
    </table>
</div>