<?php

class connection{
    
    //Creando atributos privados
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $connection;

    function __construct(){
        $listdata = $this->dataConnection();
        foreach ($listdata as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        $this->connection = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);
        if($this->connection->connect_errno){
            echo "Ocurrió un fallo al establecer la conexión con la base de datos";
            die();
        }
    }

    private function dataConnection(){
        
        $dir = dirname(__FILE__);
        $jsondata = file_get_contents($dir . "/" . "config");
        return json_decode($jsondata, true);

    }

    //Funcion para UTF8-CODE
    private function convertUTF8($array){
        array_walk_recursive($array,function(&$item,$key,){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    //Metodo Obtener Datos
    public function selectData($query){
        $results = $this->connection->query($query);
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key;
        }
        return $this->convertUTF8($resultArray);
    }


    public function nonQuery($sqlstr){
        $results = $this->connection->query($sqlstr);
        return $this->connection->affected_rows;
    }

    
    public function nonQueryId($sqlstr){
        $results = $this->connection->query($sqlstr);
        $rows = $this->connection->affected_rows;
         if($rows >= 1){
            return $this->connection->insert_id;
         }else{
             return 0;
         }
    }

    protected function encrypt($string){
        return md5($string);
    }







}

?>