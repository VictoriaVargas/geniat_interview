<?php
require_once 'connection/connection.php';
require_once 'response.class.php';


class auth extends connection{

    public function login($json){
      
        $_response = new response;
        $data = json_decode($json,true);
        if(!isset($data['user']) || !isset($data["password"])){
            //error con los campos
            return $_response->error_400();
        }else{
            //Datos Correctos
            $user = $data['user'];
            $password = $data['password'];
            /* $password = parent::encrypt($password); */
            $data = $this->getDataUser($user);
            if($data){
                //verificar si la contraseña es igual
                    if($password == $data[0]['userpassword']){
                            if($data[0]['loginpermission'] == "1"){
                                //crear el token
                                $check  = $this->token($data[0]['userid']);
                                if($check){
                                        $result = $_response->response;
                                        $result["result"] = array(
                                            "token" => $check
                                        );
                                        return $result;
                                }else{
                                        //error al guardar
                                        return $_response->error_500("Error interno. No se ha podido guardar el registro");
                                }
                            }else{
                                return $_response->error_200("El usuario no cuenta con permiso para ingresar");
                            }
                    }else{
                        //la contraseña no es igual
                        return $_response->error_200("El password es invalido");
                    }
            }else{
                //no existe el usuario
                return $_response->error_200("El usuario $user  no existe ");
            }
        }
    }



    private function getDataUser($email){
        $query = "SELECT userid, username, userlastname, useremail, userpassword, useridrole, rolename, loginpermission, selectpermission, createpermission, updatepermission, deletepermission FROM datauser WHERE useremail = '$email'";
        $data = parent::selectData($query);
        if(isset($data[0]["userid"])){
            return $data;
        }else{
            return 0;
        }
    }


    private function token($userid){
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
        $date = date("Y-m-d H:i");
        $status = "active";
        $query = "INSERT INTO users_token(user_id,token,status,date)VALUES('$userid','$token','$status','$date')";
        $check = parent::nonQuery($query);
        if($check){
            return $token;
        }else{
            return 0;
        }
    }


}




?>