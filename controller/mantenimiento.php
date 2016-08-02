<?php
if (isLoggedIn()) {
    $smarty->assign('page', $template_data[1]);
//            include_header_file('filtertable');
    load_modul('datatable');
    switch ($template_data[1]) {
        case 'dispositivos':
            $result = $database->query("SELECT dispositivos.*, locales.nombre FROM `dispositivos` INNER JOIN `hotspots` ON hotspots.id = historial.id_hotspot INNER JOIN `locales` ON hotspots.Local = locales.id".(($_SESSION['cliente'] != 'admin')? " INNER JOIN `clientes` ON clientes.id = locales.cliente  WHERE ".((isset($_SESSION['local']))?"locales.nombre = '".$_SESSION['local']."''":"clientes.nombre = '".$_SESSION['cliente']):""));
            //dump("SELECT dispositivos.*, locales.nombre FROM `dispositivos` INNER JOIN `hotspots` ON hotspots.id = historial.id_hotspot INNER JOIN `locales` ON hotspots.Local = locales.id".(($_SESSION['cliente'] != 'admin')? " INNER JOIN `clientes` ON clientes.id = locales.cliente  WHERE ".((isset($_SESSION['local']))?"locales.nombre = '".$_SESSION['local']."''":"clientes.nombre = '".$_SESSION['cliente']):""), true);
            $out = array();
            if ($result->num_rows > 0) {
                while ($aux = $result->fetch_assoc()) $out[] = $aux;
                $menu = array();
                foreach ($out as $value) foreach ($value as $key => $item) $menu[] = $item;
                $result = $database->query('SELECT id, ServerName FROM hotspots');
                $locales = array(); 
                while ($aux = $result->fetch_assoc()) $locales[] = array($aux['id'],$aux['ServerName']);
                $smarty->assign('hotspot', $locales);
                $smarty->assign('tabla', $menu);
                $smarty->assign('cols', implode(', ', array_keys($out[0])));
            }
            break;
        /*case 'gastos':
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
            break;*/
        default:
            header('Location: '.DOMAIN);
            die();
            break;
    }
} else {
    header('Location: '.DOMAIN);
}

