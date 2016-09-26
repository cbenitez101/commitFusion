
$(document).ready(function(){
    //Eliminamos el menu del dash del contenido del iframe
    $('.dash_iframe').load(function(){
        // $('.dash_iframe').contents().find('nav').hide();
        // $('.dash_iframe').contents().find('.graficas').hide();
        $('.dash_iframe').contents().find('nav').addClass('displaynone');
        $('.dash_iframe').contents().find('.graficas').addClass('displaynone');
        var contheight = $('.contabilidad\\/estadisticas').contents().find('#page-wrapper').height();
        var buscarheight = $('.tickets\\/buscar').contents().find('#page-wrapper').height();
        var crearheight = $('.tickets\\/crear').contents().find('#page-wrapper').height();
        $('.contabilidad\\/estadisticas').css('height',contheight);
        $('.tickets\\/buscar').css('height',buscarheight);
        $('.tickets\\/crear').css('height',crearheight);
        $('#buscar').css('margin-left','21px');
        
        // $('div iframe').contents().find('body, html').css('padding','0px');
        // $('div iframe').contents().find('body, html').css('margin','0px');
        // $('div iframe').contents().find('body, html').css('overflow','hidden');
        // $('iframe').css('overflow','hidden');
        // $('iframe').css('margin','0px');
        // $('iframe').css('padding','0px');
   
        // $('div iframe').css('width','300px');
        // $('div iframe').css('height','100%');
        // $('div iframe').css('margin','0');
        // $('div iframe').css('padding','0');
        // $('div iframe').css('opacity','0.8');
        // $('div iframe').css('display','block');
        // $('.dash_iframe').contents().find('html').css("margin","0");
        // $('.dash_iframe').contents().find('html').css("padding","0");
        // $('.dash_iframe').css('padding','0');
        // $('.dash_iframe').css('margin','0');
        // $('.dash_iframe').attr('style', 'margin-bottom: 0 !important');
        // $('.dash_iframe').contents().find('html').attr('style', 'margin: 0 !important');
        // $('.dash_iframe').contents().find('html').attr('style', 'padding: 0 !important;');
        // $('.contabilidad\\/estadisticas').attr('style', 'margin: 0 !important; height:5000px;');
        // $('.contabilidad\\/estadisticas').attr('style', 'padding: 0 !important');
        
        // $('.dash_iframe').css('display','block');
        // $('.dash_iframe').css('align','right');
        // $('iframe').css('margin','0 0 0 0 !important');
        // $('iframe').css('float','left');
        // $('.tickets\\/buscar').css('height',buscarheight);
        // $('.tickets\\/crear').css('height',crearheight);
        // $('.dash_iframe').css('height', height);
        // console.log(contheight);
        // console.log(buscarheight);
        // console.log(crearheight);
    });
    /*-----------------------------------------------------------------------------------------------------------------
                                                Parte para el datepicker de la búsqueda
    ----------------------------------------------------------------------------------------------------------------*/
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var checkin = $('#fecha_inicio').datepicker({
         format: 'yyyy-mm-dd',
         weekStart: 1,
         autoclose: true,
         endDate: now,
         language: 'es',
         todayHighlight: true
    }).on('changeDate', function(e) {
            //  Calculo de la fecha máxima para sacar ticket
            var newMaxDate = new Date(e.date);
            newMaxDate.setMonth(e.date.getMonth() + 1);
            $('#fecha_fin').datepicker("setEndDate", newMaxDate);
            
            //  En caso de que la fecha fin este vacia, se le emplaza la fecha actual seleccionada en inicio
            //  y se establece la fecha maxima seleccionable
            if($('#fecha_fin').val() == ''){
                $('#fecha_fin').datepicker("setDate", e.date);
                $('#fecha_fin').datepicker("setEndDate", newMaxDate);
                $('#fecha_fin').datepicker('show');
            }
             $('#fecha_fin').datepicker("setStartDate", $('#fecha_inicio').val());
        
    });
  
    var checkout = $('#fecha_fin').datepicker({
         format: 'yyyy-mm-dd',
         weekStart: 1,
         autoclose: true,
         endDate: now,
         language: 'es',
         orientation: 'bottom',
         todayHighlight: true
    }).on('changeDate', function(e) {
        $('#fecha_inicio').datepicker("setStartDate", newMinDate);
        var newMinDate = new Date(e.date);
        newMinDate.setMonth(e.date.getMonth() - 1);
        // Si Inicio no tiene contenido, abre datepicker estableciendo fecha limite minima selecionable
        if($('#fecha_inicio').val() == ''){
            $('#fecha_inicio').datepicker("setDate", e.date);
            $('#fecha_inicio').datepicker("setStartDate", newMinDate);
            $('#fecha_inicio').datepicker("show");
        }
        $('#fecha_fin').datepicker("hide");
        $('#fecha_inicio').datepicker("setEndDate", $('#fecha_fin').val());
    });
   
    /*-----------------------------------------------------------------------------------------------------------------
                                                            Fin
     ----------------------------------------------------------------------------------------------------------------*/
});