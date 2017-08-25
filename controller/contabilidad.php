<?php
if (isLoggedIn()) {
    $smarty->assign('page', $template_data[1]);
//            include_header_file('filtertable');
    load_modul('datatable');
    load_modul('bootstrap-datepicker');
    include_header_file('https://code.highcharts.com/stock/highstock.js');
    include_header_file('https://code.highcharts.com/stock/modules/exporting.js');
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
            //Si usuario es Admin y url termina en /hotspot utilizamos dicho servidor para estadisticas
            if ($_SESSION['cliente'] == 'admin') {
                if(isset($template_data[2])){
                    $server = $template_data[2];
                }else{
                    // Si no tenemos /hotspot en la url, se muestra formulario para selección del hotspot
                    /* AÑADIR ID A LA QUERY SIGUIENTE. ¿DE DONDE SACA Id_hotspot?? */
                    $result = $database->query("SELECT ServerName FROM hotspots ORDER BY ServerName ASC");
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
                // Cambio en query '2016' por date('Y')
                $result = $database->query("SELECT Descripcion, ventashotspot.Precio,  COUNT(*) as Cuenta FROM `ventashotspot` INNER JOIN lotes ON lotes.id = ventashotspot.Id_Lote INNER JOIN perfiles ON perfiles.id = lotes.Id_perfil WHERE FechaVenta ".((!empty($template_data[3]))?"between '".$template_data[3]."-01' AND '".$template_data[3]."-31'":">= '".date('Y')."-".date('m')."-01 00:00:00'")." AND perfiles.ServerName = '$server' GROUP BY ventashotspot.Precio");
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
                $fechas = strtotime(((empty($template_data[3]))?date('Y').'-'.date('m'):$template_data[3]).'-01 00:00:00');
                $franjas = array();
                while ($fechas <= ((empty($template_data[3]))?strtotime(date('Y-m-d H:00:00')):strtotime(date('Y-m', strtotime('+1 month', strtotime($template_data[3].'-01')))."-01 00:00:00"))){
                    $franjas[date('Y-m-d H:00:00',$fechas)] = 0;
                    $fechas = strtotime ('+1 hour',$fechas);
                }
                //Query donde se obtienen usuarios, MAC de los dispositivos y conexiones realizadas
                $result = $radius->query("SELECT username,callingstationid,acctsessiontime, acctstarttime, acctstoptime,acctinputoctets,acctoutputoctets FROM radacct WHERE username LIKE '$server\_%' AND (acctstarttime ".((!empty($template_data[3]))?"between '".$template_data[3]."-01' AND '".$template_data[3]."-31'":">= '".date('Y')."-".date('m')."-01 00:00:00'")." OR (acctstarttime ".((!empty($template_data[3]))? "between '".date('Y-m', strtotime('+1 month', strtotime($template_data[3].'-01')))."-01 00:00:00' AND '".date('Y-m', strtotime('+1 month', strtotime($template_data[3].'-31')))."-01 00:00:00'":"< '".date('Y').'-'.date('m')."-01 00:00:00'")." AND acctstoptime IS NULL))");
                if ($result->num_rows > 0) {
                    $mac = array();
                    $tiempototal=0;
                    $bytes_descarga = 0;
                    $bytes_subida = 0;
                    while ($aux = $result->fetch_assoc()){
                        // Si tenemos una franja de un mes anterior, pero accstoptime es NULL la contaremos en la primera franja del mes actual
                        if(strtotime($aux['acctstarttime']) < strtotime(((empty($template_data[3]))?date('Y').'-'.date('m'):$template_data[3]).'-01 00:00:00')) $aux['acctstarttime'] = ((empty($template_data[3]))?date('Y').'-'.date('m'):$template_data[3]).'-01 00:00:00';
                        $array_resultado[$aux['username']][$aux['callingstationid']][] = array('duracion'=> $aux['acctsessiontime'], 'inicio'=>$aux['acctstarttime'], 'fin'=>$aux['acctstoptime']);
                        $tiempototal += $aux['acctsessiontime'];
                        
                        $iter = date('Y-m-d H:00:00',strtotime($aux['acctstarttime']));
                        $lim = ((empty($aux['acctstoptime']))?date('Y-m-d H:00:00'):date('Y-m-d H:00:00',strtotime($aux['acctstoptime'])));
                        while (strtotime($iter) <= strtotime($lim)) {
                                $franjas[$iter]++;
                        	    $iter = date('Y-m-d H:00:00',strtotime('+1 hour', strtotime($iter)));
                        }
                        $bytes_descarga += $aux['acctinputoctets'];
                        $bytes_subida += $aux['acctoutputoctets'];
                    }
                    $meses = $radius->query("SELECT acctstarttime FROM radacct WHERE username LIKE  '$server\_%' ORDER BY acctstarttime ASC LIMIT 1");
                    if ($meses->num_rows > 0) {
                        $mes = $meses->fetch_assoc();
                        $meses = array();
                        $fecha2 = strtotime($mes['acctstarttime']);
                        while ($fecha2 <= strtotime(date('Y-m-d H:00:00'))) {
                            $meses[]= array("fecha" => date('Y-m', $fecha2), "texto" => spanish(date('F', $fecha2)));
                            $fecha2 = strtotime('+1 month', $fecha2);
                        }
                    }
                    $datosgraf3 = array();
                    foreach ($franjas as $key => $value) $datosgraf3[] = array(strtotime($key)*1000, $value);
                    include_header_content("datosgraf3 = ".json_encode($datosgraf3, JSON_NUMERIC_CHECK));
                    if (!empty($template_data[3])) $smarty->assign("mes_selected", array_pop(explode("/", $_SERVER['REQUEST_URI'])));
                    if (!empty($fecha2)) $smarty->assign("select_mes", $meses);
                    $smarty->assign("num_con", $result->num_rows);
                    $smarty->assign("mes", spanish(date('F', ((empty($template_data[3]))?time():strtotime($template_data[3].'-01')))));
                    $smarty->assign("media_con",  number_format(round (($result->num_rows) / (count($array_resultado)), 2), 2, ",", "."));
                    $smarty->assign("media_sesion", secondsToTime(round($tiempototal/$result->num_rows, 0)));
                    $smarty->assign("bytes_descarga", bytes_to_size($bytes_descarga));
                    $smarty->assign("bytes_subida", bytes_to_size($bytes_subida));
                }
                /*METODO 2: Se utiliza query para simplificar el proceso de conteo de conexiones*/
                $result = $radius->query("SELECT SUBSTRING( callingstationid, 1, 8 ) AS principiomac, COUNT( SUBSTRING( callingstationid, 1, 8 ) ) AS countF FROM radacct WHERE username LIKE  '$server\_%' AND acctstarttime ".((!empty($template_data[3]))?"between '".$template_data[3]."-01' AND '".$template_data[3]."-31'":">= '".date('Y')."-".date('m')."-01 00:00:00'")." GROUP BY SUBSTRING( callingstationid, 1, 8 ) ");
                $mac=array();
                if ($result->num_rows > 0) {
                    while ($aux = $result->fetch_assoc()){
                        // Se van metiendo registros en $mac, llevando la cuenta de las conexiones
                        $marca = strtolower(strstr(mac_vendor($aux['principiomac']),' ', true));
                        if (array_key_exists((($marca=='apple,')?substr($marca, 0, -1):$marca), $mac)){
                            if($marca == 'apple,'){
                                $mac[substr($marca, 0, -1)] += $aux['countF'];
                            }else{
                                $mac[$marca] += $aux['countF'];
                            }  
                        }else{
                            if($marca == 'apple,'){
                                $mac[substr($marca, 0, -1)] = $aux['countF'];
                            }else{
                                $mac[$marca] = $aux['countF'];
                            }  
                        }
                    }
                    // Se ordena de forma descendente $mac, se toman los 5 principales dispositivos y se muetsran en la grafica
                    arsort($mac);
                    $macouto = array_slice($mac, 0, 5,true);
                    if (array_key_exists('', $macouto)) {
                        $macouto['Otros'] = $macouto[''];
                        unset($macouto['']);
                    }
                    $macouto['Otros'] = array_sum(array_slice($mac, 5));
                     foreach ($macouto as $key => $value) {
                         $datos4[] = array("name" => $key, 'y' => $value); 
                    }
                    include_header_content("datosgraf4 = ".json_encode($datos4, JSON_NUMERIC_CHECK));
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