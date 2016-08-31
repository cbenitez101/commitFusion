<?php
if (isLoggedIn()) {
    $smarty->assign('page', $template_data[1]);
//            include_header_file('filtertable');
    load_modul('datatable');
    switch ($template_data[1]) {
        case 'dispositivos':
            if (!empty($template_data[2])) {
                $result = $database->query("SELECT syslog.*, dispositivos.notas, dispositivos.tipo FROM `dispositivos` INNER JOIN hotspots ON dispositivos.id_hotspot = hotspots.id INNER JOIN syslog ON hotspots.ServerName = syslog.local WHERE dispositivos.id_hotspot='".$template_data[2]."' AND (dispositivos.descripcion = syslog.dispositivo OR syslog.dispositivo = 'hotspot') GROUP BY id");
                $out = array();
                if ($result->num_rows > 0) {
                    $keys = array("estado","fecha", "ip", "dispositivo", "notas");
                    while ($aux = $result->fetch_assoc()) {
                        if (isset($aux['info'])) foreach (json_decode($aux['info'], true) as $key => $value) if (!in_array($key, $keys)) $keys[] = $key;
                        $out[] = $aux;
                    }
                    $out1 = array();
                    foreach ($out as $value) {
                        $aux1 = array('estado' => '<span class="dispositivos-'.(($value['dispositivo'] == "hotspot")?((array_key_exists('connected', json_decode($value['info'], true)))?"hotspotw":"hotspot"):$value['tipo']).'-'.((strtotime($value['fecha']) < strtotime("-30 min"))?"off":"on").'" />','fecha' => $value['fecha'], "ip"=> $value['ip'], "dispositivo" => $value['dispositivo'], "notas" => $value['notas']);
                        if (isset($value['info'])) {
                            $aux2 = json_decode($value['info'], true);
                            foreach ($keys as $value1) if (($value1 != "estado") && ($value1 != "fecha") && ($value1 != "ip") && ($value1 != "dispositivo") && ($value1 != "notas")) $aux1[$value1] = ((array_key_exists($value1, $aux2))?$aux2[$value1]:"");
                            $out1[] = $aux1;
                        }
                    }
                    $menu = array();
                    foreach ($out1 as $value) foreach ($value as $item) $menu[] = $item;
                }
                $smarty->assign('cols', $keys);
                $smarty->assign('dispositivos', $menu);
            } else {    
                //$result = $database->query("SELECT dispositivos.*, hotspots.ServerName FROM `dispositivos` INNER JOIN `hotspots` ON hotspots.id = dispositivos.id_hotspot INNER JOIN `locales` ON hotspots.Local = locales.id".(($_SESSION['cliente'] != 'admin')? " INNER JOIN `clientes` ON clientes.id = locales.cliente  WHERE ".((isset($_SESSION['local']))?"locales.nombre = '".$_SESSION['local']."''":"clientes.nombre = '".$_SESSION['cliente']):""));
                $result = $database->query("SELECT hotspots.id ,hotspots.ServerName, COUNT(*) AS dispositivos FROM `hotspots` LEFT JOIN dispositivos ON dispositivos.id_hotspot = hotspots.id GROUP BY hotspots.id");
                // Cuando entra un admin, se muestran todos los hotspot para que elija uno para ver en profuncidad, pero al entrar otro usuario solo ve sus hotspots sin posiblidad de escoger la antena. Para que el admin vea el hotspot al elegir una entra en la pagina siguiente dispositivos/id_hotspot
                $out = array();
                if ($result->num_rows > 0) {
                    while ($aux = $result->fetch_assoc()) $out[] = $aux;
                    $menu = array();
                    foreach ($out as $value) foreach ($value as $key => $item) $menu[] = $item;
                    $smarty->assign('dispositivos', $menu);
                    $smarty->assign('cols', implode(', ', array_keys($out[0])));
                }
                $result = $database->query('SELECT id, ServerName FROM hotspots');
                $locales = array(); 
                while ($aux = $result->fetch_assoc()) $locales[] = array($aux['id'],$aux['ServerName']);
                $smarty->assign('hotspot', $locales);
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

