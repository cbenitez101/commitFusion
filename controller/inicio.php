<?php
    if (isLoggedIn()) {
        load_modul('bootstrap-datepicker');
        $result = $database->query("SELECT * FROM users WHERE nombre='".$_SESSION['user']."'");
        if ($result->num_rows > 0) {
            $menu = array();
            while ($aux = $result->fetch_assoc()){
                if ($aux['dash_contabilidad_estadisticas'] != 0) $menu[] = 'contabilidad/estadisticas';
                if ($aux['dash_tickets_buscar'] != 0) $menu[] =  'tickets/buscar';
                if ($aux['dash_tickets_crear'] != 0) $menu[] =  'tickets/crear';
                
            }
        }
        $smarty->assign('menu', $menu);
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
    } else {
        header('Location: '.DOMAIN);
    }
    
    