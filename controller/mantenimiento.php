<?php
if (isLoggedIn()) {
    $smarty->assign('page', $template_data[1]);
//            include_header_file('filtertable');
    load_modul('datatable');
    switch ($template_data[1]) {
        case 'dispositivos':
            if (!empty($template_data[2])) {
                $result = $database->query("");
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

