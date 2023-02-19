<?php
require_once "connection/connection.php";
require_once "response.class.php";


class users extends connection {

    private $table = "users";
    private $table2 ="datauser";
    private $userid = "";
    private $name = "";
    private $lastname = "";
    private $email = "";
    private $password = "";
    private $role = "";
    private $token = "";

    public function listUsers($page = 1){
        $start  = 0 ;
        $count = 100;
        if($page > 1){
            $start = ($count * ($count - 1)) +1 ;
            $count = $count * $page;
        }
        $query = "SELECT * FROM " . $this->table2 . "";
        $data = parent::selectData($query);
        return ($data);
    }

    public function getUser($userid){
        $query = "SELECT * FROM " . $this->table2 . " WHERE userid = '$userid'";
        return parent::selectData($query);

    }

    public function post($json){
        $_response = new response;
        $data = json_decode($json,true);

        if(!isset($data['token'])){
                return $_response->error_401();
        }else{
            $this->token = $data['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){
                if(!isset($data['name']) || !isset($data['last_name']) || !isset($data['email'])){
                    return $_response->error_400();
                }else{
                    $this->name = $data['name'];
                    $this->last_name = $data['last_name'];
                    $this->email = $data['email'];
                    if(isset($data['password'])) { $this->password = $data['password']; }
                    $resp = $this->insertUser();
                    if($resp){
                        $response = $_response->response;
                        $response["result"] = array(
                            "id" => $resp
                        );
                        return $response;
                    }else{
                        return $_response->error_500();
                    }
                }

            }else{
                return $_response->error_401("El Token que envio es invalido o ha caducado");
            }
        }


       

    }

    private function insertUser(){
        $query = "INSERT INTO " . $this->table . " (name,last_name,email,password,role)
        values
        ('" . $this->name . "','" . $this->lastname . "','" . $this->email ."','" . $this->password . "','"  . $this->role . "')"; 
        $resp = parent::nonQueryId($query);
        if($resp){
             return $resp;
        }else{
            return 0;
        }
    }
    
    public function put($json){
        $_response = new response;
        $data = json_decode($json,true);

        if(!isset($data['token'])){
            return $_response->error_401();
        }else{
            $this->token = $data['token'];
            $arrayToken =   $this->foundToken();
            if($arrayToken){
                if(!isset($data['id'])){
                    return $_response->error_400();
                }else{
                    $this->userid = $data['id'];
                    if(isset($data['name'])) { $this->name = $data['name']; }
                    if(isset($data['last_name'])) { $this->lastname = $data['last_name']; }
                    if(isset($data['email'])) { $this->email = $data['email']; }
                    if(isset($data['password'])) { $this->password = $data['password']; }
                    if(isset($data['role'])) { $this->role = $data['role']; }
    
                    $resp = $this->updateUser();
                    if($resp){
                        $response = $_response->response;
                        $response["result"] = array(
                            "id" => $this->userid
                        );
                        return $response;
                    }else{
                        return $_response->error_500();
                    }
                }

            }else{
                return $_response->error_401("El Token que envió es invalido o ha caducado");
            }
        }


    }


    private function updateUser(){
        $query = "UPDATE " . $this->table . " SET name ='" . $this->name . "',last_name = '" . $this->lastname . "', email = '" . $this->email . "', password = '" . $this->password . "' WHERE id = '" . $this->userid . "'"; 
        $resp = parent::nonQuery($query);
        if($resp >= 1){
             return $resp;
        }else{
            return 0;
        }
    }


    public function delete($json){
        $_response = new response;
        $data = json_decode($json,true);

        if(!isset($data['token'])){
            return $_response->error_401();
        }else{
            $this->token = $data['token'];
            $arrayToken =   $this->foundToken();
            if($arrayToken){

                if(!isset($data['id'])){
                    return $_response->error_400();
                }else{
                    $this->userid = $data['id'];
                    $resp = $this->deleteUser();
                    if($resp){
                        $response = $_response->response;
                        $response["result"] = array(
                            "id" => $this->userid
                        );
                        return $response;
                    }else{
                        return $_response->error_500();
                    }
                }

            }else{
                return $_response->error_401("El Token que envio es invalido o ha caducado");
            }
        }



     
    }


    private function deleteUser(){
        $query = "DELETE FROM " . $this->table . " WHERE id= '" . $this->userid . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            return 0;
        }
    }


    private function foundToken(){
        $query = "SELECT  id_token,user_id,token,status,date from users_token WHERE token = '" . $this->token . "' AND status = 'active'";
        $resp = parent::selectData($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }


    private function updateToken($tokenid){
        $date = date("Y-m-d H:i");
        $query = "UPDATE users_token SET date = '$date' WHERE id_token = '$tokenid' ";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }



}





?>