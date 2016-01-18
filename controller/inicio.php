<?php
if (isLoggedIn()) {
    $smarty->assign('page', $template_data[1]);
    $result = $database->query("SELECT hotspots.ServerName FROM `locales` INNER JOIN hotspots ON hotspots.Local = locales.id WHERE locales.nombre = '".((empty($_SESSION['local']))?'AlegriaVivir':$_SESSION['local'])."'");
    $aux = $result->fetch_assoc();
    $result = $radius->query("SELECT username, acctsessiontime  FROM `radacct` WHERE `username` LIKE '".$aux['ServerName']."_%' AND `acctstoptime` IS NULL");
    $out = array();
    while ($aux = $result->fetch_assoc()) $out[] = $aux;
    $users = array();
    foreach ($out as $value) foreach ($value as $key => $item) {
        if ($key == 'username') {
            $users[] = substr(strstr($item, '_'), 1);
        } elseif ($key == 'acctsessiontime') {
            $horas = floor($item / 3600);
	        $minutos = floor(($item - ($horas * 3600)) / 60);
	        $segundos = $item - ($horas * 3600) - ($minutos * 60);
	        $hora_texto = "";
        	if ($horas > 0 ) $hora_texto .= $horas . "h ";
        	if ($minutos > 0 ) $hora_texto .= $minutos . "m ";
        	if ($segundos >= 0 )$hora_texto .= $segundos . "s";
            $users[] = $hora_texto;
        }
    }
    $smarty->assign('users', $users);
    $smarty->assign('cols', 'Usuario,Tiempo de conexión');
} else {
    header('Location: '.DOMAIN);
}