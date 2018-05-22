<?php
// global $database;
// global $radius;

$apidbp= new mysqli('localhost','platformuser','rfC79w?3', 'plataforma');
$apidbr= new mysqli('localhost', 'radiususer', 'Pwp+*f2b', 'radius');


exec('mysqldump --user=platformuser --password=rfC79w?3 --host=localhost plataforma > plataforma.sql');


// $tables = array();

// $result = $apidbp->query("SHOW TABLES");


// while($aux = $result->fetch_assoc()){
//     $tables[] = $aux['Tables_in_plataforma'];
// }

// $backupSQL="";

// foreach($tables as $table){
    
//     //CREATE TABLES
//     $result2 = $apidbp->query("SHOW CREATE TABLE $table");
    
//     $aux2 = $result2->fetch_assoc();
    
//     $backupSQL.="\n\n".utf8_encode($aux2['Create Table']).";\n\n";
    
    
    
    
//     //OBTENCION DE DATOS
//     $result2 = $apidbp->query("SELECT * FROM $table");
    
//     $aux2 = $result2->fetch_assoc();
    
    
//     $columns = $result2->num_rows;
    
//     for($i=0;$i<$columns;$i++){
        
//         // while($aux2 = $result2->fetch_assoc()){
//         //     $prueba[] = $aux2;
            
//         //     $backupSQL.="INSERT INTO $table VALUES(";
            
//         //     for($j=0;$j<$columns;$j++){
                
//         // //         // $aux2[$j]=$aux2[$j];
                
//         //         if(isset($aux2[$j])){
                    
//         //             $backupSQL.='"'.$aux2[$j].'"';
                    
//         //         }else{
                    
//         //             $backupSQL.='""';
                    
//         //         }
                
//         //         if($j<($columns-1)){
//         //             $backupSQL.=',';
//         //         }
                
    
                
//         //     }
            
//         //     $backupSQL.=");\n";
                
//         // }
        
        
//     }
    
    
//     $backupSQL.="\n";
    
    
    
// }

// file_put_contents('ZZZCC', print_r($backupSQL, true));