<?php
if (isLoggedIn()) {
    $smarty->assign('page', $template_data[1]);
    include_header_file('printPage');
    load_modul('datatable');
    load_modul('bootstrap-datepicker');
    switch ($template_data[1]) {
        case 'crear':
            // dump($_SESSION, true);
            if ($_SESSION['cliente'] == 'admin') {
                // Se puede hacer con un if de parentesis en la query y cuando se añade a tickets en vez de hacerlo
                // como[] se pone el ServerName.
                $result = $database->query("select hotspots.*, perfiles.*, lotes.*, lotes.id as lotesid from locales left join clientes on locales.cliente = clientes.id left join hotspots on hotspots.Local = locales.id
    right join perfiles on hotspots.id = perfiles.Id_hotspot left join lotes on lotes.Id_perfil = perfiles.Id
    where hotspots.Status = 'ONLINE' AND perfiles.Descripcion NOT LIKE '%PAYPAL'");
                $tickets = array();
                while ($aux = $result->fetch_assoc()) {
                    $ticket = array();
                    foreach ($aux as  $key => $value) {
                        if (($key == 'Precio') || ($key == 'Duracion') || ($key == 'Movilidad') || ($key == 'ServerName') || ($key == 'ModoConsumo') || ($key == 'Acct-Interim-Interval') || ($key == 'Idle-Timeout') || ($key == 'Simultaneous-Use') || ($key == 'Login-Time') || ($key == 'Expiration') || ($key == 'WISPr-Bandwidth-Max-Down') || ($key == 'WISPr-Bandwidth-Max-Up') || ($key == 'TraficoDescarga') || ($key == 'lotesid')  || ($key == 'Password') ) {
                            $ticket[$key] = $value;
                        }
                        if ($key == 'Duracion') {
                            switch ($value) {
                                case 300:
                                    $ticket['duraciontexto']="5 minutos";
                                    break;
                                case 600:
                                    $ticket['duraciontexto']="10 minutos";
                                    break;
                                case 900:
                                    $ticket['duraciontexto']="15 minutos";
                                    break;
                                case 1800:
                                    $ticket['duraciontexto']="30 minutos";
                                    break;
                                case 3600:
                                    $ticket['duraciontexto']="1 hora";
                                    break;
                                case 7200:
                                    $ticket['duraciontexto']="2 horas";
                                    break;
                                case 14400:
                                    $ticket['duraciontexto']="4 horas";
                                    break;
                                case 21600:
                                    $ticket['duraciontexto']="6 horas";
                                    break;
                                case 28800:
                                    $ticket['duraciontexto']="8 horas";
                                    break;
                                case 43200:
                                    $ticket['duraciontexto']="12 horas";
                                    break;
                                case 86400:
                                    $ticket['duraciontexto']="1 día";
                                    break;
                                case 172800:
                                    $ticket['duraciontexto']="2 días";
                                    break;
                                case 259200:
                                    $ticket['duraciontexto']="3 días";
                                    break;
                                case 345600:
                                    $ticket['duraciontexto']="4 días";
                                    break;
                                case 432000:
                                    $ticket['duraciontexto']="5 días";
                                    break;
                                case 518400:
                                    $ticket['duraciontexto']="6 días";
                                    break;
                                case 604800:
                                    $ticket['duraciontexto']="7 días";
                                    break;
                                case 691200:
                                    $ticket['duraciontexto']="8 días";
                                    break;
                                case 777600:
                                    $ticket['duraciontexto']="9 días";
                                    break;
                                case 864000:
                                    $ticket['duraciontexto']="10 días";
                                    break;
                                case 950400:
                                    $ticket['duraciontexto']="11 días";
                                    break;
                                case 1036800:
                                    $ticket['duraciontexto']="12 días";
                                    break;
                                case 1123200:
                                    $ticket['duraciontexto']="13 días";
                                    break;
                                case 1209600:
                                    $ticket['duraciontexto']="14 días";
                                    break;
                                case 1296000:
                                    $ticket['duraciontexto']="15 días";
                                    break;
                                case 1382400:
                                    $ticket['duraciontexto']="16 días";
                                    break;
                                case 1468800:
                                    $ticket['duraciontexto']="17 días";
                                    break;
                                case 1555200:
                                    $ticket['duraciontexto']="18 días";
                                    break;
                                case 1641600:
                                    $ticket['duraciontexto']="19 días";
                                    break;
                                case 1728000:
                                    $ticket['duraciontexto']="20 días";
                                    break;
                                case 1814400:
                                    $ticket['duraciontexto']="21 días";
                                    break;
                                case 1900800:
                                    $ticket['duraciontexto']="22 días";
                                    break;
                                case 1987200:
                                    $ticket['duraciontexto']="23 días";
                                    break;
                                case 2073600:
                                    $ticket['duraciontexto']="24 días";
                                    break;
                                case 2160000:
                                    $ticket['duraciontexto']="25 días";
                                    break;
                                case 2246400:
                                    $ticket['duraciontexto']="26 días";
                                    break;
                                case 2332800:
                                    $ticket['duraciontexto']="27 días";
                                    break;
                                case 2419200:
                                    $ticket['duraciontexto']="28 días";
                                    break;
                                case 2505600:
                                    $ticket['duraciontexto']="29 días";
                                    break;
                                case 2592000:
                                    $ticket['duraciontexto']="30 días";
                                    break;
                                case 2678400:
                                    $ticket['duraciontexto']="31 días";
                                    break;
                                case 5184000:
                                    $ticket['duraciontexto']="2 meses";
                                    break;
                                case 7776000:
                                    $ticket['duraciontexto']="3 meses";
                                    break;
                                case 10368000:
                                    $ticket['duraciontexto']="4 meses";
                                    break;
                                case 12960000:
                                    $ticket['duraciontexto']="5 meses";
                                    break;
                                case 15552000:
                                    $ticket['duraciontexto']="6 meses";
                                    break;
                                case 18144000:
                                    $ticket['duraciontexto']="7 meses";
                                    break;
                                case 20736000:
                                    $ticket['duraciontexto']="8 meses";
                                    break;
                                case 23328000:
                                    $ticket['duraciontexto']="9 meses";
                                    break;
                                case 25920000:
                                    $ticket['duraciontexto']="10 meses";
                                    break;
                                case 28512000:
                                    $ticket['duraciontexto']="11 meses";
                                    break;
                                case 31104000:
                                    $ticket['duraciontexto']="1 año";
                                    break;
                            }
                        }
                    }
                    $tickets[$aux['ServerName']][] = $ticket;
                }
                $smarty->assign("tickets",$tickets);
                $smarty->assign('servers', array_keys($tickets));
            } else {
                $result = $database->query("select hotspots.*, perfiles.*, lotes.*, lotes.id as lotesid from locales left join clientes on locales.cliente = clientes.id left join hotspots on hotspots.Local = locales.id
    right join perfiles on hotspots.id = perfiles.Id_hotspot left join lotes on lotes.Id_perfil = perfiles.Id
    where clientes.nombre = '".$_SESSION['cliente']."' and locales.nombre = '".(empty($_SESSION['local'])? 'Ofi-Hotspot' : $_SESSION['local'] )."' and hotspots.Status = 'ONLINE'");
                $tickets = array();
                while ($aux = $result->fetch_assoc()) {
                    $ticket = array();
                    foreach ($aux as  $key => $value) {
                        if (($key == 'Precio') || ($key == 'Duracion') || ($key == 'Movilidad') || ($key == 'ServerName') || ($key == 'ModoConsumo') || ($key == 'Acct-Interim-Interval') || ($key == 'Idle-Timeout') || ($key == 'Simultaneous-Use') || ($key == 'Login-Time') || ($key == 'Expiration') || ($key == 'WISPr-Bandwidth-Max-Down') || ($key == 'WISPr-Bandwidth-Max-Up') || ($key == 'TraficoDescarga') || ($key == 'lotesid')  || ($key == 'Password') ) {
                            $ticket[$key] = $value;
                        }
                        if ($key == 'Duracion') {
                            switch ($value) {
                                case 300:
                                        $ticket['duraciontexto']="5 minutos";
                                        break;
                                case 600:
                                        $ticket['duraciontexto']="10 minutos";
                                        break;
                                case 900:
                                        $ticket['duraciontexto']="15 minutos";
                                        break;
                                case 1800:
                                        $ticket['duraciontexto']="30 minutos";
                                        break;
                                case 3600:
                                        $ticket['duraciontexto']="1 hora";
                                        break;
                                case 7200:
                                        $ticket['duraciontexto']="2 horas";
                                        break;
                                case 14400:
                                        $ticket['duraciontexto']="4 horas";
                                        break;
                                case 21600:
                                        $ticket['duraciontexto']="6 horas";
                                        break;
                                case 28800:
                                        $ticket['duraciontexto']="8 horas";
                                        break;
                                case 43200:
                                        $ticket['duraciontexto']="12 horas";
                                        break;
                                case 86400:
                                        $ticket['duraciontexto']="1 día";
                                        break;
                                case 172800:
                                        $ticket['duraciontexto']="2 días";
                                        break;
                                case 259200:
                                        $ticket['duraciontexto']="3 días";
                                        break;
                                case 345600:
                                        $ticket['duraciontexto']="4 días";
                                        break;
                                case 432000:
                                        $ticket['duraciontexto']="5 días";
                                        break;
                                case 518400:
                                        $ticket['duraciontexto']="6 días";
                                        break;
                                case 604800:
                                        $ticket['duraciontexto']="7 días";
                                        break;
                                case 691200:
                                        $ticket['duraciontexto']="8 días";
                                        break;
                                case 777600:
                                        $ticket['duraciontexto']="9 días";
                                        break;
                                case 864000:
                                        $ticket['duraciontexto']="10 días";
                                        break;
                                case 950400:
                                        $ticket['duraciontexto']="11 días";
                                        break;
                                case 1036800:
                                        $ticket['duraciontexto']="12 días";
                                        break;
                                case 1123200:
                                        $ticket['duraciontexto']="13 días";
                                        break;
                                case 1209600:
                                        $ticket['duraciontexto']="14 días";
                                        break;
                                case 1296000:
                                        $ticket['duraciontexto']="15 días";
                                        break;
                                case 1382400:
                                        $ticket['duraciontexto']="16 días";
                                        break;
                                case 1468800:
                                        $ticket['duraciontexto']="17 días";
                                        break;
                                case 1555200:
                                        $ticket['duraciontexto']="18 días";
                                        break;
                                case 1641600:
                                        $ticket['duraciontexto']="19 días";
                                        break;
                                case 1728000:
                                        $ticket['duraciontexto']="20 días";
                                        break;
                                case 1814400:
                                        $ticket['duraciontexto']="21 días";
                                        break;
                                case 1900800:
                                        $ticket['duraciontexto']="22 días";
                                        break;
                                case 1987200:
                                        $ticket['duraciontexto']="23 días";
                                        break;
                                case 2073600:
                                        $ticket['duraciontexto']="24 días";
                                        break;
                                case 2160000:
                                        $ticket['duraciontexto']="25 días";
                                        break;
                                case 2246400:
                                        $ticket['duraciontexto']="26 días";
                                        break;
                                case 2332800:
                                        $ticket['duraciontexto']="27 días";
                                        break;
                                case 2419200:
                                        $ticket['duraciontexto']="28 días";
                                        break;
                                case 2505600:
                                        $ticket['duraciontexto']="29 días";
                                        break;
                                case 2592000:
                                        $ticket['duraciontexto']="30 días";
                                        break;
                                case 2678400:
                                        $ticket['duraciontexto']="31 días";
                                        break;
                                case 5184000:
                                        $ticket['duraciontexto']="2 meses";
                                        break;
                                case 7776000:
                                        $ticket['duraciontexto']="3 meses";
                                        break;
                                case 10368000:
                                        $ticket['duraciontexto']="4 meses";
                                        break;
                                case 12960000:
                                        $ticket['duraciontexto']="5 meses";
                                        break;
                                case 15552000:
                                        $ticket['duraciontexto']="6 meses";
                                        break;
                                case 18144000:
                                        $ticket['duraciontexto']="7 meses";
                                        break;
                                case 20736000:
                                        $ticket['duraciontexto']="8 meses";
                                        break;
                                case 23328000:
                                        $ticket['duraciontexto']="9 meses";
                                        break;
                                case 25920000:
                                        $ticket['duraciontexto']="10 meses";
                                        break;
                                case 28512000:
                                        $ticket['duraciontexto']="11 meses";
                                        break;
                                case 31104000:
                                        $ticket['duraciontexto']="1 año";
                                        break;                                
                            }
                        }
                    }
                    $tickets[] = $ticket;
                }
                $smarty->assign("tickets",$tickets);
            }
            break;
        case 'buscar':
            //load_modul('bsdatepicker');
            if (isset($template_data[2])) {
                $result = $radius->query("SELECT * FROM radacct WHERE username = '$template_data[2]' ORDER BY acctstarttime ASC");
                $out = array();
                while ($aux = $result->fetch_assoc()) $out['accounting'][]=$aux;
                $result = $radius->query("SELECT * FROM radcheck WHERE username = '$template_data[2]'");
                while ($aux = $result->fetch_assoc()) $out['infoticket'][]=$aux;
                $out['info']['username'] = substr(strstr($template_data[2], '_'), 1);
                $result = $database->query("SELECT * FROM `ventashotspot` INNER JOIN lotes ON ventashotspot.Id_lote = lotes.id INNER JOIN perfiles ON lotes.Id_perfil = perfiles.id WHERE ventashotspot.Usuario = '$template_data[2]'");
                while ($aux = $result->fetch_assoc()) $out['plataforma']=$aux;
                foreach ($out['accounting'] as $item) {
                    $out['suma']['out'] = ((isset($out['suma']['out']))? $out['suma']['out'] + $item['acctoutputoctets']:$item['acctoutputoctets']);
                    $out['suma']['in'] = ((isset($out['suma']['in']))? $out['suma']['in'] + $item['acctinputoctets']:$item['acctinputoctets']);
                    $out['suma']['time'] = ((isset($out['suma']['time']))? $out['suma']['time'] + $item['acctsessiontime']:$item['acctsessiontime']);
                    if (substr($item['acctstarttime'], 0,10) == date('Y-m-d')) $out['suma']['today']= ((isset ($out['suma']['today']))?$out['suma']['today']+$item['acctsessiontime']:$item['acctsessiontime']);
                    elseif ((substr($item['acctstoptime'], 0,10) == date('Y-m-d')) && (substr($item['acctstarttime'], 0,10) == date('Y-m-d', strtotime('-1 day')))) $out['suma']['today']= ((isset ($out['suma']['today']))?$out['suma']['today']+(strtotime($item['acctstoptime']) -  strtotime(date('Y-m-d').' 01:00:00')):(strtotime($item['acctstoptime']) -  strtotime(date('Y-m-d').' 01:00:00')));
                }
                $cancelado = false;
                $estado = '';
                foreach ($out['infoticket'] as $value) {
                    if ($value['value'] == 'Reject'){
                        $cancelado = TRUE;
                    }
                    if (!$cancelado) {
                        switch ($value['attribute']) {
                            case 'One-All-Session':
                                if (isset($out['accounting'][0]) && ((time() - strtotime($out['accounting'][0]['acctstarttime'])) > $value['value'])) $estado = "CONSUMIDO";
                                else $estado = "VALIDO";
                                break;
                            case 'Max-All-Mb':
                                if (($out['suma']['out']+$out['suma']['in']) > $value['value']) $estado = "CONSUMIDO";
                                else $estado = "VALIDO";
                                break;
                            case 'Max-All-Session':
                                if (($out['suma']['time']) > $value['value']) $estado = "CONSUMIDO";
                                else $estado = "VALIDO";
                                break;
                            case 'Expiration':
                                if (time() > strtotime($value['value'])) $estado = "CONSUMIDO";
                                else $estado = "VALIDO";
                                break;
                            case 'One-Daily-Session':
                                if ($out['suma']['today'] > $value['value']) $estado = "CONSUMIDO";
                                else $estado = "VALIDO";
                                break;
                        }
                    }  
                }
                $smarty->assign('estado', (($cancelado)?"CANCELADO":$estado));
                $smarty->assign('out', $out);
            } else {
                if ($_SESSION['cliente'] == 'admin') {
                    $result = $database->query("SELECT distinct(perfiles.ServerName) FROM `ventashotspot` INNER JOIN lotes ON ventashotspot.Id_lote = lotes.id INNER JOIN perfiles ON lotes.Id_perfil = perfiles.id");
                    while($aux = $result->fetch_assoc()) $out[] = $aux['ServerName'];
                    $smarty->assign('servers', $out);
		        }
                $smarty->assign('busqueda', true);
            } 
            break;
        case 'resultado':
            if ($_SESSION['cliente'] == 'admin') {
                $result = $database->query("SELECT * FROM `ventashotspot` INNER JOIN lotes ON ventashotspot.Id_lote = lotes.id INNER JOIN perfiles ON lotes.Id_perfil = perfiles.id WHERE ".((!empty($_GET['fechainicio']))? " ventashotspot.FechaVenta > '".$_GET['fechainicio']." 00:00:00'":((!empty($_GET['user']))? "1":" ventashotspot.FechaVenta > '".date("Y-m-d", strtotime("-1 month"))." 00:00:00'")).((!empty($_GET['fechafin']))?" AND ventashotspot.FechaVenta < '".$_GET['fechafin']." 23:59:59'":"").((!empty($_GET['user']))?" AND ventashotspot.Usuario LIKE  '%\_".$_GET['user']."'":"").((!empty($_GET['server']))?" AND ventashotspot.Usuario LIKE  '".$_GET['server']."\_%'":"").((!empty($_GET['identificador']))?" AND ventashotspot.identificador LIKE  '".$_GET['identificador']."' AND ventashotspot.identificador NOT LIKE 'FREE\_'":""));
            } else {
                $result = $database->query("SELECT * FROM `ventashotspot` INNER JOIN lotes ON ventashotspot.Id_lote = lotes.id INNER JOIN perfiles ON lotes.Id_perfil = perfiles.id WHERE Usuario LIKE '".$_SESSION['local']."\_%'".((!empty($_GET['fechainicio']))?" AND FechaVenta > '".$_GET['fechainicio']." 00:00:00'":" AND FechaVenta > '".date("Y-m-d", strtotime("-1 month"))." 00:00:00'").((!empty($_GET['fechafin']))?" AND FechaVenta < '".$_GET['fechafin']." 23:59:59'":"").((!empty($_GET['user']))?" AND Usuario LIKE  '%_".$_GET['user']."'":"").((!empty($_GET['identificador']))?" AND ventashotspot.identificador LIKE  '".$_GET['identificador']."' AND ventashotspot.identificador NOT LIKE 'FREE\_'":""));
            }
            if ($result->num_rows > 0) {
                $out = array();
                while ($aux = $result->fetch_assoc()) $out[] = $aux;
                $menu = array();
                foreach ($out as $value) {
                    $menu[]= substr(strstr($value['Usuario'], "_"),1);
                    $menu[]=$value['ServerName'];
                    $menu[]=$value['FechaVenta'];
                    $menu[]=$value['Descripcion'];
                    $menu[]=$value['identificador'];
                }
                $smarty->assign('cols', implode(', ', array('Usuario', 'ServerName', 'FechaVenta', 'Descripcion', 'Identificador')));
                $smarty->assign('tickets', $menu);
            } else {
                $smarty->assign('empty', true);
            }

            break;
        case 'facebook':
            $result = $database->query('SELECT `idlocal`, `fbid`, `name`, `email`, `link`, `username` FROM `facebook`');
            $out = array();
            while ($aux = $result->fetch_assoc()) {
                array_shift($aux);
                $aux = array_merge(array('Local'=>  strstr($aux['username'], '_', TRUE)), $aux);
                $aux['username']= substr(strstr($aux['username'], '_'), 1);
                $out[]=$aux;
            }
            $menu = array();
            foreach ($out as $value) foreach($value as $item) $menu[]=$item;
            $smarty->assign('cols', implode(',', array_keys($out[0])));
            $smarty->assign('facebook', $menu);
            
            
            break;
        case 'bloc':
            if (!empty($postparams)) {
                 $database->query('INSERT INTO `blocs`(`nombre`, `tiempo`, `descripcion`, `fecha`) VALUES ("'.$postparams['bloc_nombre'].'","'.$postparams['bloc_tiempo'].'","'.$postparams['bloc_descripcion']." (".$postparams['bloc_cantidad'].')",NOW())');
                 $blocid = $database->insert_id;
                for ($index = 0; $index < $postparams['bloc_cantidad']; $index++) $database->query("INSERT INTO `bloc_usuarios`(`user`, `bloc_id`) VALUES ('".  usuario_aleatorio('CVCVCVNNNN')."',$blocid)");
                $smarty->assign('excel', $blocid);
            }
            $result = $database->query('SELECT * FROM `blocs`');
            $out = array();
            while ($aux = $result->fetch_assoc()) $out[]=$aux;
            $menu = array();
            foreach ($out as $value) {
                foreach($value as $item) $menu[]=$item;
//                $menu[]= '<input type="button" class="import_bloc ui-button" value="Importar" data-id="'.$value['id'].'" data-tiempo="'.$value['tiempo'].'">';
            }
//            $smarty->assign('cols', implode(',', array_keys($out[0])).((count($out) > 0)?",Importar":""));
            $smarty->assign('cols', implode(',', array_keys($out[0])));
            $smarty->assign('bloc', $menu);
            break;
        case 'bonos':
            $result = $database->query('SELECT bonos.*, hotspots.ServerName FROM `bonos` INNER JOIN hotspots ON hotspots.id = bonos.id_hotspot');
            $out = array();
            while ($aux = $result->fetch_assoc()) $out[]=$aux;
            $menu = array();
            foreach ($out as $value) {
                foreach($value as $item) $menu[]=$item;
            }
            $smarty->assign('cols', implode(',', array_keys($out[0])));
            $smarty->assign('bonos', $menu);
            $result = $database->query("SELECT id, ServerName FROM hotspots");
            $out = array();
            while ($aux = $result->fetch_assoc()) $out[]=$aux;
            $smarty->assign('hotspots', $out);
            break;
        default:
            header('Location: '.DOMAIN);
            die();
            break;
    }
} else {
    header('Location: '.DOMAIN);
}
