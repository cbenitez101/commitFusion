<?php
/* Se utiliza la version de Denis Basta */
require_once('scripts/routeros-api/routeros_api.class.php');

$user = 'admin';
$pass = '';
$server = 'Transvimar';
$id_server=56;
$ip = '192.168.65.65';   // 941
// $ip = '192.168.45.94';   // 951
// $ip = '192.168.45.75';   // 952
// $ip = '192.168.45.69';   // 2011


$API = new RouterosAPI();
$API->debug = false;
if ($API->connect($ip, $user, $pass)) {
    print_r("Conexión establecida.\n");

    // /* RESET CONFIG */
    // print_r("-> Reset Config <-\n");
    // if (enviaComando('/system/reset-configuration',array('no-defaults'=>'yes','skip-backup'=>'yes', 'run-after-reset'=>'inicio.rsc'))){
    //     print_r("Se ha ejecutado con éxito\n");
    // }else{
    //     print_r("ERROR: No se ha podido ejecutar el comando\n");
    // }
    
    
    $API->write('/system/routerboard/print');
    $READ = $API->read();
    $hotspotserial = $READ[0]['serial-number'];

    if (enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/script_hotspot?id_hotspot=$id_server&hotspot_serial=$hotspotserial", "dst-path"=>'flash/hotspot.rsc'))){
    	Echo "ok";
    } else {
    	echo "fail";
    }

    print_r("Cambio de usuario.\n");
    if (enviaComando('/user/add',array('name'=>'administrador', 'group'=>'full', 'password'=>'sb_A54$x'))){
        print_r("Se ha ejecutado con éxito\n\n");
        if (enviaComando('/user/remove',array('numbers'=>'admin'))){
            print_r("Se ha ejecutado con éxito\n\n");
        }else{
            print_r("ERROR: No se ha podido cambiar el usuario\n");
        }
    }else{
        print_r("ERROR: No se ha podido cambiar el usuario\n");
    }
    
    /* PONER SERVIDORES GOOGLE */
    print_r("- GOOGLE SERVERS -\n\n");
    $API->write('/ip/dns/print');
    $READ = $API->read();
    if ($READ[0]['servers'] == ''){
        if (enviaComando('/ip/dns/set', array("servers"=>"8.8.8.8, 8.8.4.4", "allow-remote-requests"=>"true"))){
            print_r("--Se ha ejecutado con éxito\n\n");
        }else{
            print_r("--ERROR: No se ha podido establecer GOOGLE SERVERS\n\n");
        }
    }
    
    /* SYSTEM IDENTITY */
    print_r("- SYSTEM IDENTITY -\n\n");
    if (enviaComando('/system/identity/set', array("name"=>$server))){
        print_r("--Se ha ejecutado con éxito\n\n");
    } else {
        print_r("---ERROR: No se ha podido establecerSYSTEM IDENTITY\n\n");
    }

    /* CLIENTE NTP */
    print_r("- CLIENTE NTP -\n\n");
    if (enviaComando('/system/ntp/client/set', array('enabled'=>'yes', 'primary-ntp'=>'130.206.3.166'))){
        print_r("--Se añadido el cliente NTP\n\n");
    } else {
        print_r("---ERROR: No se ha podido establecer CLIENTE NTP\n\n");
    }
    
    print_r("- ZONA HORARIA -\n\n");
    if (enviaComando('/system/clock/set', array("time-zone-name"=>'Atlantic/Canary', "time-zone-autodetect" => "no"))){
        print_r("--Se ha establecido la zona horaria\n\n");
    } else {
        print_r("---ERROR: No se ha podido establecer ZONA HORARIA\n\n");
    }
    
    print_r("- VPN -\n\n");
    if (enviaComando('/interface/pptp-client/add', array("name"=>'Servibyte', "connect-to" => "217.125.25.165", "user"=>$server, "password"=>"A54_sb?8", "disabled"=>"no"))){
        print_r("--Se ha establecido la conexion a la VPN\n\n");
    } else {
        print_r("---ERROR: No se ha podido establecer la conexion VPN\n\n");
    }
  
    
    /* CREACION DE BRIDGES */
    print_r("- CREACION DE BRIDGES, INTERFACES, VLANs -\n\n");
    if (enviaComando('/interface/bridge/add', array("name"=>'bridge1_hs_clientes1', 'protocol-mode'=>'none'))){
        print_r("--Se ha añadido bridge1_hs_clientes1\n");
        if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'bridge1_hs_clientes1','discover'=>'no'))){
            print_r("--Discovery no de bridge1_hs_clientes1\n");
        }else print_r("---ERROR: No se pudo añadir Discovery no de bridge1_hs_clientes1\n");
        
        if (enviaComando('/interface/bridge/add', array("name"=>'bridge2_hs_clientes2', 'protocol-mode'=>'none'))){
            print_r("--Se ha añadido bridge2_hs_clientes2\n");
            if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'bridge2_hs_clientes2','discover'=>'no'))){
                print_r("--Discovery no de bridge2_hs_clientes2\n");
            }else print_r("---ERROR: No se pudo añadir Discovery no de bridge2_hs_clientes2\n");
            
            if (enviaComando('/interface/bridge/add', array("name"=>'bridge3_hs_staff', 'protocol-mode'=>'none'))){
                print_r("--Se ha añadido bridge3_hs_staff\n");
                if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'bridge3_hs_staff','discover'=>'no'))){
                    print_r("--Discovery no de bridge3_hs_staff\n");
                }else print_r("---ERROR: No se pudo añadir Discovery no de bridge3_hs_staff\n");
                    
                // PARTE WIRELESS 2
                print_r("-> Interfaces Wifi\n");
                $API->write('/interface/wireless/getall');
                $READ = $API->read();
                if(count($READ) > 0){
                    if (!array_key_exists('!trap', $READ)) {
                        if(enviaComando('/interface/wireless/security-profiles/add', array('authentication-types'=>'wpa-psk,wpa2-psk', 'eap-methods'=>"", 'management-protection'=>'allowed', 'mode'=>'dynamic-keys', 'name'=>'profile_staff', 'supplicant-identity'=>'', 'wpa-pre-shared-key'=>$server.'_sb_staff', 'wpa2-pre-shared-key'=>$server.'_sb_staff'))){
                            foreach ($READ as $key => $value) {
                                if (enviaComando('/interface/wireless/set', array("numbers"=> $key,"disabled"=>"no", "mode"=>"ap-bridge", "band"=>((strstr($value['band'],'2ghz'))?"2ghz-b/g/n":"5ghz-a/n/ac"), "channel-width"=>"20mhz", "frequency"=>((strstr($value['band'],'2ghz'))?2437:5240), "wireless-protocol"=>"802.11", "default-forwarding"=>"no", "ssid"=>$server,"radio-name"=>$server, "name"=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5')))){
                                    if (enviaComando('/ip/neighbor/discovery/set', array('numbers'=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5'),'discover'=>'no'))){
                                        if (enviaComando('/interface/bridge/port/add', array("bridge"=> "bridge1_hs_clientes1","interface"=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5')))) {
                                            if (enviaComando('/interface/wireless/add', array("disabled"=>'yes', "keepalive-frames"=>"disabled", "master-interface"=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5'), "multicast-buffering"=>"disabled", "name"=>$server."_Staff_".((strstr($value['band'],'2ghz'))?"2":"5"), "ssid"=>$server."_Staff", "wds-cost-range"=>0, "wds-default-cost"=>0, "wps-mode"=>"disabled", "mac-address"=>"0".$key.substr($value['mac-address'], 2),'security-profile'=>'profile_staff'))) {
                                                if (enviaComando('/interface/bridge/port/add', array("bridge"=> "bridge3_hs_staff","interface"=>$server."_Staff_".((strstr($value['band'],'2ghz'))?"2":"5")))) {
                                                    print_r("--Se ha completado la config del Wireless\n");
                                                }else print_r("---ERROR: No se ha podido ejecutar el comando\n");
                                            }else print_r("---ERROR: No se ha podido ejecutar el comando\n");
                                        }else print_r("---ERROR: No se ha podido ejecutar el comando\n");
                                    }else print_r("---ERROR: No se ha podido ejecutar el comando\n");
                                }else print_r("---ERROR: No se ha podido ejecutar el comando\n");
                            }
                        }else print_r("---ERROR: No se ha podido ejecutar el comando\n");
                    }else print_r("---ERROR: No se ha podido ejecutar el comando\n");
                }
                if (enviaComando('/interface/bridge/add', array("name"=>'bridge_trunk', 'protocol-mode'=>'none'))){
                    print_r("--Se ha añadido bridge_trunk\n"); 
                    
                    if(enviaComando('/interface/bridge/add', array("name"=>'bridge4_administracion', 'protocol-mode'=>'none'))){
                        print_r("--Se ha añadido bridge4_administracion\n"); 
                        
                        if(enviaComando('/interface/bridge/add', array("name"=>'bridge5_WAN', 'protocol-mode'=>'none'))){
                            print_r("--Se ha añadido bridge5_WAN\n"); 
                            
                            
                            if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'bridge5_WAN','discover'=>'no'))){
                                print_r("--Discovery no de bridge5_WAN\n");
                            }else print_r("---ERROR: No se ha podido añadir Discovery no de bridge5_WAN\n");
                            
                            // print_r("-> Se añade DHCP client a bridge5_WAN <-");
                            // if(enviaComando('/ip/dhcp-client/add', array('dhcp-options'=>'hostname,clientid','disabled'=>'no','interface'=>'bridge5_WAN'))){
                            //     print_r("Se ha añadido DHCP client a bridge5_WAN\n");
                            // }else print_r("No se ha podido añadir DHCP client a bridge5_WAN\n");
                            
                            
                        }else print_r("---ERROR: No se ha podido añadir bridge5_WAN\n");
                        
                        
                        
                    }else print_r("---ERROR: No se ha podido añadir bridge4_administracion\n");
                    
                    print_r("-> Agregamos comentarios a las interfaces y añadimos los puertos a los bridges corresp.\n");
                    
                    $res = $API->write('/interface/ethernet/getall');
                    $READETHER = $API->read();
                    
                    $res = $API->write('/system/routerboard/getall');
                    $READ = $API->read();
                    if(count($READ) > 0){
                        if (!array_key_exists('!trap', $READ) && !array_key_exists('!trap', $READETHER)){
                            if(enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge5_WAN','interface'=>'ether1'))) {
                                print_r("--Se añade ether1 a bridge5_WAN\n");
                            } else print_r("---ERROR: No se ha podido añadir ether1 a bridge5_WAN\n");
                            
                            
                            
                            if (enviaComando('/interface/set', array('numbers'=>'ether2','comment'=>'ether2_clientes1'))) print_r("comentario para ether2\n");
                            else print_r("---ERROR: No se ha podido añadir comentario para ether2\n");
                            
                            /* Se añaden comentarios a las distintas interfaces */
                            if (strstr($READ[0]['model'],'941') > -1 || strstr($READ[0]['model'],'951') > -1 || strstr($READ[0]['model'],'952') > -1) {
                                
                                if (enviaComando('/interface/set', array('numbers'=>'ether3','comment'=>'ether3_adm'))) print_r("comentario para ether3\n");
                                else print_r("---ERROR: No se ha podido añadir comentario para ether3\n");
                                
                                if (enviaComando('/interface/set', array('numbers'=>'ether4','comment'=>'ether4_trunk'))) print_r("comentario para ether4\n");
                                else print_r("---ERROR: No se ha podido añadir comentario para ether4\n");
                    
                                 /* Se añaden los puertos al bridge correspondiente */
                                if (enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge1_hs_clientes1','interface'=>'ether2'))){
                                    print_r("--Se añade ether2 a bridge1_hs_clientes1\n");
                                    
                                    if (enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge4_administracion','interface'=>'ether3'))){
                                        print_r("--Se añade ether3 a bridge4_administracion\n");
                                        /* Se deshabilita interface de admin */
                                        
                                        if(enviaComando('/interface/disable', array('numbers'=>'ether3'))) print_r("Se deshabilita interface de admin\n");
                                        else print_r("---ERROR: No se ha podido deshabilitar el interface de admin\n");
                                        
                                        if (enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge_trunk','interface'=>'ether4'))){
                                            print_r("--Se añade ether4 a bridge_trunk\n");
                                            
                                            /* Dependiendo del modelo con el que estemos operando realizamos */ 
                                            if (strstr($READ[0]['model'],'951') > -1 || strstr($READ[0]['model'],'952') > -1){
                                                /* Si estamos trabajando con los modelos 951 o 952 incluimos tambien ether5*/
                                                 
                                                if(enviaComando('/interface/set', array('numbers'=>'ether5','comment'=>'ether5_trunk'))) {
                                                    print_r("--Se añade comentario para ether5\n");
                                                    
                                                    if(enviaComando('/interface/disable', array('numbers'=>'ether5'))) {
                                                        print_r("--Se deshabilita ether5\n");
                                                        
                                                        if(enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge_trunk','interface'=>'ether5'))) {
                                                            print_r("--Se añade ether5 a bridge_trunk\n");
                                                        } else print_r("---ERROR: No se ha podido añadir ether5 a bridge_trunk\n");
                                                        
                                                    } else print_r("---ERROR: No se ha podido deshabilitar ether5\n");
                                                        
                                                } else print_r("---ERROR: No se ha podido comentar ether5\n");
                                            }
                                        }else print_r("---ERROR: No se ha podido añadir ether4 a bridge_trunk\n");
                                        
                                    }else print_r("---ERROR: No se ha podido añadir ether3 a bridge4_administracion\n");
                                    
                                }else print_r("---ERROR: No se ha podido añadir ether2 a bridge1_hs_clientes1\n");
                                
                            } else if(strstr($READ[0]['model'],'1009') > -1 || strstr($READ[0]['model'],'1100') > -1 || strstr($READ[0]['model'],'2011') > -1 || strstr($READ[0]['model'],'3011') > -1){
                                
                                if (enviaComando('/interface/set', array('numbers'=>'ether3','comment'=>'ether3_clientes2'))) print_r("--comentario para ether3\n");
                                else print_r("---ERROR: No se ha podido añadir comentario para ether3\n");
                                
                                if (enviaComando('/interface/set', array('numbers'=>'ether4','comment'=>'ether4_staff'))) print_r("--comentario para ether4\n");
                                else print_r("---ERROR: No se ha podido añadir comentario para ether4\n");
                                
                                if (enviaComando('/interface/set', array('numbers'=>'ether5','comment'=>'ether5_adm'))) print_r("--comentario para ether5\n");
                                else print_r("---ERROR: No se ha podido añadir comentario para ether5\n");
                                
                                if (enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge1_hs_clientes1','interface'=>'ether2'))) {
                                  print_r("--ether2 añadido a bridge1_hs_clientes1\n"); 
                                   
                                    if (enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge2_hs_clientes2','interface'=>'ether3'))) {
                                      print_r("--ether3 añadido a bridge2_hs_clientes2\n"); 
                                       
                                        if (enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge3_hs_staff','interface'=>'ether4'))) {
                                          print_r("--ether4 añadido a bridge3_staff\n"); 
                                           
                                            if (enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge4_administracion','interface'=>'ether5'))) {
                                              print_r("--ether5 añadido a bridge4_administracion\n"); 
                                              
                                                if (enviaComando('/interface/disable', array('numbers'=>'ether5'))){
                                                  print_r("--ether5 deshabilitado\n");
                                                  
                                                    for($i=5; $i <= (count($READETHER) - 1); $i++){
                                                        
                                                        if(enviaComando('/interface/set', array('numbers'=>$READETHER[$i]['name'],'comment'=>$READETHER[$i]['name'].'_trunk'))){
                                                            print_r("--Se acomentan resto de ether a ether_trunk\n");
                                                            if(enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge_trunk','interface'=>$READETHER[$i]['name']))){
                                                                print_r("--Se añaden las ether trunk al bridge_trunk\n");
                                                            } else print_r("---ERROR: No se ha podido añadir las ether trunk al bridge_trunk\n");
                                                            
                                                        }else print_r("---ERROR: No se ha podido comentar las ether_trunk\n");
                                                        
                                                    }
                                                }else print_r("---ERROR: No se ha podido deshabilitar ether5\n");
                                                
                                            } else print_r("---ERROR: No se ha podido añadir ether5 a bridge4_administracion\n");
                                           
                                        } else print_r("---ERROR: No se ha podido añadir ether4 a bridge3_staff\n");
                                       
                                    } else print_r("---ERROR: No se ha podido añadir ether3 a bridge2_hs_clientes2\n");
                                   
                                } else print_r("---ERROR: No se ha podido añadir ether2 a bridge1_hs_clientes1\n");
                                   
                            }
                        }
                    }
                    
                    /* CREACION DE VLANS */
                    print_r("-> CREACION DE VLANs <-\n");
                    if (enviaComando('/interface/vlan/add', array('name'=>'vlan1001_br-trunk_clientes1', 'vlan-id'=> '1001', 'interface'=>'bridge_trunk'))){
                        print_r("--Se ha añadido vlan1001_br-trunk_clientes1\n");
                        if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'vlan1001_br-trunk_clientes1','discover'=>'no'))){
                            print_r("--Discovery no de vlan1001_br-trunk_clientes1\n");
                        }else print_r("---ERROR: No se pudo añadir Discovery no de vlan1001_br-trunk_clientes1\n");
                        
                        if (enviaComando('/interface/vlan/add', array('name'=>'vlan1002_br-trunk_clientes2', 'vlan-id'=> '1002', 'interface'=>'bridge_trunk'))){
                            print_r("--Se ha añadido vlan1002_br-trunk_clientes2\n");
                            if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'vlan1002_br-trunk_clientes2','discover'=>'no'))){
                                print_r("--Discovery no de vlan1002_br-trunk_clientes2\n");
                            }else  print_r("---ERROR: No se pudo añadir Discovery no de vlan1002_br-trunk_clientes2\n");
                            
                            if (enviaComando('/interface/vlan/add', array('name'=>'vlan1003_br-trunk_staff', 'vlan-id'=> '1003', 'interface'=>'bridge_trunk'))){
                                print_r("--Se ha añadido vlan1003_br-trunk_staff\n");
                                
                                if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'vlan1003_br-trunk_staff','discover'=>'no'))){
                                    print_r("--Discovery no de vlan1003_br-trunk_staff\n");
                                }else print_r("---ERROR: No se pudo añadir Discovery no de vlan1003_br-trunk_staff\n");
                                
                                if (enviaComando('/interface/vlan/add', array('name'=>'vlan1004_br-trunk_adm', 'vlan-id'=> '1004', 'interface'=>'bridge_trunk'))){
                                    print_r("--Se ha añadido vlan1004_br-trunk_adm\n");
                                    if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'vlan1004_br-trunk_adm','discover'=>'no'))){
                                        print_r("--Discovery no de vlan1004_br-trunk_adm\n");
                                    }else print_r("---ERROR: No se pudo Discovery no de vlan1004_br-trunk_adm\n\n");
                                         
                                } else print_r("---ERROR: No se ha podido ejecutar el comando\n");
                            } else print_r("---ERROR: No se ha podido ejecutar el comando\n");
                        } else print_r("---ERROR: No se ha podido ejecutar el comando\n");
                    } else print_r("---ERROR: No se ha podido realizar CREACION DE VLANs\n");
                } else print_r("---ERROR: No se ha podido ejecutar el comando\n");     
            } else print_r("---ERROR: No se ha podido ejecutar el comando\n");  
        } else print_r("---ERROR: No se ha podido ejecutar el comando\n");    
    } else print_r("--ERROR: NO SE HA PODIDO CONFIGURAR CORRECTAMENTE LOS BRIDGES, INTERFACES Y VLANs\n\n");

    
    
    /* FALTA CONEXION A VPN */
    print_r("- SE ESTABLECE LOGGING ACTIONS -\n\n");
    if(enviaComando('/system/logging/action/set', array('numbers'=>'memory', 'memory-lines'=>'100'))){
        print_r("--Action set memory-lines a 100\n\n");
    }else print_r("---ERROR: No se pudo realizar action set memory-lines a 100\n\n");
    
    if(enviaComando('/system/logging/action/set', array('numbers'=>'disk', 'disk-lines-per-file'=>'100'))){
        print_r("--Action set disk-per-lines a 100\n\n");
    }else print_r("---ERROR: No se pudo completar action set disk-per-lines a 100\n\n");
    /* SBREMOTE AQUI? */
 
    print_r("- SE ESTABLECE FIREWALL -\n\n");
    if(enviaComando('/ip/firewall/filter/add', array('chain'=>'forward','comment'=>'establecidas', 'connection-state'=>'established'))){
        print_r("--Filter añadido\n\n");
    }else print_r("---ERROR: Filter NO añadido\n");
    
    if(enviaComando('/ip/firewall/filter/add', array('chain'=>'input', 'connection-state'=>'established'))){
        print_r("Filter añadido\n\n");
    }else print_r("---ERROR: Filter NO añadido\n");
    
    if(enviaComando('/ip/firewall/filter/add', array('chain'=>'forward','comment'=>'relacionadas', 'connection-state'=>'related'))){
        print_r("Filter añadido\n\n");
    }else print_r("---ERROR: Filter NO añadido\n");
    
    if(enviaComando('/ip/firewall/filter/add', array('chain'=>'input', 'connection-state'=>'related'))){
        print_r("--Filter añadido\n\n");
    }else print_r("---ERROR: Filter NO añadido\n");
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'drop','chain'=>'forward','comment'=>'invalidas', 'connection-state'=>'invalid'))){
        print_r("--Filter añadido\n\n");
    }else print_r("---ERROR: Filter NO añadido\n");
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'drop', 'chain'=>'input', 'connection-state'=>'invalid'))){
        print_r("--Filter añadido\n\n");
    }else print_r("---ERROR: Filter NO añadido\n");
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'tarpit', 'chain'=>'forward', 'comment'=>'Port Scan Detection', 'protocol'=>'tcp', 'psd'=>'21,3s,3,1'))){
        print_r("--Filter añadido\n\n");
    }else print_r("---ERROR: Filter NO añadido\n");
    
    if(enviaComando('/ip/firewall/filter/add', array('chain'=>'input', 'comment'=>'ICMP <10 PPS sino drop', 'limit'=>'10,0:packet', 'protocol'=>'icmp'))){
        print_r("--Filter añadido\n\n");
    }else print_r("---ERROR: Filter NO añadido\n");
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'drop', 'chain'=>'input', 'protocol'=>'icmp'))){
        print_r("--Filter añadido\n\n");
    }else print_r("---ERROR: Filter NO añadido\n\n");
    
    print_r("- SCRIPT MONITORIZACION -\n\n");
    if(enviaComando('/system/script/add', array('name'=>'Monitorizacion', 'owner'=>"administrador",'policy'=>' ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'source'=>":log warning (\":".$server."::Hotspot::up:\" .[/system resource get uptime] . \";cpu-load:\" . [/system resource get cpu-load] . \";connected:\" . [/interface wireless registration-table print count-only])"))){
        print_r("--Script Monitorizacion añadido\n\n");
        if(enviaComando('/system/scheduler/add', array('interval'=>'15m', 'name'=>"Monitorizacion",'on-event'=>'Monitorizacion', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/01/2016', 'start-time'=>'00:00:00'))){
            print_r("--SCHEDULER añadido\n\n");
        }else print_r("---ERROR: SCHEDULER NO añadido\n\n");
    }else print_r("---ERROR: Script MONITORIZACION NO añadido\n\n");


    print_r("- LAYER7 -\n\n");
    if(enviaComando('/ip/firewall/layer7-protocol/add', array("name"=>"facebook","regexp"=>"^.+(facebook.com).*\$"))){
        print_r("--layer7-protocol añadido\n");
    }else print_r("---ERROR: layer7-protocol no se ha añadido\n"); 
    
    if(enviaComando('/ip/firewall/layer7-protocol/add', array("name"=>"facebook2","regexp"=>".+(facebook.com)*dialog"))){
        print_r("--layer7-protocol añadido\n");
    }else print_r("---ERROR: layer7-protocol no se ha añadido\n");
    
    if(enviaComando('/ip/firewall/layer7-protocol/add', array("name"=>"facebook3","regexp"=>".+(facebook.com)*login"))){
        print_r("--layer7-protocol añadido\n\n");
    }else print_r("---ERROR: layer7-protocol no se ha añadido\n\n");
    


    print_r("- CREACION DE HOTSPOT -\n\n");
    if (enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/certificate.crt"))){
        print_r("--Fetch del primer certificado\n");
        if(enviaComando('/certificate/import', array("file-name"=> "certificate.crt", "passphrase"=>"PwpXXf8bPwpXXf8b"))){
            print_r("--Se ha importado el certificado con exito\n");
            
            if (enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot.key"))){
                print_r("--Fetch del segundo certificado\n");
                if(enviaComando('/certificate/import', array("file-name"=> "hotspot.key", "passphrase"=>"PwpXXf8bPwpXXf8b"))){
                    print_r("--Se ha importado el segundo certificado con exito\n");
                    
                    if (enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/certificate.ca-crt"))){
                        print_r("--Fetch del tercer certificado\n");
                        if(enviaComando('/certificate/import', array("file-name"=> "certificate.ca-crt", "passphrase"=>"PwpXXf8bPwpXXf8b"))){
                            print_r("--Se ha importado el tercer certificado con exito\n");
                        
                            print_r("-> Perfiles y usuarios del hotspot <-\n");  
                             
                            if(enviaComando('/ip/hotspot/profile/set', array('numbers'=>'default','html-directory'=>'flash/hotspot'))){
                                print_r("--Se establece perfil default de hotspot a directorio flash/hotspot\n");
                            }else print_r("--Se establece perfil default de hotspot a directorio flash/hotspot\n");
                            
                            if(enviaComando('/ip/hotspot/profile/add', array('dns-name'=>'hotspot.wifipremium.com', 'hotspot-address'=>'172.21.0.1','http-cookie-lifetime'=>'1w', 'login-by'=>'cookie,http-chap,https,mac-cookie','name'=>'hsprof1', 'ssl-certificate'=>'certificate.crt_0', 'use-radius'=>'yes'))){
                                print_r("--Se añade perfil hsprof1 al hotspot\n");
                            }else print_r("---ERROR: no se ha podido añadir el perfil de hotspot hsprof1\n");
                            
                            if(enviaComando('/ip/hotspot/add', array('disabled'=>'no', 'idle-timeout'=>'none','interface'=>'bridge1_hs_clientes1','name'=>$server, 'profile'=>'hsprof1'))){
                                print_r("--Se añade hotspot API\n");
                                print_r("-> IP bindings <-\n");  
                                if(enviaComando('/ip/hotspot/ip-binding/add', array('address'=>'172.21.9.171','mac-address'=>'04:18:D6:84:83:1A','server'=>$server, 'to-address'=>'172.21.9.171','type'=>'bypassed'))){
                                    print_r("--Se añade IP Binding del Hotspot\n");
                                }else print_r("---ERROR: no se ha podido añadir IP Binding del Hotspot\n");
                            
                                print_r("-> Se añade radius <-\n"); 
                                if(enviaComando('/radius/add', array("address"=>"176.28.102.26",'secret'=>'tachin','service'=>'hotspot','timeout'=>'5s'))){
                                    print_r("--Se ha añadido radius\n");
                                }else print_r("---ERROR: No se ha podido radius\n");
                                
                            }else print_r("---ERROR: NO SE HA PODIDO AÑADIR HOTSPOT API\n");
                            
                            if(enviaComando('/ip/hotspot/user/profile/set', array('numbers'=>'default', 'keepalive-timeout'=>'1w','mac-cookie-timeout'=>'1w','rate-limit'=>'3M/3M', 'shared-users'=>'3'))){
                                 print_r("--Se edita perfil de usuario de hotspot default\n");
                            }else print_r("---ERROR: No se ha podido editar perfil de usuario de hotspot default\n");
                            
                            if(enviaComando('/ip/hotspot/user/profile/add', array('name'=>'tecnico', 'transparent-proxy'=>'yes','shared-users'=>'5'))){
                                print_r("--Se añade perfil tecnico al hotspot\n");
                            }else print_r("---ERROR: No se ha podido añadir perfil tecnico al hotspot\n");
                            
                            if(enviaComando('/ip/hotspot/user/profile/add', array('keepalive-timeout'=>'1w', 'mac-cookie-timeout'=>'1w','name'=>'uprof1','rate-limit'=>'5M/10M', 'shared-users'=>'3'))){
                                 print_r("--Se añade perfil uprof al hotspot\n");
                            } else print_r("---ERROR: No se ha podido añadir uprof tecnico al hotspot\n");

                            print_r("-> Adicion de pool y y DHCP servers <-\n");
                            if(enviaComando('/ip/pool/add', array('name'=>'hs-pool-14', 'ranges'=>'172.21.0.2-172.21.255.254'))){
                                print_r("--Se ha añadido pool hs-pool-14\n");
                                if(enviaComando('/ip/dhcp-server/add', array('address-pool'=>'hs-pool-14', 'authoritative'=>'yes','disabled'=>'no','interface'=>'bridge1_hs_clientes1','lease-time'=>'1w','name'=>'dhcp1'))){
                                    print_r("--Se ha añadido DHCP server dhcp1\n");
                                    
                                    /*Añadir aqui las networks*/                            
                                    if(enviaComando('/ip/dhcp-server/network/add', array('address'=>'172.21.0.0/16', 'comment'=>'hotspot network','dns-server'=>'8.8.8.8,8.8.4.4','gateway'=>'172.21.0.1','netmask'=>'32'))){
                                        print_r("--Se añade hotspot network\n\n");
                                    }else print_r("---ERROR: No se ha podido añadir HOTSPOT NETWORK\n\n");
                                     
                                }else print_r("---ERROR: No se ha podido añadir DHCP server dhcp1\n");
                            } else print_r("---ERROR: No se ha podido añadir pool hs-pool-14\n");
                        }else print_r("---ERROR: NO SE HA PODIDO importar el tercer certificado con exito\n");
                    }else print_r("---ERROR: NO SE HA PODIDO hacer fetch del tercer certificado con exito\n");
                }else print_r("---ERROR: NO SE HA PODIDO importar el segundo certificado con exito\n");
            }else print_r("---ERROR: NO SE HA PODIDO hacer fetch del segundo certificado con exito\n");
        }else print_r("---ERROR: NO SE HA PODIDO importar el certificado con exito\n");
    }else print_r("---ERROR: NO SE HA PODIDOCREAR HOTSPOT\n\n");
    

    print_r("- SE ESTABLECE CORREO -\n\n");     
    if(enviaComando('/snmp/set', array("enabled"=> "yes", "contact"=> "info@servibyte.com", "location"=>"Maspalomas", "trap-community"=>"public", "trap-version"=>"2", "trap-generators"=>"interfaces", "trap-interfaces"=>"all" ))){
        print_r("--Se ha añadido el SNMP con exito\n");
        print_r("-> Config. de tool email.\n"); 
        if(enviaComando('/tool/e-mail/set', array("address"=> "74.125.206.108", "port"=> "587", "start-tls"=>"yes", "from"=>"servibyte.log@gmail.com", "user"=>"Servibyte.log", "password"=>"sbyte_14_Mxz"))){
            print_r("--Se ha añadido el email con exito\n");
            if(enviaComando('/system/logging/action/add', array("name"=> "email", "target"=> "email", "email-to"=>"servibyte.log@gmail.com", "email-start-tls"=>"yes"))){
                 print_r("Se ha añadido el logging al email con exito\n\n");
            }else  print_r("No se ha podido añadir el logging al email con exito\n");
        }else print_r("---ERROR: No se ha podido añadir el email\n");
    }else print_r("---ERROR: Error al establecer el CORREO\n\n");
    
    print_r("- FETCH DE SYSNOTE -\n\n"); 
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/sys-note.txt"))){
        print_r("--Se ha realizado el fetch de sys-note\n\n");
    }else print_r("---ERROR: No se ha realizado el fetch de sys-note\n\n");
    
    print_r("- SE ESTABLECE IPSERVICES -\n\n");   
    if(enviaComando('/ip/service/set', array("numbers"=>"telnet",'disabled'=>'yes'))){
        print_r("--Se deshabilita servicio telnet\n");
    }else print_r("---ERROR: error al deshabilitar telnet\n");
    if(enviaComando('/ip/service/set', array("numbers"=>"ftp",'disabled'=>'yes'))){
        print_r("--Se deshabilita servicio ftp\n");
    }else print_r("---ERROR: error al deshabilitar ftp\n");
    if(enviaComando('/ip/service/set', array("numbers"=>"www",'disabled'=>'yes'))){
        print_r("--Se deshabilita  deshabilitar www\n");
    }else print_r("---ERROR: error al deshabilitar www\n");
    if(enviaComando('/ip/service/set', array("numbers"=>"www-ssl",'certificate'=>'certificate.crt_0','disabled'=>'no'))){
        print_r("--Se importa cert para servicio www-ssl\n\n");
    }else print_r("---ERROR: error al importar cert para servicio www-ssl\n\n");
    
    
    /* HAY QUE AÑADIR LAS NETWORKS A LOS DHCP SERVERS -linea390- O NO?*/
    print_r("- CREACION POOLS Y DHCP SERVERS POOL_ADM -\n\n"); 
    if(enviaComando('/ip/pool/add', array('name'=>'pool_adm', 'ranges'=>'172.20.0.2-172.20.0.254'))){
        print_r("--Se ha añadido pool pool_adm\n");
        if(enviaComando('/ip/dhcp-server/add', array('address-pool'=>'pool_adm', 'authoritative'=>'yes','disabled'=>'no','interface'=>'bridge4_administracion','name'=>'dhcp_adm'))){
            print_r("--Se ha añadido DHCP server dhcp_adm\n");
            /*Añadir aqui las networks?*/ 
            if(enviaComando('/ip/dhcp-server/network/add', array('address'=>'172.20.0.0/22', 'comment'=>'admin network','dns-server'=>'8.8.8.8,8.8.4.4','gateway'=>'172.20.0.1','netmask'=>'22'))){
                print_r("--Se añade admin network\n\n");
            } else print_r("---ERROR: No se ha podido añadir admin network\n");
        } else print_r("---ERROR: No se ha podido añadir DHCP server dhcp_adm\n");
    } else print_r("---ERROR: No se ha podido añadir pool pool_adm\n");
     print_r("- CREACION POOLS Y DHCP SERVERS POOL_STAFF -\n\n"); 
    if(enviaComando('/ip/pool/add', array('name'=>'pool_staff', 'ranges'=>'192.168.50.2-192.168.50.254'))){
        print_r("--Se ha añadido pool pool_staff\n");
        if(enviaComando('/ip/dhcp-server/add', array('address-pool'=>'pool_staff', 'authoritative'=>'yes','disabled'=>'no','interface'=>'bridge3_hs_staff','name'=>'dhcp_staff'))){
            print_r("--Se ha añadido DHCP server dhcp_staff\n");
            
            /*Añadir aqui las networks?*/
            if(enviaComando('/ip/dhcp-server/network/add', array('address'=>'192.168.50.0/24', 'comment'=>'staff network','dns-server'=>'8.8.8.8,8.8.4.4','gateway'=>'192.168.50.1','netmask'=>'24'))){
                print_r("--Se añade staff network\n\n");
            }else print_r("---ERROR: No se ha podido añadir staff network\n");
        }else print_r("---ERROR: No se ha podido añadir DHCP server dhcp_staff\n");
    } else print_r("---ERROR: No se ha podido añadir pool pool_staff\n\n");
    
    
    print_r("- CREACION LOGGING ACTION SBREMOTE -\n\n"); 
    if(enviaComando('/system/logging/action/add', array('name'=>'SBRemote', 'remote'=>'217.125.25.165','target'=>'remote'))){
        print_r("-Se añade action SBRemote\n");
        if(enviaComando('/system/logging/add', array('action'=>'SBRemote', 'prefix'=>'Monitor', 'topics'=>'warning,script'))){
            print_r("--Se añade logging SBRemote\n\n");
        }else print_r("---ERROR: No se ha podido realizar la operacion logging SBRemote\n");
    }else print_r("---ERROR: No se ha podido realizar la CREACION LOGGING ACTION SBREMOTE\n");
    print_r("- CREACION LOGGING ACTION HotspotInfo -\n"); 
    if(enviaComando('/system/logging/action/add', array('name'=>'HotspotInfo', 'memory-lines'=>'3000','target'=>'memory'))){
        print_r("--Se añade HotspotInfo\n");
         if(enviaComando('/system/logging/add', array('action'=>'HotspotInfo', 'topics'=>'hotspot,info'))){
            print_r("--Se añade logging HotspotInfo\n\n");
        }else print_r("No se ha podido realizar la operacion HotspotInfo\n");
    }else print_r("---ERROR: No se ha podido realizar la CREACION LOGGING ACTION HotspotInfo\n");
    print_r("- CREACION LOGGING ACTION HotspotDebug -\n"); 
    if(enviaComando('/system/logging/action/add', array('name'=>'HotspotDebug', 'memory-lines'=>'3000','target'=>'memory'))){
        print_r("--Se añade HotspotDebug\n");
         if(enviaComando('/system/logging/add', array('action'=>'HotspotDebug', 'topics'=>'hotspot,debug'))){
            print_r("--Se añade logging HotspotDebug\n\n");
        }else print_r("---ERROR: No se ha podido realizar la operacion HotspotDebug\n");
    }else print_r("---ERROR: No se ha podido realizar la CREACION LOGGING ACTION HotspotDebug\n\n");
    
    print_r("- IP PROPOSAL -\n\n"); 
    
    if(enviaComando('/ip/ipsec/proposal/set', array('numbers'=>'default', 'enc-algorithms'=>'aes-128-cbc'))){
        print_r("--Se establece IP ipsec proposal default\n\n");
    }else print_r("---ERROR: No se ha podido establecer el proposal\n\n");

    
    print_r("- ENTRADAS ESTATICAS DNS -\n\n"); 
    if(enviaComando('/ip/dns/static/add', array('address'=>'172.21.0.1','name'=>'exit.com'))){
        print_r("--Añadido exit.com\n");
        
        if(enviaComando('/ip/dns/static/add', array('address'=>'172.21.0.1','comment'=>'Capturador DNS cuando no hay internet', 'disabled'=>'yes','regexp'=>".*\\..*"))){
            print_r("--Añadido capturador dns cuando no hay internet\n\n");
        }else print_r("---ERROR: No se ha podido añadir capturador dns cuando no hay internet\n");
    }else print_r("---ERROR: No se ha podido añadir ENTRADAS ESTATICAS DNS\n\n");
    

    
    
     
    /*DIRECCIONES ESTÁTICAS */
    print_r("- IP ADDRESSES -\n\n"); 
    if(enviaComando('/ip/address/add', array('address'=>'172.21.0.1/16','comment'=>'hotspot network', 'interface'=>'bridge1_hs_clientes1','network'=>'172.21.0.0'))){
        print_r("--Se añade IP estatica a bridge1_hs_clientes1\n");
    }else print_r("---ERROR: No se ha podido añadir IP estatica a bridge1_hs_clientes1\n");
    if(enviaComando('/ip/address/add', array('address'=>'172.20.0.1/22', 'interface'=>'bridge4_administracion','network'=>'172.20.0.0'))){
        print_r("--Se añade IP estatica a bridge4_administracion\n");
    }else print_r("---ERROR: No se ha podido añadir IP estatica a bridge4_administracion\n");
    if(enviaComando('/ip/address/add', array('address'=>'192.168.50.1/24','comment'=>'Red Staff/IPTV', 'interface'=>'bridge3_hs_staff','network'=>'192.168.50.0'))){
        print_r("--Se añade IP estatica a bridge3_hs_staff\n\n");
    }else print_r("---ERROR: No se ha podido añadir IP estatica a bridge3_hs_staff\n\n");

   

    
    print_r("- ADDRESS-LIST -\n\n"); 
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'204.15.20.0/22','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.176.0/20','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'66.220.144.0/20','list'=>'FacebookIPs'))){
        print_r("-Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'66.220.144.0/21','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.184.0/21','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.176.0/21','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'74.119.76.0/22','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.255.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'173.252.64.0/18','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.224.0/19','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.224.0/20','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'103.4.96.0/22','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.176.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'173.252.64.0/19','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'173.252.70.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.64.0/18','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.24.0/21','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'66.220.152.0/21','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'66.220.159.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.239.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.240.0/20','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.64.0/19','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.64.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.65.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.67.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.68.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.69.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.70.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.71.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.72.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.73.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.74.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.75.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.76.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.77.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.96.0/19','list'=>'FacebookIPs'))){
        print_r("-- Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.66.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'173.252.96.0/19','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.178.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.78.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.79.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.80.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.82.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.83.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.84.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.85.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.86.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.87.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.88.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.89.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.90.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.91.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.92.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.93.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.94.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.95.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.253.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.186.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.81.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'179.60.192.0/22','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'179.60.192.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'179.60.193.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'179.60.194.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'179.60.195.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'185.60.216.0/22','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'45.64.40.0/22','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'185.60.216.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'185.60.217.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'185.60.218.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n");
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'185.60.219.0/24','list'=>'FacebookIPs'))){
        print_r("--Address list añadida\n");
    }else print_r("---ERROR: No se ha podido añadir la address list\n\n");



    print_r("- FIREWALL (FILTER, NAT Y MANGLE) -\n\n"); 
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'add-src-to-address-list','address-list'=>'facebook login','address-list-timeout'=>'3m','chain'=>'input', 'comment'=>'FB Port Knocking 3min access window','dst-port'=>'8090','protocol'=>'tcp'))){
        print_r("--Se añade filter rule FB Port Knocking 3min access window\n"); 
    }else print_r("---ERROR: No se ha podido añadir filter rule FB Port Knocking 3min access window\n"); 
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'drop','chain'=>'input', 'comment'=>'FB Block no auth customers','connection-mark'=>'FBConexion','hotspot'=>'!auth','src-address-list'=>'!facebook login'))){
        print_r("--Se añade filter rule FB Block no auth customers\n"); 
    }else print_r("---ERROR: No se ha podido añadir filter rule FB Block no auth customers\n");
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'passthrough','chain'=>'unused-hs-chain', 'comment'=>'place hotspot rules here','disabled'=>'yes'))){
        print_r("--Se añade filter rule place hotspot rules here\n");
    }else print_r("---ERROR: No se ha podido añadir filter rule place hotspot rules here\n");
  
    if(enviaComando('/ip/firewall/mangle/add', array('action'=>'mark-connection','chain'=>'prerouting', 'comment'=>'FB Connection Mark ','dst-address-list'=>'FacebookIPs','new-connection-mark'=>'FBConexion'))){
        print_r("--Se añade mangle rule FB Connection Mark\n");
    }else print_r("---ERROR: No se ha podido añadir mangle rule FB Connection Mark\n");
    
    if(enviaComando('/ip/firewall/nat/add', array('action'=>'passthrough','chain'=>'unused-hs-chain', 'comment'=>'place hotspot rules here','disabled'=>'yes'))){
        print_r("--Se añade nat rule place hotspot rules here\n");
    }else print_r("---ERROR: No se ha podido añadir nat rule place hotspot rules here\n");
    
    if(enviaComando('/ip/firewall/nat/add', array('action'=>'masquerade','chain'=>'srcnat', 'comment'=>'masquerade hotspot network','out-interface'=>'bridge5_WAN'))){
        print_r("--Se añade nat rule masquerade hotspot network\n");
    }else print_r("---ERROR: No se ha podido añadir nat rule masquerade hotspot network\n");
    
    if(enviaComando('/ip/firewall/nat/add', array('action'=>'add-dst-to-address-list','address-list'=>'fb','chain'=>'pre-hotspot', 'comment'=>'Drop conexiones https cuando unAuth','dst-address'=>'!176.28.102.26','dst-address-list'=>'!FacebookIPs','dst-address-type'=>'!local','dst-port'=>'443','hotspot'=>'!auth','protocol'=>'tcp', 'to-ports'=>'80'))){
        print_r("--Se añade nat rule Drop conexiones https cuando unAuth\n");
    }else print_r("---ERROR: No se ha podido añadir nat rule masquerade Drop conexiones https cuando unAuth\n\n");
 
    /*MOVER A PARTE DE HOTSPOT*/
    //Ponerlo dentro de if anidado de esta parte
    print_r("- Se añaden usuarios para el hotspot -\n\n"); 
    
     if(enviaComando('/ip/hotspot/user/add', array('name'=>$server.'_SBBOSCOSOS','password'=>'SBBOSCOSOS'))){
        print_r("--Se ha añadido el usuario SBBOSCOSOS\n");
    }else print_r("---ERROR: No se ha añadir el usuario SBBOSCOSOS\n");
    
    if(enviaComando('/ip/hotspot/user/add', array('name'=>$server.'_SBBOSCOSOS','password'=>'SBBOSCOSOS','profile'=>'tecnico', 'server'=>$server))){
        print_r("--Se ha añadido el usuario SBBOSCOSOS\n");
    }else print_r("---ERROR: No se ha añadir el usuario SBBOSCOSOS\n");
    
    // if(enviaComando('/ip/hotspot/user/add', array('name'=>'API_AKR_HAB612','password'=>'AKR_HAB612', 'server'=>'API'))){
    //      print_r("--Se ha añadido el usuario API_AKR_HAB612\n");
    // }else print_r("---ERROR: No se ha añadir el usuario API_AKR_HAB612\n");
    
    // if(enviaComando('/ip/hotspot/user/add', array('name'=>'API_URK0GONZALEZ','password'=>'URK0GONZALEZ','profile'=>'uprof1', 'server'=>'API'))){
    //      print_r("--Se ha añadido el usuario API_URK0GONZALEZ\n\n");
    // }else print_r("---ERROR: No se ha añadir el usuario API_URK0GONZALEZ\n\n");
    

    print_r("- WALLED GARDEN -\n\n"); 
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.apple.com"))){
        print_r("--Se ha añadido www.apple.com\n");
    }else print_r("---ERROR: No se ha podido añadir www.apple.com\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.airport.us"))){
        print_r("--Se ha añadido www.airport.us\n");
    }else print_r("---ERROR: No se ha podido añadir www.airport.us\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.itools.info"))){
        print_r("--Se ha añadido www.itools.info\n");
    }else print_r("---ERROR: No se ha podido añadir www.itools.info\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.appleiphonecell.com"))){
        print_r("--Se ha añadido www.appleiphonecell.com\n");
    }else print_r("---ERROR: No se ha podido añadir www.appleiphonecell.com\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"captive.apple.com"))){
        print_r("--Se ha añadido captive.apple.com\n");
    }else print_r("---ERROR: No se ha podido añadir captive.apple.com\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.thinkdifferent.us"))){
        print_r("--Se ha añadido www.thinkdifferent.us\n");
    }else print_r("---ERROR: No se ha podido añadir www.thinkdifferent.us\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"wifipremium.com", "dst-port"=>"443"))){
        print_r("--Se ha añadido wifipremium.com\n");
    }else print_r("---ERROR: No se ha podido añadir wifipremium.com\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.ibook.info"))){
        print_r("--Se ha añadido www.ibook.info\n");
    }else print_r("---ERROR: No se ha podido añadir www.ibook.info\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"*akamai*"))){
        print_r("--Se ha añadido *akamai*\n");
    }else print_r("---ERROR: No se ha podido añadir *akamai*\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"*fbcdn*"))){
        print_r("--Se ha añadido *fbcdn*\n");
    }else print_r("---ERROR: No se ha podido añadir *fbcdn*\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"*facebook*"))){
        print_r("--Se ha añadido *facebook*\n");
    }else print_r("---ERROR: No se ha podido añadir *facebook*\n");
    
    if(enviaComando('/ip/hotspot/walled-garden/ip/add', array("action"=>"accept",'comment'=>'VPS','disabled'=>'no','dst-address'=>'176.28.102.26'))){
        print_r("--Se ha añadido walled garden ip\n\n");
    }else print_r("---ERROR: No se ha podido añadir walled garden ip\n\n");
    
    
    //   /* Borrado de ficheros del router */
    // $API->write('/file/getall');
    // $READ = $API->read();
    // print_r($READ);
    // foreach($READ as $key => $value){
    //     if(strpos($value['name'], 'backup') == false){
    //         $API->comm('/file/remove', array("numbers"=>$value['.id']));
    //     }
    // }
    print_r("- FETCH ARCHIVOS -\n\n"); 
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/alogin.html","dst-path"=>"hotspot/alogin.html"))){
        print_r("--Fetch de alogin.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de alogin.html\n");
    
     if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/averia.jpg","dst-path"=>"hotspot/averia.jpg"))){
        print_r("--Fetch de averia.jpg\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de averia.jpg\n");
    
     if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/error.html","dst-path"=>"hotspot/error.html"))){
        print_r("--Fetch de error.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de error.html\n");
    
     if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/errors.txt","dst-path"=>"hotspot/errors.txt"))){
        print_r("--Fetch de errors.txt\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de errors.txt\n");
    
     if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/interneterror.html","dst-path"=>"hotspot/interneterror.html"))){
        print_r("--Fetch de interneterror.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de interneterror.html\n");
    
     if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/".$hotspotserial."-login.html","dst-path"=>"hotspot/login.html"))){
        print_r("--Fetch de GETSERIALNAME-login.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de $hotspotserial-login.html\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/logoservibyte.png","dst-path"=>"hotspot/logoservibyte.png"))){
        print_r("--Fetch de logoservibyte.png\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de logoservibyte.png\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/logout.html","dst-path"=>"hotspot/logout.html"))){
        print_r("--Fetch de logout.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de logout.html\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/md5.js","dst-path"=>"hotspot/md5.js"))){
        print_r("--Fetch de md5.js\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de md5.js\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/radvert.html","dst-path"=>"hotspot/radvert.html"))){
        print_r("--Fetch de radvert.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de radvert.html\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/redirect.html","dst-path"=>"hotspot/redirect.html"))){
        print_r("--Fetch de redirect.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de redirect.html\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/rlogin.html","dst-path"=>"hotspot/rlogin.html"))){
        print_r("--Fetch de rlogin.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de rlogin.html\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/status.html","dst-path"=>"hotspot/status.html"))){
        print_r("--Fetch de status.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de status.html\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/testinternet.txt","dst-path"=>"hotspot/testinternet.txt"))){
        print_r("--Fetch de testinternet.txt\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de testinternet.txt\n");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/img/logobottom.png","dst-path"=>"hotspot/img/logobottom.png"))){
        print_r("--Fetch de logobottom.png\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de logobottom.png\n");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/alogin.html","dst-path"=>"hotspot/lv/alogin.html"))){
        print_r("--Fetch de lv/alogin.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de lv/alogin.html\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/errors.txt","dst-path"=>"hotspot/lv/errors.txt"))){
        print_r("--Fetch de lv/errors.txt\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de lv/errors.txt\n");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/login.html","dst-path"=>"hotspot/lv/login.html"))){
        print_r("--Fetch de /lv/login.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de /lv/login.html\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/logout.html","dst-path"=>"hotspot/lv/logout.html"))){
        print_r("-Fetch de lv/logout.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de lv/logout.html\n");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/radvert.html","dst-path"=>"hotspot/lv/radvert.html"))){
        print_r("--Fetch de lv/radvert.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de lv/radvert.html\n");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/status.html","dst-path"=>"hotspot/lv/status.html"))){
        print_r("--Fetch de lv/status.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de lv/status.html\n");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/alogin.html","dst-path"=>"hotspot/xml/alogin.html"))){
        print_r("--Fetch de xml/alogin.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de xml/alogin.html\n");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/error.html","dst-path"=>"hotspot/xml/error.html"))){
        print_r("-Fetch de xml/error.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de xml/error.html\n");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/flogout.html","dst-path"=>"hotspot/xml/flogout.html"))){
        print_r("--Fetch de xml/flogout.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de xml/flogout.html\n");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/login.html","dst-path"=>"hotspot/xml/login.html"))){
        print_r("--Fetch de xml/login.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de xml/login.html\n");
   
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/logout.html","dst-path"=>"hotspot/xml/logout.html"))){
        print_r("--Fetch de xml/logout.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de xml/logout.html\n");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/rlogin.html","dst-path"=>"hotspot/xml/rlogin.html"))){
        print_r("--Fetch de xml/rlogin.html\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de xml/rlogin.html\n");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/WISPAccessGatewayParam.xsd","dst-path"=>"hotspot/xml/WISPAccessGatewayParam.xsd"))){
        print_r("--Fetch de xml/WISPAccessGatewayParam.xsd\n");
    }else print_r("---ERROR: No se ha podido hacer fetch de xml/WISPAccessGatewayParam.xsd\n\n");
    
       
    print_r("- NOTE - \n\n"); 
    if(enviaComando('/system/note/set', array('note'=>"\r \********************************************************\ \r\r\r\r    _____                 _ __          __     \r   / ___/___  ______   __(_) /_  __  __/ /____  \r   \\__ \\/ _ \\/ ___/ | / / / __ \\/ / / / __/ _ \\  \r  ___/ /  __/ /   | |/ / / /_/ / /_/ / /_/  __/  \r /____/\\___/_/    |___/_/_.___/\\__, /\\__/\\___/ \r                              /____/           \r \r http://www.servibyte.com         info@servibyte.com\r\r CC Meloneras Playa Local 201-202, 35100 Maspalomas,\r Las Palmas, Canary Islands, Spain\r\r\r UNAUTHORIZED ACCESS TO THIS DEVICE IS PROHIBITED\r\r You must have explicit, authorized permission to access or\r configure this device.\r Unauthorized attempts and actions to access or use this system\r may result in civil and/or criminal penalties.\r ALL activities performed on this device are logged and monitored.\r\r\r"))){
        print_r("--Se añade note\n\n");
    }else print_r("---ERROR: No se ha podido añadir NOTE\n\n");


    /*NO FUNCIONA EN TODOS LOS MODELOS, EN ALGUOS NO ESTA ESTA OPCION*/
    print_r("- SPROTECTED ROUTERBOOT -\n\n"); 
    if(enviaComando('/system/routerboard/settings/set', array("protected-routerboot"=> "enabled"))){
        print_r("--Se establece protected-routerboot\n\n");
    }else print_r("---ERROR: No se ha podido establecer protected-routerboot\n\n");

    
    print_r("- SCRIPT TESTINTERNET -\n\n"); 

    if(enviaComando('/system/script/add', array("name"=> "testinternet", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>":global internetactivo;\r if (\$internetactivo!=0 && \$internetactivo!=1) do={\r:set internetactivo 0;:log error \"Comienza Test Internet\";/file print file=\$myfile; /file set \$file contents=\"interneterror.html\";/ip dns static enable [find comment~\"Capturador\"]}:local myfile \"hotspot/testinternet\";:local file (\$myfile);:local pingresultado [/ping 4.2.2.4 count=5];:if (\$pingresultado>0) do={:if (\$internetactivo=0) do={:log error \"Internet funcionando\";:set internetactivo 1;/file print file=\$myfile /file set \$file contents=\"https:wifipremium.com/login.php\";/ip dns static disable [find comment~\"Capturador\"] } :if (\$pingresultado=0) do={:if (\$internetactivo=1) do={:log error \"Internet caido\";:set internetactivo 0;/file print file=\$myfile /file set \$file contents=\"interneterror.html\"; /ip dns static enable [find comment~\"Capturador\"] }}"))){
        print_r("Script testinternet añadido\n");
        if(enviaComando('/system/scheduler/add', array("disabled"=> "yes", 'interval'=>'5s', 'name'=>'testinternet', 'on-event'=>'testinternet,', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jun/30/2016', 'start-time'=>'07:39:10'))){
            print_r("--Script testinternet scheduled\n\n");
        }else print_r("---ERROR: No se ha podido Script testinternet scheduled\n\n");
    }else print_r("---ERROR: no se ha podido añadir SCRIPT TESTINTERNET\n\n");
    
    
    print_r("- SCRIPT HOTSPOT -\n\n"); 
    if(enviaComando('/system/script/add', array("name"=> "hotspot", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>"execute \"/tool fetch mode=http address=checkip.dyndns.org src-path=/ dst-path=d yndns.checkip.html\" :local result [/file get dyndns.checkip.html contents] :local resultLen [:len \$result] :local startLoc [:find \$result \": \" -1] :set startLoc (\$startLoc + 2) :local endLoc [:find \$result \"</body>\" -1] :local currentIP [:pick \$result \$startLoc \$endLoc] { :local activo 0; :foreach i in=[/system logging find] do={ :if ([/system logging get \$i topics]=\"firewall\") do={ :set activo 1 } }; :log warning (\":coronablanca::hotspot::up:\" . [/system resource get uptime] . \";cpu-load:\" . [/system resource get cpu-load] . \";active:\" . [/ip hotspot active print count-only]  . \";trazabilidad:\" . \$activo. \";ip:\" . \$currentIP)}"))){
        print_r("--Script hotspot añadido\n");
        if(enviaComando('/system/scheduler/add', array('interval'=>'15m', 'name'=>'hotspot', 'on-event'=>'hotspot,', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/26/2016', 'start-time'=>'21:44:20'))){
            print_r("--Script hotspot scheduled\n\n");
        }else print_r("---ERROR: no se ha podido añadir script hotspot\n");
    }else print_r("---ERROR: no se ha podido añadir script hotspot\n\n");
    
    // print_r("- SCRIPT AP10 -\n\n"); 
    // if(enviaComando('/system/script/add', array("name"=> "AP10", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>":if ([/ip neighbor get [find identity=\"AP-10\"]] != \"no such item\") do={:log warning (\":coronablanca::AP-10:: up:00:00:00cpu-load:0\")}"))){
    //     print_r("--Script AP10 añadido\n");
    //     if(enviaComando('/system/scheduler/add', array("disabled"=> "yes",'interval'=>'14m59s', 'name'=>'AP10', 'on-event'=>'AP10', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/26/2016', 'start-time'=>'21:44:20'))){
    //         print_r("--Script AP10 scheduled\n\n");
    //     }else print_r("--Script AP10 scheduled\n");
    // }else print_r("---ERROR: no se ha podido añadir script Ap10\n\n");
    
    // print_r("- SCRIPT AP11 -\n\n");
    // if(enviaComando('/system/script/add', array("name"=> "AP11", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>":if ([/ip neighbor get [find identity=\"AP-11\"]] != \"no such item\") do={:log warning (\":coronablanca::AP-11:: up:00:00:00cpu-load:0\")}"))){
    //     print_r("--Script AP11 añadido\n");
    //     if(enviaComando('/system/scheduler/add', array("disabled"=> "yes",'interval'=>'14m58s', 'name'=>'AP11', 'on-event'=>'AP11', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/26/2016', 'start-time'=>'21:44:20'))){
    //         print_r("--Script AP11 scheduled\n\n");
    //     }else print_r("--Script AP11 scheduled\n\n");
    // }else print_r("---ERROR: no se ha podido añadir script Ap11\n\n");
    
    // print_r("- SCRIPT AP12 -\n\n");
    // if(enviaComando('/system/script/add', array("name"=> "AP12", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>":if ([/ip neighbor get [find identity=\"AP-12\"]] != \"no such item\") do={:log warning (\":coronablanca::AP-12:: up:00:00:00cpu-load:0\")}"))){
    //     print_r("Script AP12 añadido\n");
    //     if(enviaComando('/system/scheduler/add', array("disabled"=> "yes", 'interval'=>'14m57s', 'name'=>'AP12', 'on-event'=>'AP12', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/26/2016', 'start-time'=>'21:44:20'))){
    //         print_r("--Script AP12 scheduled\n\n");
    //     }else print_r("--Script AP12 scheduled\n\n");
    // }else print_r("---ERROR: no se ha podido añadir script Ap12\n\n");
    
    print_r("- SCRIPT delete_user_test -\n\n");
    if(enviaComando('/system/script/add', array("name"=> "delete_user_test", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>":local usertoremove \"VEQODE68\";:local banuser \"noname\";:local banuseridle 00:00:00;:local banusermac \"00:00:00:00:00:00\";:local banuserip \"0.0.0.0\"; :foreach i in [/ip hotspot active find where user~\$usertoremove] do={ :local idle [/ip hotspot active get \$i idle-time]; :if (\$idle>=\$banuseridle) do={:set banuser \$i;:set banuseridle \$idle;:set banusermac [/ip hotspot active get \$i mac-address];:set banuserip [/ip hotspot active get \$i address];}}:if (\$banuser != \"noname\") do={:log warning (\"Usuario \".\$usertoremove.\" con Sesion ID: \".\$banuser.\" y Idle-Time: \".\$banuseridle.\" ha sido banneado\");:log warning (\"MAC: \".\$banusermac);:log warning (\"IP: \".\$banuserip); #:ip hotspot active remove \$banuser;}"))){
        print_r("--Se añade script delete_user_test\n\n");  
    }else print_r("---ERROR: No se ha podido añadir delete_user_test\n\n");
    print_r("- SCRIPT find_no_more_sessions_test -\n");
    if(enviaComando('/system/script/add', array("name"=> "find_no_more_sessions_test", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>" :global lastTime; :local currentBuf [ :toarray [ /log find message~\"no more sessions\" ]] ; :local currentLineCount [ :len \$currentBuf ] ; if (\$currentLineCount > 0) do={ :local currentTime \"\$[ /log get [ :pick \$currentBuf (\$currentLineCount -1) ] time ]\"; :if ([:len \$currentTime] = 15 ) do={  :set currentTime [ :pick \$currentTime 7 15 ];} :local output \"\$currentTime \$[/log get [ :pick \$currentBuf (\$currentLineCount-1) ] message ]\"; :if ([:len \$lastTime] < 1 ) do={ :set lastTime \$currentTime ; if ( [:find \$output \"Moises logged in\" -1] != 0) do={ :log warning (\$currentTime . \" No more sessions encontrado\"); } } else={ :if ( \$lastTime != \$currentTime ) do={ :set lastTime \$currentTime ; if ( [:find \$output \"Moises logged in\" -1] != 0) do={ :log warning (\$currentTime . \" No more sessions encontrado\"); }}}"))){
        print_r("--Se añade script find_no_more_sessions_test\n\n");   
    }else print_r("---ERROR: No se ha podido añadir find_no_more_sessions_test\n");
    print_r("- SCRIPT genera_no_more_sessions -\n");
    if(enviaComando('/system/script/add', array("name"=> "genera_no_more_sessions", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>":log warning \"coronablanca_KUBAGE59 (172.21.32.170): login failed: no more sessions are allowed for user\";"))){
        print_r("--Se añade script genera_no_more_sessions\n");   
    }else print_r("---ERROR: No se ha podido añadir genera_no_more_sessions\n\n");
    
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