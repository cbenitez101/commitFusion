{if isset($busqueda)}
    <form method="GET" action="/tickets/resultado">
        <table>
            <tr>
                <th>
                    Usuario:
                </th>
                <td>
                    <input type="text" name="user" placeholder="Usuario">
                </td>
            </tr>
            <tr>
                <th>
                    Rango Fecha: 
                </th>
                <td>
                    <input type="text" name="fechainicio" id="datepicker1" placeholder="Inicio">
                </td>
                <td>
                    <input type="text" name="fechafin" id="datepicker2" placeholder="Fin">
                </td>
            </tr>
            <tr>
                <th>
                    Identificador:
                </th>
                <td>
                    <input type="text" name="identificador" placeholder="Identificador">
                </td>
            </tr>
	    {if isset($servers)}
            <tr>
                <th>
                    Servidor:
                </th>
                <td>
                    <select name="server">
                        <option value="">Elija Hotspot</option>
                        {foreach item=item from=$servers}
                            <option value="{$item}">{$item}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
	    {/if}
            <tr>
                <td>
                    <input type="submit" value="Buscar" class="ptitle"/>
                </td>
            </tr>
        </table>
    </form>
{else}
    <div>
        <table id="infoticket">
            <tr>
                <th colspan="2">
                    Informacion del Ticket
                </th>
            </tr>
            <tr>
                <td>
                    Usuario:
                </td>
                <td>
                     {$out['info']['username']}
                </td>
            </tr>
            <tr>
                <td>
                    Contraseña:
                </td>
                <td>
                    {foreach item=item from=$out['infoticket']}
                        {if $item['attribute'] == 'Cleartext-Password'}
                            {$item['value']}
                        {/if}
                    {/foreach}
                </td>
            </tr>
            {*<tr>
                <td>
                    Identificador:
                </td>
                <td>

                </td>
            </tr>*}
            <tr>
                <td>
                    Local:
                </td>
                <td>
                    {$out['plataforma']['ServerName']}
                </td>
            </tr>
            <tr>
                <td>
                    Lote:
                </td>
                <td>
                    {$out['plataforma']['Descripcion']}
                </td>
            </tr>
            <tr>
                <td>
                    Costo:
                </td>
                <td>
                    {$out['plataforma']['Costo']}€
                </td>
            </tr>
            <tr>
                <td>
                    Precio:
                </td>
                <td>
                    {$out['plataforma']['Precio']}€
                </td>
            </tr>
            <tr>
                <td>
                    Fecha Venta:
                </td>
                <td>
                    {$out['plataforma']['FechaVenta']|date_format: "%d/%m/%y %T"}
                </td>
            </tr>
            <tr>
                <td>
                    Fecha primer uso:
                </td>
                <td>
                    {$out['accounting'][0]['acctstarttime']|date_format: "%d/%m/%y %T"}
                </td>
            </tr>
            <tr>
                <td>
                    Fecha ultimo uso:
                </td>
                <td>
                    {if count($out['accounting']) > 0}
                        {if !empty($out['accounting'][count($out['accounting'])-1]['acctstoptime'])}
                            {$out['accounting'][count($out['accounting'])-1]['acctstoptime']|date_format: "%d/%m/%y %T"}
                        {else}
                            En Uso
                        {/if}
                    {/if}
                </td>
            </tr>
            <tr>
                <td>
                    Identificador:
                </td>
                <td>
                    {$out['plataforma']['identificador']}
                </td>
            </tr>
            <tr>
                <td>
                    Estado:
                </td>
                <td>
                    {*foreach item=item from=$out['infoticket']}
                        {if $item['value'] == 'Reject'}
                            <span style="background-color: red">CANCELADO </span> '{$out['plataforma']['comentario']}' '{$out['plataforma']['anulacion_usuario']} - {$out['plataforma']['anulacion_fecha']|date_format: "%d/%m/%y %T"}'
                        {elseif $item['attribute'] == 'One-All-Session'}
                            {if isset($out['accounting'][0]) && ((time() - strtotime($out['accounting'][0]['acctstarttime'])) > $item['value'])}
                                <span style="background-color: red">CONSUMIDO</span>
                            {else}
                                <span style="background-color: green">VALIDO</span>
                            {/if}
                        {elseif $item['attribute'] == 'Max-All-Mb'}
                            {if ($out['suma']['out']+$out['suma']['in']) > $item['value']}
                                <span style="background-color: red">CONSUMIDO</span>
                            {else}
                                <span style="background-color: green">VALIDO</span>
                            {/if}
                        {elseif $item['attribute'] == 'One-Daily-Session'}
                            {if ($out['suma']['out']+$out['suma']['in']) > $item['value']}
                                <span style="background-color: red">CONSUMIDO</span>
                            {else}
                                <span style="background-color: green">VALIDO</span>
                            {/if}
                        {elseif $item['attribute'] == 'Max-All-Session'}
                            {if ($out['suma']['time']) > $item['value']}
                                <span style="background-color: red">CONSUMIDO</span>
                            {else}
                                <span style="background-color: green">VALIDO</span>
                            {/if}
                        {elseif $item['attribute'] == 'Expiration'}
                            {if time() > strtotime($item['value'])}
                                <span style="background-color: red">CONSUMIDO</span>
                            {else}
                                <span style="background-color: green">VALIDO</span>
                            {/if}
                        {/if}
                    {/foreach*}
                    <span style="background-color: {if $estado == 'VALIDO'}green{else}red{/if}">{$estado}</span>{if $estado == "CANCELADO"}'{$out['plataforma']['comentario']}' '{$out['plataforma']['anulacion_usuario']} - {$out['plataforma']['anulacion_fecha']|date_format: "%d/%m/%y %T"}'{/if}
                </td>
            </tr>
        </table>
    </div>
    {*Si ya esta anulado o fuera de fecha que no se pueda anular*}
    <div>
        <script>var anula_user = "{$smarty.session.user}"</script>
        {if $estado == 'VALIDO'}
            <input type="button" value="Anular" id="anularticket" class="ptitle"/>
        {elseif $smarty.session.cliente == 'admin'}
            <input type="button" value="Desanular" id="desanularticket" class="ptitle"/>
        {/if}
        {if $smarty.session.cliente == 'admin'}
            <input type="button" value="Borrar" id="borrarticket" class="ptitle"/>
        {/if}
    </div>
    {if count($out['accounting']) > 0}
        <div>
            <div>
                Usos de tickets
            </div>
            <table>
                <thead id="tabletitle">
                    <tr>
                        <th class="">
                            Equipo
                        </th>
                        <th>
                            Inicio Sesion
                        </th>
                        <th>
                            Fin de Sesion
                        </th>
                        <th>
                            Duracion
                        </th>
                        <th>
                            Subida
                        </th>
                        <th>
                            Descarga
                        </th>
                        <th>
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody class="accountingtable">
                {foreach item=item from=$out['accounting']}
                    <tr>
                        <td>
                            {$item['callingstationid']|truncate:14:'**':true:true} {mac_vendor($item['callingstationid'])}
                        </td>
                        <td>
                            {$item['acctstarttime']}
                        </td>
                        <td>
                            {$item['acctstoptime']}
                        </td>
                        <td>
                            {intval($item['acctsessiontime'] / 86400)} Días {gmdate('H:i:s', $item['acctsessiontime'])}
                        </td>
                        <td>
                            {if $item['acctinputoctets'] > (1024*1024)}
                                {number_format((($item['acctinputoctets']/1024)/1024),0,',','.')}Mb
                            {else} 
                                {number_format(($item['acctinputoctets']/1024),0,',','.')}Kb
                            {/if}
                        </td>
                        <td>
                            {if $item['acctoutputoctets'] > (1024*1024)}
                                {number_format((($item['acctoutputoctets']/1024)/1024),0,',','.')}Mb
                            {else} 
                                {number_format(($item['acctoutputoctets']/1024),0,',','.')}Kb
                            {/if}
                        </td>
                        <td>
                            {if ($item['acctoutputoctets']+$item['acctinputoctets']) > (1024*1024)}
                                {number_format(((($item['acctoutputoctets']+$item['acctinputoctets'])/1024)/1024),0,',','.')}Mb
                            {else} 
                                {number_format((($item['acctoutputoctets']+$item['acctinputoctets'])/1024),0,',','.')}Kb
                            {/if}
                        </td>
                    </tr>
                {/foreach}
                <tr>
                    <td colspan="2">&nbsp</td>
                    <td class="ptitle">Total</td>
                    <td>
                        {intval($out['suma']['time']/86400)} Días {gmdate('H:i:s', $out['suma']['time'])}
                    </td>
                    <td>
                        {if $out['suma']['in'] > (1024*1024)}
                            {number_format((($out['suma']['in']/1024)/1024),0,',','.')}Mb
                        {else} 
                            {number_format(($out['suma']['in']/1024),0,',','.')}Kb
                        {/if}
                    </td>
                    <td>
                        {if $out['suma']['out'] > (1024*1024)}
                            {number_format((($out['suma']['out']/1024)/1024),0,',','.')}Mb
                        {else} 
                            {number_format(($out['suma']['out']/1024),0,',','.')}Kb
                        {/if}
                    </td>
                    <td>
                        {if ($out['suma']['out']+$out['suma']['in']) > (1024*1024)}
                            {number_format(((($out['suma']['out']+$out['suma']['in'])/1024)/1024),0,',','.')}Mb
                        {else} 
                            {number_format((($out['suma']['out']+$out['suma']['in'])/1024),0,',','.')}Kb
                        {/if}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    {/if}
{/if}
<div class="modal_ticket modal_ventana">
    <table>
        <tr>
            <td>
                Motivo Anulacion:
            </td>
            <td>
                <input type="text" name="ticketcancel" id="modal_ticketcancel">
            </td>
        </tr>
    </table>
</div>
