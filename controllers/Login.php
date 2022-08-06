<?php
session_start();
error_reporting( E_ALL );
ini_set( "display_errors", 1 );

class Login{

    protected $email;

    public function checkAdminAuth($email, $password)
    {
        $checkDetails = $this->isValidDetails($email, $password);

        if($checkDetails !== true){
            echo json_encode(["status" => false, "type" => "credentials_error" , "error" => $checkDetails]); exit;
        }else{
            $userAuth = LoginModel::checkAuthentication($email, $password);
            $userAuthJson = json_decode($userAuth, true);

            if($userAuthJson['type'] == "no_user_found" || $userAuthJson['type'] == "password_not_matched"){
                echo $userAuth; exit;
            }
            if($userAuthJson['type'] == 'password_matched'){
                $_SESSION["name"] = $userAuthJson['name'];
                $_SESSION["email"] = $userAuthJson['email'];
                $_SESSION["id"] = $userAuthJson['userId'];
                echo $userAuth; exit;
            }
        }
    }

    public function isValidDetails($email, $password)
    {
        $result = [];
        $email = trim($email);
        $password = trim($password);
        $emailPattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix';

        switch ($email) {
            case "":
                $result['username_error'] = "Please Enter Email";
                break;
            case (strpos($email, " ") > 0):
                $result['username_error'] = "Not a valid email format";
                break;
            case ((strpos($email, "'") !== false) || (strpos($email, "=") !== false)):
                $result['username_error'] = "Not a valid email format";
                break;
            case ((strpos($email, "<") !== false) || (strpos($email, ">") !== false)):
                $result['username_error'] = "Not a valid email format";
                break;
            default:
                if(preg_match($emailPattern, $email)){
                    $result['username_error'] = "";
                    $this->email = $email;
                }else{
                    $result['username_error'] = "Not a valid email format";
                }
        }

        switch ($password) {
            case "":
                $result['pass_error'] = "Please Enter Password";
                break;
            case (strpos($password, " ") > 0):
                $result['pass_error'] = "Password should not contain spaces";
                break;
            case ((strpos($password, "'") !== false) || (strpos($password, "=") !== false)):
                $result['pass_error'] = "Illegal Characters";
                break;
            case ((strpos($password, "<") !== false) || (strpos($password, ">") !== false)):
                $result['pass_error'] = "Illegal Characters";
                break;
            case (strlen($password) < 6):
                $result['pass_error'] = "Password should be atleast 6 characters long";
                break;
            default:
                $result['pass_error'] = "";
                $this->password = $password;
        }

        if($result['username_error'] == '' && $result['pass_error'] == ''){
            return true;
        }

        return $result;
    }
}



spl_autoload_register(function ($className) {
    require_once("./models/" . $className . ".php");
});

$login = new Login();

if(isset($_POST['user_email']) && isset($_POST['userpass'])){
    $login->checkAdminAuth($_POST['user_email'], $_POST['userpass']);
    // print_r($_POST); die(" ppp ");
}