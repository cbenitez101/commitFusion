<?php
function usuario_aleatorio($tipoafab, $lon= NULL) {
    $alfabetos= array(
        "T" => array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"), 
        "A"=>array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"),
        "M"=>array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"),
        "m"=>array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"),
        "N"=>array("0","1","2","3","4","5","6","7","8","9"),
        "b"=>array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9"),
        "B"=>array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"),
        "V"=>array("A", "E", "I", "O", "U"),
        "v"=>array("a", "e", "i", "o", "u"),
        "C"=>array("B","C","D","F","G","H","J","K","L","M","N","P","Q","R","S","T","V","W","X","Y","Z"),
        "c"=>array("b","c","d","f","g","h","j","k","l","m","n","p","q","r","s","t","v","w","x","y","z")
        );
    $out = "";
    $kind_of = array();
    if (!is_array($tipoafab)) {
        if (strlen($tipoafab)==1){
            if ($lon == NULL) $kind_of[] = $tipoafab;
            else for ($index = 0; $index < $lon; $index++) $kind_of[]=$tipoafab;
        } else $kind_of = str_split ($tipoafab);
    } else $kind_of = $tipoafab;
    if ($lon == NULL) $lon = count ($kind_of);
    for ($index = 0; $index < $lon; $index++) $out.=$alfabetos[$kind_of[$index]][rand(0, count($alfabetos[$kind_of[$index]])-1)];
    return $out;
}
//$database= new mysqli('localhost', 'platformuser', 'rfC79w?3', 'plataforma');
//$radius= new mysqli('localhost', 'radiususer', 'Pwp+*f2b', 'radius');
// require './scripts/fpdf/fpdf.php';
// $pdf = new FPDF();
// $x = 28;
// for ($i = 0; $i < 50; $i++) {
//    if (($i % 5) == 0) {
//        //Crear pagina y lineas superiores
//        $pdf->AddPage('L', 'A4');
//        $pdf->Line(30, 10, 30, 20);
//        $pdf->Line(70, 10, 70, 20);
//        $pdf->Line(145, 10, 145, 20);
//        $pdf->Line(185, 10, 185, 20);
//        $pdf->Line(260, 10, 260, 20);
//        //Lineas inferiores
//        $pdf->Line(30, 190, 30, 200);
//        $pdf->Line(70, 190, 70, 200);
//        $pdf->Line(145, 190, 145, 200);
//        $pdf->Line(185, 190, 185, 200);
//        $pdf->Line(260, 190, 260, 200);
//        //5 es la diferencia de salto entre uno y otro ticket para las rayas
//        $x = 28;
//    }
   
