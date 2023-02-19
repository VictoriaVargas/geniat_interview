<?php
require_once 'connection/connection.php';

class token extends connection{

    function updateTokens($date){
        $query = "UPDATE users_token set status = 'inactive' WHERE date < '$date'";
        $check = parent::nonQuery($query);
        if($check){
            $this->writeIn($check);
            return $check;
        }else{
            return 0;
        }
    }

    function createTxt($dir){
           $file = fopen($dir, 'w') or die ("error al crear el archivo de registros");
           $text = "------------------------------------ Registros del CRON JOB ------------------------------------ \n";
           fwrite($file,$text) or die ("no pudimos escribir el registro");
           fclose($file);
    }

    function writeIn($records){
        $dir = "../cron/records/recordss.txt";
        if(!file_exists($dir)){
            $this->createTxt($dir);
        }
        /* crear una entrada nueva */
        $this->writeTxt($dir, $records);
    }

    function writeTxt($dir, $records){
        $date = date("Y-m-d H:i");
        $file = fopen($dir, 'a') or die ("error al abrir el archivo de registros");
        $text = "Se modificaron $records registro(s) el dia [$date] \n";
        fwrite($file,$text) or die ("no pudimos escribir el registro");
        fclose($file);
    }
}

?>