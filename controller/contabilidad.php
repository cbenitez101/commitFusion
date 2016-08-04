<?php
if (isLoggedIn()) {
    $smarty->assign('page', $template_data[1]);
//            include_header_file('filtertable');
    load_modul('datatable');
    load_modul('bsdatepicker');
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
        default:
            header('Location: '.DOMAIN);
            die();
            break;
    }
} else {
    header('Location: '.DOMAIN);
}