//    $precio = 15;
//    $exists = false;
//    while (!$exists) {
//        $user = usuario_aleatorio('CVCVCVNN');
//        $aux = $radius->query('SELECT * FROM radusergroup where username = '."SunsGarden".'_'.$user);
//        if ($aux->num_rows == 0) $exists = true;
//    }
//    $pass = usuario_aleatorio('CVCVCVNN');
//    if ($radius->query("INSERT INTO `radusergroup`(`username`, `groupname`, `priority`) VALUES ('"."SunsGarden".'_'.$user."','"."SunsGarden"."',1)")) {
//        if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('"."SunsGarden".'_'.$user."','Cleartext-Password',':=','$pass')")) {
//            if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('"."SunsGarden".'_'.$user."','Called-Station-Id','==','"."SunsGarden"."')")) {
//                if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('"."SunsGarden".'_'.$user."','One-All-Session',':=','604800')"))
//                    $database->query("INSERT INTO `ventashotspot`(`Id_Lote`, `FechaVenta`, `Usuario`, `Precio`) VALUES ('7',NOW(),'"."SunsGarden".'_'.$user."','15')");
//            }   
//        }  
//    }
//    $exists = false;
//    while (!$exists) {
//        $user1 = usuario_aleatorio('CVCVCVNN');
//        $aux = $radius->query('SELECT * FROM radusergroup where username = '."SunsGarden".'_'.$user1);
//        if ($aux->num_rows == 0) $exists = true;
//    }
//    $pass1 = usuario_aleatorio('CVCVCVNN');
//    if ($radius->query("INSERT INTO `radusergroup`(`username`, `groupname`, `priority`) VALUES ('"."SunsGarden".'_'.$user1."','"."SunsGarden"."',1)")) {
//        if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('"."SunsGarden".'_'.$user1."','Cleartext-Password',':=','$pass1')")) {
//            if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('"."SunsGarden".'_'.$user1."','Called-Station-Id','==','"."SunsGarden"."')")) {
//                if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('"."SunsGarden".'_'.$user1."','One-All-Session',':=','604800')"))
//                    $database->query("INSERT INTO `ventashotspot`(`Id_Lote`, `FechaVenta`, `Usuario`, `Precio`) VALUES ('7',NOW(),'"."SunsGarden".'_'.$user1."','15')");
//            }   
//        }  
//    }
//    $x1 = $x;
//    $tiempo = "7 Days";
//    $pdf->SetFont('Arial', '', 11);
//    $pdf->SetTextColor(0);
//    $pdf->Line(10,$x-3,20,$x-3);
//    $pdf->Line(270,$x-3,280,$x-3);
//    $pdf->SetXY(40, $x);
//    $pdf->SetFillColor(200);
//    $pdf->Cell(30, 5, 'USER', 0, 0, 'L', TRUE);
//    $pdf->SetX(155);
//    $pdf->Cell(30, 5, 'USER', 0, 0, 'L', TRUE);
//    $x+=5;
//    $pdf->SetXY(40, $x);
//    $pdf->SetFillColor(255);
//    $pdf->Cell(30, 5, $user, 0, 0, 'L', TRUE);
//    $pdf->SetX(155);
//    $pdf->Cell(30, 5, $user1 , 0, 0, 'L', TRUE);
//    $x+=5;
//    $pdf->SetXY(40, $x);
//    $pdf->SetFillColor(200);
//    $pdf->Cell(30, 5, "PASS", 0, 0, 'L', TRUE);
//    $pdf->SetX(155);
//    $pdf->Cell(30, 5, "PASS" , 0, 0, 'L', TRUE);
//    $x+=5;
//    $pdf->SetXY(40, $x);
//    $pdf->SetFillColor(255);
//    $pdf->Cell(30, 5, $pass, 0, 0, 'L', TRUE);
//    $pdf->SetX(155);
//    $pdf->Cell(30, 5, $pass1 , 0, 0, 'L', TRUE);
//    $x+=5;
//    $pdf->SetXY(40, $x);
//    $pdf->SetFillColor(200);
//    $pdf->Cell(30, 5, "ROOM", 0, 0, 'L', TRUE);
//    $pdf->SetX(155);
//    $pdf->Cell(30, 5, "ROOM" , 0, 0, 'L', TRUE);
//    $x += 5;
//    $pdf->SetFontSize(14);
//    $pdf->SetXY(70, $x1);
//    $pdf->Cell(75, 7, "SUN'S GARDEN", 0, 0, 'C');
//    $pdf->SetX(185);
//    $pdf->Cell(75, 7, "SUN'S GARDEN", 0, 0, 'C');
//    $x1 += 7;
//    $pdf->SetXY(95, $x1);
//    $pdf->SetFillColor(200);
//    $pdf->Cell(18, 7, "USER:", 0, 0, 'L', TRUE);
//    $pdf->SetFillColor(255);
//    $pdf->Cell(30, 7, $user, 0, 0, 'L', TRUE);
//    $pdf->SetX(210);
//    $pdf->SetFillColor(200);
//    $pdf->Cell(18, 7, "USER:", 0, 0, 'L', TRUE);
//    $pdf->SetFillColor(255);
//    $pdf->Cell(30, 7, $user1, 0, 0, 'L', TRUE);
//    $x1 += 7;
//    $pdf->SetXY(95, $x1);
//    $pdf->SetFillColor(200);
//    $pdf->Cell(18, 7, "PASS:", 0, 0, 'L', TRUE);
//    $pdf->SetFillColor(255);
//    $pdf->Cell(30, 7, $pass, 0, 0, 'L', TRUE);
//    $pdf->SetX(210);
//    $pdf->SetFillColor(200);
//    $pdf->Cell(18, 7, "PASS:", 0, 0, 'L', TRUE);
//    $pdf->SetFillColor(255);
//    $pdf->Cell(30, 7, $pass1, 0, 0, 'L', TRUE);
//    $x1 += 7;
//    $pdf->SetFontSize(10);
//    $pdf->SetXY(95, $x1);
//    $pdf->Cell(75, 7, "$precio EUR      $tiempo", 0, 0, 'L');
//    $pdf->SetX(210);
//    $pdf->Cell(75, 7, "$precio EUR      $tiempo", 0, 0, 'L');
//    $x += 5;
//    $pdf->Line(10,$x,20,$x);
//    $pdf->Line(270,$x,280,$x);
//    $x+=3;
// }
// $pdf->Output();
function login() {
    /*$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://www.rub3ncillo.es:8091');
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "user=info@servibyte.com&pass=sbyte_15_Mxz");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie-name');  //could be empty, but cause problems on some hosts
//    curl_setopt($ch, CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');  //could be empty, but cause problems on some hosts
    $answer = curl_exec($ch);
    if (curl_error($ch)) {
        echo curl_error($ch);
    }
    $pdf=file_get_contents('http://www.rub3ncillo.es:8091/index.php?module=export&view=invoice&id=4&format=pdf');
    echo $pdf;
    echo $answer;
    //close connection
    curl_close($ch);*/
    /*$url_login = 'http://www.rub3ncillo.es:8091';
    $usuario  = 'info@servibyte.com';//Usuario
    $password = 'sbyte_15_Mxz';//Password
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.133 Safari/534.16');
    curl_setopt($ch, CURLOPT_URL, $url_login);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_HEADER,true);*/
     
    /*
    Le asigno el valor de la variable $usuario a la query usuario
    Le asigno el valor de la variable $password a la query password
    */
    //curl_setopt ($ch, CURLOPT_POSTFIELDS, "user=".$usuario."&pass=".$password);
    //$result = curl_exec($ch);
     
    /*Verificos que los datos ingresados sean correcto
    para esto verifico que en el codigo de repuesta
    sea 302*/
    $ok = file_get_contents('http://rub3ncillo.es:8091/access.php?info=a');
    $pdf=file_get_contents('http://www.rub3ncillo.es:8091/index.php?module=export&view=invoice&id=4&format=pdf');
    //file_put_contents('test.pdf', $pdf);
    file_get_contents('http://rub3ncillo.es:8091/access.php?info=c');
    if ($ok == 'done') {
        echo 'perfect';
    }
    //curl_close($ch); 
}
//echo "hola";
//$mysqli = new mysqli('rub3ncillo.es', 'servibyte', 'sbyte_15_Mxz', 'simpleinvoices', 8092);
//$result = $mysqli->query('SELECT * FROM si_invoices');
//$test = array();
//while ($aux = $result->fetch_assoc()){
//    $test[]=$aux;
//}
//echo "<pre>";
//print_r($test);
//echo "</pre>";
//login();
   
