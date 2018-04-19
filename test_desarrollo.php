<?php
/* Se utiliza la version de Denis Basta */
require_once('scripts/routeros-api/routeros_api.class.php');

$user = 'admin';
$pass = '';
$server = 'Christo_NOTFORRESALE';
$id_server=62;
// $ip = '192.168.45.72';   // 941
// $ip = '192.168.45.94';   // 951
// $ip = '192.168.45.75';   // 952
// $ip = '192.168.45.69';   // 2011
$ip = '192.168.45.96';

$API = new RouterosAPI();
$API->debug = false;
if ($API->connect($ip, $user, $pass)) {
    print_r("Conexión establecida.\n");

   
    $API->disconnect();
}else{
    print_r("Hay problemas con la conexión. Revise los parámetros y la conectividad.\n");
}




function enviaComando($comando, $opciones){
    global $API;
    print_r("Intento 1: \n");
    $res = $API->comm($comando, $opciones);
    // COMPROBAR POR QUE A VECES DEVUELVE ARRAYS Y OTRAS STRINGS
    if (!empty($res) && (gettype($res) == 'array') && (array_key_exists ('!trap',$res))){
        print_r("ERROR: Ha ocurrido un problema, volviendo a intentar...\n");
        sleep(1);
        print_r("Intento 2: \n");
        $res = $API->comm($comando, $opciones);
        if (!empty($res) && (gettype($res) == 'array') && (array_key_exists ('!trap',$res))){
            print_r("ERROR: No se ha podido realizar la operación.\n\n");
            file_put_contents("error", "Error: ".$comando." => ".print_r($opciones, true)."\r\n".print_r($res, true)."\r\n", FILE_APPEND);
            return false;
        } else return true;
    } else return true;  
}

?>