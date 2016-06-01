<?php
include 'includes/functions.php';
global $database;
date_default_timezone_set("Europe/London");
/*----------------------- Comienza las funciones -----------------------*/

/*----------------------- FIN FUNCIONES -----------------------*/
if (isset($_SERVER['SHELL']) || isset($_GET['check'])) {
    $database= new mysqli('localhost', 'platformuser', 'rfC79w?3', 'plataforma');
    $radius= new mysqli('localhost', 'radiususer', 'Pwp+*f2b', 'radius');
    $elements = $database->query("SELECT * FROM hotspots WHERE Informe = 3");
    while ($lugar = $elements->fetch_assoc()) {
        $result = $radius->query("SELECT username from radacct where username like '".$lugar['ServerName']."_%' and acctstarttime > '".  ((isset($_GET['check']))?date('Y-m'):date('Y-m', strtotime('-1 month')))."-01 00:00:00' group by username");
        $users = array();
        while ($test = $result->fetch_assoc()) {
            $users[] = $test['username'];
        }
        $filtro = $radius->query("SELECT username from radacct where username IN('".  implode("','", $users)."') and acctstarttime < '".  ((isset($_GET['check']))?date('Y-m'):date('Y-m', strtotime('-1 month')))."-01 00:00:00'");
        $users2 = array();
        while ($test = $filtro->fetch_assoc()) {
            $users2[] = $test['username'];
        }
        $fin = array_diff($users, $users2);
        $total = array();
        //while ($aux = $result->fetch_assoc()) {
        //    $item = $database->query("SELECT Precio FROM ventashotspot WHERE Usuario ='".$aux['username']."'");
        //    $aux2 = $item->fetch_assoc();
        //    $total[$aux2['Precio']]++;
        //}
        foreach ($fin as $aux) {
            $item = $database->query("SELECT Precio, anulacion_fecha, Id_Lote FROM ventashotspot WHERE Usuario ='".$aux."'");
            $aux2 = $item->fetch_assoc();
            if (!array_key_exists($aux2['Id_Lote'], $total)) $total[$aux2['Id_Lote']] = array('cantidad'=>0, 'usuario'=>array(), 'precio'=>0); 
            if (empty($aux2['anulacion_fecha'])) {
                $total[$aux2['Id_Lote']]['cantidad']++;
                $total[$aux2['Id_Lote']]['usuario'][]=substr($aux, 11);
                $total[$aux2['Id_Lote']]['precio']=$aux2['Precio'];
            } else {
                $total[$aux2['Id_Lote']]['usuario'][]=substr($aux, 11).' ANULADO';
            } 
        }
        if (isset($_SERVER['SHELL'])) {
            historial($total, $lugar['id']);
            //simplefactura(pdf($total, $lugar));
        } elseif (isset ($_GET['check'])) {
            pdf($total, $lugar, true);
            die();
        }
    //    global $suma;
//        echo '<pre>';
//        print_r($total);
//        die();
    //    
    }


}



// enviar email$total[$aux2['Precio']]['usuario'][]=substr($aux, 11);