{if $smarty.session.cliente == 'admin'}
    <div>
        <div class="title">
            Crea bloc
        </div>
        <div>
            <form action="" method="POST">
                <div>
                    Hotspot
                </div>
                <div>
                    
                </div>
            </form>
        </div>
    </div>
{else}
<div>
    {foreach item=item from=$tickets}
        <div class="ticket" {foreach item=data key=key from=$item}{if ($key != 'duraciontexto')} data-{$key}="{$data}"{/if}{/foreach}><p>{$item['duraciontexto']}</p><p>{$item['Precio']}€</p></div>
    {/foreach}
</div>
<div class="ticket-crear">
    <button style="visibility: hidden;" class="btnPrint"/>
</div>
<div class="modal_creaticket modal_ventana">
    <table>
        <tr>
            <td>
                Numero de habitacion:
            </td>
            <td>
                <input type="text" name="ticketident" id="modal_ticketid">
            </td>
        </tr>
    </table>
</div>
{/if}