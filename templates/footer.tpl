{* The end of each page *}{strip}
{if count($includebody)>0}
    <script type="text/javascript">
/* <![CDATA[ */
    {foreach item=data from=$includebody}
        {$data}
    {/foreach}
/* ]]> */
     </script>
 {/if}
</body>
</html>{/strip}