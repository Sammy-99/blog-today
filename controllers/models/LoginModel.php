<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

class LoginModel{

    protected static $dbc;

    public function __construct(){
        self::$dbc = DB::getDbConn();
    }

    public static function checkAuthentication($email, $password)
    {
        $email = Self::$dbc->real_escape_string($email);
        $password = Self::$dbc->real_escape_string($password);
        $selectQuery = Self::$dbc->query("SELECT * FROM users WHERE email='$email' AND status=1");
        if($selectQuery->num_rows > 0){
            $row = $selectQuery->fetch_assoc();

            if(password_verify($password, $row['password'])){ 
                return json_encode([
                    "type" => "password_matched",
                    "message" => "Credentials matched",
                    "name" => $row['name'],
                    "email" => $row['email'],
                    "userId" => $row['id'],
                    "status" => true
                ]);
            }

            return json_encode(["type" => "password_not_matched", "message" => "Credentials not matched", "status" => false]);
        }else{
            return json_encode(["type" => "no_user_found", "message" => "Credentials not matched", "status" => false]);
        }

    }

    public static function insertAdmin()
    {
        // $date = date('Y-m-d H:i:s');
        // $password = password_hash("Admin@123", PASSWORD_DEFAULT);
        // $insert = " INSERT INTO users (email, password, name, role, status, Created_at)
        //             VALUES ('admin123@gmail.com', '$password', 'Admin', 'admin', 1, '$date')";
        // $query = Self::$dbc->query($insert);
    }
}

$loginModel = new LoginModel();

spl_autoload_register(function ($className) {
    require_once("./" . $className . ".php");
});