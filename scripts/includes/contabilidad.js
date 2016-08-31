$(document).ready(function(){
    // Manejador de la tabla, se le pone que al hacer lick en una fila llame al modal y guarda los datos de la tabla
    // en data.
    table = $('#table-search').DataTable({
        "preDrawCallback" : function() {
            if (!$('table').hasClass('historialtable')) {
                // Caso especial en el que la tabla historial no tiene modal.
                var api = this.api();
                $('#table-search tbody td').click(function() {
                    if (!$(this).hasClass('sorting_1')) {
                        row = api.row($(this).parent());
                        data = api.row($(this).parent()).data();
                        $('.modal').modal();
                    }
                });
            }
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.9/i18n/Spanish.json"
        },
        "responsive" : true
    });
    // Pone los datos de la variable modal en la tabla
    $('.modal').on('show.bs.modal', function(){
        //console.log(data);
        if (data != null) {
            var i = 0;
            $('.modal-body [id^="modal_gasto"]').each(function(elem) {
                $(this).val(data[i]);
                i++;
            });
        }
    });
    // Resetea los campos del formulario
    $('.modal').on('hidden.bs.modal', function(){
        data = null;
        $('.modal input:not([type="radio"])').val('');
        $('.modal select').val('');
        $('#historico input[type="radio"]:checked').removeAttr('checked')
    });
    // Acciones de los botones
    $('.modal button.action').click(function(){
        if ($(this).text() == 'Guardar') {
            // Guardo los valores en dataok para actualizar la tabla
            if ($('#modal_gastoid').val() !== "") {
                $('.modal-body [id^="modal_gasto"]').each(function(elem) {
                    dataok.push($(this).val());
                });
                dataok[5] = data[5];
            }
            //console.log(dataok);
            guardar_gasto(0);
        } else if ($(this).text() == 'Eliminar') {
            if (($('#modal_gastoid').val()!== "")) {
                //Si estamos creando no hay id asignado y no se llama a la función
                guardar_gasto(1);
            }
        } else if ($(this).text() == 'Abrir') {
            window.open('/informepdf?id='+data[0]+'&modo='+$('#historico input[type="radio"]:checked').val(), '_blank','menubar=no,status=no,titlebar=no,toolbar=no,scrollbars=yes,location=no');
        }
    });
    
    $('#estadistica_server').val('');
    $('#estadistica_server').change(function(){
        window.location = window.location.href + '/' + $('#estadistica_server').val();
    });
    
    Highcharts.setOptions({
        lang: {
            contextButtonTitle: "Chart context menu",
            downloadJPEG: "Descargar imagen JPEG",
            downloadPDF: "Descargar PDF",
            downloadPNG: "Descargar PNG",
            downloadSVG: "Descargar SVG",
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            decimalPoint: ",",
            rangeSelectorFrom: "Desde",
            rangeSelectorTo: "Hasta",
            thousandsSep: ".",
            shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',  'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            loading: "Cargando",
            printChart: "Imprimir gráfica"
        }
    });
    
    //PIE CHART
    // Build the chart
    $('#container2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Venta de tickets'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Tickets vendidos',
            colorByPoint: true,
            data: datosgraf2
        }]
    });
   
    // Highstock gráfica
    $('#container').highcharts('StockChart', {
        title: {
            text: 'Conexiones por franja horaria'
        },
        xAxis: {
            gapGridLineWidth: 0,
            type: 'datetime',
            dateTimeLabelFormats: {
                hour: '%H:%M:%S',
                day: '%d-%m<br/>%Y',
                week: '%d-%m<br/>%Y',
                month: '%Y-%m',
                year: '%Y'
            }
        },
        rangeSelector : {
            buttons : [{
                type : 'hour',
                count : 1,
                text : '1Hora'
            }, {
                type : 'day',
                count : 1,
                text : '1Dia'
            }, {
                type : 'week',
                count : 1,
                text : '1Semana'
            }, {
                type : 'all',
                count : 1,
                text : 'Todo'
            }
            ],
            buttonTheme: {
                width: 50,
                height: 20,
                padding: 5,
                margin: 0
            },
            selected : 2,
            buttonSpacing: 20,
            inputEnabled : false,
            allButtonsEnabled: true
        },
        credits: {
            enabled: false
        },
        series : [{
            name : 'Conexiones',
            type: 'area',
            data : datosgraf3,
            gapSize: 5,
            color: '#4F7327',
            tooltip: {
                valueDecimals: 0
            },
            fillColor : {
                linearGradient : {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops : [
                    [0, '#4F7327'],
                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            },
            threshold: null
        }]
    });
     /*-----------------------------------------------------------------------------------------------------------------
                                                Parte para el datepicker de la búsqueda
     ----------------------------------------------------------------------------------------------------------------*/
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    checkin = $('#fecha_inicio').datepicker({
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
    });
    
     checkout = $('#fecha_fin').datepicker({
         format: 'yyyy-mm-dd',
         weekStart: 1,
         autoclose: true,
         endDate: now,
         language: 'es',
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
    });
    
    /*-----------------------------------------------------------------------------------------------------------------
                                                            Fin
     ----------------------------------------------------------------------------------------------------------------*/
});
var table;
var data;
var row;
var checkin;
var checkout;
var dataok = [];
var datosgraf2, datosgraf3;
function guardar_gasto(action) {
    var guardar = [];
    $('[id^="modal_gasto"] input').each(function(){
        guardar.push($(this).val());
    });
    $('[id^="modal_gasto"] select').each(function(){
        guardar.push($(this).val());
    });
    //console.log(guardar);
    $.ajax({
        url: '/guardar_gasto',
        type: 'POST',
        data: {id: guardar[0], cantidad: guardar[1], Descripcion: guardar[2], precio: guardar[3], hotspot: guardar[4], action: action}
    }).done(function(){
        if (action === 0) {
            if (guardar[0] === '') {
                window.location = document.URL;
            } else {
                row.data(dataok);
                dataok = [];
            }
            mensajealert('ok');
        } else {
            row.remove().draw();
            mensajealert('delete');
        }
    });
}
