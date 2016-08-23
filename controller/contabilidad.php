<?php
if (isLoggedIn()) {
    $smarty->assign('page', $template_data[1]);
//            include_header_file('filtertable');
    load_modul('datatable');
    load_modul('bootstrap-datepicker');
    load_modul('bower_components/morrisjs');
    load_modul('bower_components/raphael');
    
    switch ($template_data[1]) {
        case 'historial':
            $result = $database->query("SELECT historial.id, historial.fecha, hotspots.ServerName, locales.nombre FROM `historial` INNER JOIN `hotspots` ON hotspots.id = historial.id_hotspot INNER JOIN `locales` ON hotspots.Local = locales.id".(($_SESSION['cliente'] != 'admin')? " INNER JOIN `clientes` ON clientes.id = locales.cliente  WHERE ".((isset($_SESSION['local']))?"locales.nombre = '".$_SESSION['local']."''":"clientes.nombre = '".$_SESSION['cliente']):""));
            $out = array();
            while ($aux = $result->fetch_assoc()) $out[] = $aux;
            $menu = array();
            foreach ($out as $value) foreach ($value as $key => $item) $menu[] = $item;
            $smarty->assign('tabla', $menu);
            $smarty->assign('cols', 'Id,Fecha,Hotspot,Local');
            break;
        case 'gastos':
            if ($_SESSION['cliente'] == 'admin') {
                if (!empty($postparams)) {
                    $database->query('INSERT INTO `gastos`(`hotspot`, `cantidad`, `Descripcion`, `precio`) VALUES ("'.$postparams['gasto_hotspot'].'","'.$postparams['gasto_cantidad'].'","'.$postparams['gasto_descripcion'].'","'.$postparams['gasto_precio'].'")');
                }
                $result = $database->query("SELECT gastos.*, hotspots.ServerName FROM gastos INNER JOIN hotspots ON gastos.hotspot = hotspots.id");
                $out = array();
                while ($aux = $result->fetch_assoc()) $out[] = $aux;
                $menu = array();
                foreach ($out as $value) foreach ($value as $item) $menu[]=$item;
                $result = $database->query('SELECT id, ServerName FROM hotspots');
                $locales = array(); 
                while ($aux = $result->fetch_assoc()) $locales[] = array($aux['id'],$aux['ServerName']);
                $smarty->assign('hotspot', $locales);
                $smarty->assign('cols', implode(', ', array_keys($out[0])));
                $smarty->assign('gastos', $menu);
            } else {
                header('Location: '.DOMAIN);
                die();
            }
            break;
        case 'ventas':
            if ($_SESSION['cliente'] == 'admin') {
                $result = $database->query("SELECT perfiles.ServerName, perfiles.Id_hotspot FROM ventashotspot INNER JOIN lotes ON ventashotspot.Id_Lote = lotes.Id INNER JOIN perfiles ON lotes.Id_perfil = perfiles.Id GROUP BY ServerName");
                if ($result->num_rows > 0) {
                    $out = array();
                    while ($aux = $result->fetch_assoc()) $out[] = array("server"=> $aux['ServerName'], "id" => $aux['Id_hotspot']);
                    $smarty->assign("servers", $out);
                }
            }
            break;
        case 'estadisticas':
            // Si usuario es Admin y url termina en /hotspot utilizamos dicho servidor para estadisticas
            if ($_SESSION['cliente'] == 'admin') {
                if(isset($template_data[2])){
                    $server = $template_data[2];
                }else{
                    // Si no tenemos /hotspot en la url, se muestra formulario para selección del hotspot
                    $result = $database->query("SELECT ServerName FROM hotspots");
                    if ($result->num_rows > 0) {
                        $out = array();
                        while ($aux = $result->fetch_assoc()) $out[] = array("server"=> $aux['ServerName'], "id" => $aux['Id_hotspot']);
                        $smarty->assign("servers", $out);
                    }
                }
            }else{
                // Si es cualquier otro usuario, se toma el hotspot de la variable $_SESSION del usuario.
                $server = $_SESSION['local'];
            }
            // Querys para estadisticas
            if (isset($server)){
                // Query para obtener tickets vendidos
                $result = $database->query("SELECT Descripcion, ventashotspot.Precio,  COUNT(*) as Cuenta FROM `ventashotspot` INNER JOIN lotes ON lotes.id = ventashotspot.Id_Lote INNER JOIN perfiles ON perfiles.id = lotes.Id_perfil WHERE FechaVenta >= '2016-".date('m')."-01 00:00:00'AND perfiles.ServerName = '$server' GROUP BY ventashotspot.Precio");
                if ($result->num_rows > 0) {
                    $out = array();
                    $prueba = array();
                    while ($aux = $result->fetch_assoc()) $out[] = $aux;
                    
                    foreach ($out as $fila) {
                        $sum += $fila['Precio']*$fila['Cuenta'];
                        $prueba[] = array("name" => $fila['Descripcion'], 'y' => $fila['Cuenta']);
                    }
                    $smarty->assign("cuenta", $sum);
                    $smarty->assign("estadisticas", $out);
                }
                include_header_content("datosgraf2 = ".json_encode($prueba, JSON_NUMERIC_CHECK));
                
                //Formateo array intervalos para estadísticas por horas
                $fechas = strtotime(date('Y').'-'.date('m').'-01 00:00:00');
                $franjas = array();
                while ($fechas <= strtotime(date('Y-m-d H:00:00'))){
                    $franjas[date('Y-m-d H:00:00',$fechas)] = 0;
                    $fechas = strtotime ('+1 hour',$fechas);
                }
                //Query donde se obtienen usuarios, MAC de los dispositivos y conexiones realizadas
                $result = $radius->query("SELECT * FROM radacct WHERE username LIKE '$server\_%' AND acctstarttime >= '".date('Y')."-".date('m')."-01 00:00:00'");
                if ($result->num_rows > 0) {
                    $array_resultado = array();
                    $tiempototal=0;
                    while ($aux = $result->fetch_assoc()){ 
                        $array_resultado[$aux['username']][$aux['callingstationid']][] = array('duracion'=> $aux['acctsessiontime'], 'inicio'=>$aux['acctstarttime'], 'fin'=>$aux['acctstoptime']);
                        $tiempototal += $aux['acctsessiontime'];
                        $iter = date('Y-m-d H:00:00',strtotime($aux['acctstarttime']));
                        $lim = ((empty($aux['acctstoptime']))?date('Y-m-d H:00:00'):date('Y-m-d H:00:00',strtotime($aux['acctstoptime'])));
                        while (strtotime($iter) <= strtotime($lim)) {
                        	$franjas[$iter]++;
                        	$iter = date('Y-m-d H:00:00',strtotime('+1 hour', strtotime($iter)));
                        }
                    }
                    $datosgraf3 = array();
                    foreach ($franjas as $key => $value) $datosgraf3[] = array(strtotime($key)*1000, $value);
                    //echo json_encode($datosgraf3, JSON_NUMERIC_CHECK);
                    include_header_content("datosgraf3 = ".json_encode($datosgraf3, JSON_NUMERIC_CHECK));
                  
                    $smarty->assign("num_con", $result->num_rows);
                    $smarty->assign("mes", spanish(date('F')));
                    $smarty->assign("media_con",  round (($result->num_rows) / (count($array_resultado)), 2));
                    $smarty->assign("media_sesion", secondsToTime(round($tiempototal/$result->num_rows, 0)));
                    //include_header_file('https://www.gstatic.com/charts/loader.js');
                    //include_header_file('https://code.highcharts.com/highcharts.js');
                    //include_header_file('https://code.highcharts.com/modules/exporting.js');
                    include_header_file('https://code.highcharts.com/stock/highstock.js');
                    include_header_file('https://code.highcharts.com/stock/modules/exporting.js');
                }
            }
            break;
        default:
            header('Location: '.DOMAIN);
            die();
            break;
    }
} else {
    header('Location: '.DOMAIN);
}