//function pdf_block($cantidad, $tiempo) {
//    require './scripts/fpdf/fpdf.php';
//    $pdf = new FPDF();
//    $x = 23;
//    for ($i = 0; $i < $cantidad; $i++) {
//        if (($i % 5) == 0) {
//            $pdf->Line(105, 0, 105, 278);
//            $pdf->AddPage();
//            $x = 23;
//        }
//        $font = array("title"=>22, 'data'=>10, 'room'=>18);
//        $user = usuario_aleatorio('CVCVCVNN');
//        $pass = usuario_aleatorio('CVCVCVNN');
//        $precio = 1;
//        $tiempo = "10 Hours";
//        $pdf->Image('./images/logo.png',25,$x-18,30,12,'PNG');
//        $pdf->SetXY(20, $x);
//        $pdf->SetFont('Arial','',$font['title']);
//        $pdf->Write(0, 'User:');
//        $pdf->SetX(50);
//        $pdf->SetFont('Arial','',$font['data']);
//        $pdf->Write(0, $user);
//        $pdf->SetX(130);
//        $pdf->Image('./images/logo.png',135,$x-18,30,12,'PNG');
//        $pdf->SetFont('Arial','',$font['title']);
//        $pdf->Write(0, 'User:');
//        $pdf->SetX(165);
//        $pdf->SetFont('Arial','',$font['data']);
//        $pdf->Write(0, $user);
//        $pdf->SetFontSize($font['room']);
//        $pdf->SetXY(170, $x-18);
//        $pdf->Write(0, "$precio ");
//        $pdf->Write(0, chr(128));
//        $pdf->SetXY(170, $x-9);
//        $pdf->Write(0, $tiempo);
//        $pdf->SetFontSize($font['room']);
//        $pdf->SetXY(60, $x-18);
//        $pdf->Write(0, "$precio ");
//        $pdf->Write(0, chr(128));
//        $pdf->SetXY(60, $x-9);
//        $pdf->Write(0, $tiempo);
//        $x = $x +13;
//        $pdf->SetXY(20, $x);
//        $pdf->SetFont('Arial','',$font['title']);
//        $pdf->Write(0, 'Pass:');
//        $pdf->SetX(50);
//        $pdf->SetFont('Arial','',$font['data']);
//        $pdf->Write(0, $pass);
//        $pdf->SetX(130);
//        $pdf->SetFont('Arial','',$font['title']);
//        $pdf->Write(0, 'Pass:');
//        $pdf->SetX(165);
//        $pdf->SetFont('Arial','',$font['data']);
//        $pdf->Write(0, $pass);
//        $x = $x + 9;
//        $pdf->SetXY(20, $x);
//        $pdf->SetFont('Arial','',$font['room']);
//        $pdf->Write(0, 'Room:');
//        $x = $x + 9;
//        $pdf->Line(0, $x, 220, $x);
//        $x = $x +25;
//    }
//    $pdf->Line(105, 0, 105, $x-25);
//    $pdf->Output();
//}
//pdf_block(5, 20);
function pdf_block1($cantidad, $tiempo) {
    $array = array("HUVUXA94","GEFATU87","CURENA19","MUJOYA22","YABUCU22","GIMULE64","FEXONA59","ZURUCU09","YAVUDA23","NOHUYU40","JEVUJE72","JIFEJE32","KAFIGE77","BARUZA02","KUDOFU94","JAWIJA76","HUDIKU13","XUJUXE12","FEXEDU83","XOZAVO80","TUMAWO46","MUPEFO52","XIRUHI31","CEKUDA88","FEZUZI64","HATIWE76","TERUTA18","KIRIRI38","VEVOVI10","RUMIFA18","MUXEWU01","MORADU89","HORADO07","SIGURE71","GIKAPE20","CUCAXU01","ROGOPE52","VOCIFO53","KUMUKO93","QAQIZO66","LULUDU19","SEKUZU23","YOHELA60","FENAYA73","YEHAFI98","RETOJU92","REMALA05","LITERI66","TUSUJO79","ZIREMO41","XUFECE94","VOTIGE09","HOXIKO53","DEQIXA77","ZUCADU59","RELURI79","FONIHA84","JIBEPO95","QAQOCA67","MAPANE06","ZIHERA69","ROFAKA69","GETEMI08","MIZUYU68","NUDABO06","MEWULI86","WIYEZU14","PALIDA36","ZIVUHU67","DIPIZE18","YACUCA36","JOCIVE07","WUTARE87","WEJUSI66","QONOXU31","PEQEVO06","MOTADI89","XEVISI13","COZUNE10","SOKILE08","FUYEKU22","BAVOMU05","RANAJO19","LIMOXI60","JIKOKI93","RODASA53","FANISO40","GUWAMI17","ZIMECE77","CUVOBE12","LOSAKA15","CUSIMU24","KOVICI11","LUYIHA66","TESANU66","WEDEGI75","FIBEBA44","DEWELI01","VOGEPU84","GASIME05");
   require './scripts/fpdf/fpdf.php';
   $pdf = new FPDF();
   $x = 23;
   for ($i = 0; $i < $cantidad; $i++) {
       if (($i % 5) == 0) {
           $pdf->Line(105, 0, 105, 278);
           $pdf->AddPage();
           $x = 23;
       }
       $font = array("title"=>22, 'data'=>16, 'room'=>18);
       $user = $array[$i];
       $pass = usuario_aleatorio('CVCVCVNN');
       $precio = 1;
       $tiempo = "30 Min";
       $pdf->Image('./images/logo.png',40,$x-18,30,12,'PNG');
       $pdf->SetXY(20, $x);
       $pdf->SetFont('Arial','',$font['title']);
       $pdf->Write(0, 'User:');
       $pdf->SetX(50);
       $pdf->SetFont('Arial','',$font['data']);
       $pdf->Write(0, $user);
       $pdf->SetX(130);
       $pdf->Image('./images/logo.png',150,$x-18,30,12,'PNG');
       $pdf->SetFont('Arial','',$font['title']);
       $pdf->Write(0, 'User:');
       $pdf->SetX(165);
       $pdf->SetFont('Arial','',$font['data']);
       $pdf->Write(0, $user);
       $pdf->SetFontSize($font['room']);
       $pdf->SetXY(170, $x-18);
       // $pdf->Write(0, "$precio ");
       // $pdf->Write(0, chr(128));
       $pdf->SetXY(170, $x-9);
       // $pdf->Write(0, $tiempo);
       $pdf->SetFontSize($font['room']);
       $pdf->SetXY(60, $x-18);
       // $pdf->Write(0, "$precio ");
       // $pdf->Write(0, chr(128));
       $pdf->SetXY(60, $x-9);
       // $pdf->Write(0, $tiempo);
       $x = $x +13;
       $pdf->SetXY(20, $x);
       $pdf->SetFont('Arial','',$font['title']);
       $pdf->Write(0, 'Time:');
       $pdf->SetX(50);
       $pdf->SetFont('Arial','',$font['data']);
       $pdf->Write(0, $tiempo);
       $pdf->SetX(130);
       $pdf->SetFont('Arial','',$font['title']);
       $pdf->Write(0, 'Time:');
       $pdf->SetX(165);
       $pdf->SetFont('Arial','',$font['data']);
       $pdf->Write(0, $tiempo);
       $x = $x + 9;
       $pdf->SetXY(20, $x);
       $pdf->SetFont('Arial','',$font['room']);
       // $pdf->Write(0, 'Room:');
       $x = $x + 9;
       $pdf->Line(0, $x, 220, $x);
       $x = $x +25;
   }
   $pdf->Line(105, 0, 105, $x-25);
   $pdf->Output();
}
// pdf_block1(100,1);
echo md5('sbejemplo');
// file_put_contents('prueba', 'pl');