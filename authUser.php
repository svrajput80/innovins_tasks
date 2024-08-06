<?php
require 'dbfunctions.php';
require 'sentEmailOTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    switch ($_POST['login']) {
        case 'authuser' :
            $email = $_POST['email'];
            $password = $_POST['password'];
        
            try {
                $db = new DatabaseFunctions();
                $isValidUser =  $db->authUser( $email, $password);          
                if(empty($isValidUser)){
                    unset($_SESSION["username"]);
                    $_SESSION["error"] = '!Error Imvalid Email or Password';
                    header('Location: login.php');
                 }else{
                    unset($_SESSION["error"]);
                    $_SESSION["username"] = $isValidUser[0]['email'];
                    header('Location: addShowUser.php');
                 }
                exit();
            } catch (Exception $e) {
                echo "Failed to login user: " . $e->getMessage();
                header('Location: login.php');
            }
            break; 

        case 'forgetpassword' :
            $email = $_POST['email'];
            $_SESSION["email"] = $email;
            $token = rand(1000, 9999);
            $db = new DatabaseFunctions();
            $isValidUser =  $db->addToken( $email, $token); 
            if($isValidUser == false){
                echo 'Given Email Address is not registor Please Registor it first <a href="/register.php">click here </a> to Registor' ; die;
            }else{
                $isMailSent = sentEmail($email, $token);
                if($isMailSent){
                    $_SESSION["sentemailDone"] = 'OTP is sent to you email Address';
                    header('Location: resetPassword.php');
                }
            }          
           
            break;

        case 'resetpassword':
            $email = $_POST['email'];
            $password = $_POST['password'];
            $token = $_POST['token'];
            $db = new DatabaseFunctions();
            $isValidUser =  $db->resetPassword($email, $password, $token);
            if($isValidUser == false){
                echo 'Given Token is valid' ; die;
            }else{
                unset($_SESSION["email"]);
                header('Location: login.php');
            }
            break;

        }

}

?>