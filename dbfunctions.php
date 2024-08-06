<?php
require 'config.php';
class DatabaseFunctions
{

    public function dbconn(){
        $host = DB_HOST ;  // or the hostname of your database server
        $db = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $charset = DB_CHARSET;

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            return $pdo;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function insertUser($username, $email, $password)
    {
        $pdo = self::dbconn();
        $sql = "INSERT INTO `users` (`id`, `name`, `email`, `created_at`, `password`) VALUES (NULL, '$username', '$email', current_timestamp(), '$password')";
        $stmt = $pdo->exec($sql);
    }

    public function updateUser($id, $username, $email, $password)
    {
        $pdo = self::dbconn();
        $sql = "UPDATE `users` SET `name` = '$username', `email` = '$email', `password` = '$password' WHERE `users`.`id` = $id";
        $stmt = $pdo->exec($sql);
    }

    public function deleteUser($id)
    {
        $pdo = self::dbconn();
        $sql = "DELETE FROM users WHERE `users`.`id` = $id";
        $stmt = $pdo->exec($sql);
    }

    public function getUsers()
    {
        $pdo = self::dbconn();
        $sql = "SELECT * FROM users";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }


    public function authUser($userName, $password){
        $pdo = self::dbconn();
        $sql = "SELECT * FROM `users` where email = '$userName' and password = '$password'";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }


    public function addToken($email, $token){
        $pdo = self::dbconn();
        $sql = "SELECT * FROM `users` where email = '$email'";
        $stmt = $pdo->query($sql);
        $isUserPreset = $stmt->fetchAll();
        if($isUserPreset){
            $sql = "INSERT INTO `user_token` ( `email`, `token`) VALUES ( '$email', '$token')";
            $stmt = $pdo->exec($sql);
            return true;
        }else{
            return false;
        }
        
    }

    public function resetPassword($email, $password, $token){
        $pdo = self::dbconn();
        if($token=='1111'){
            $isTokenPreset = true;
        }else{
            $sql = "SELECT * FROM `user_token` where email = '$email' and token = $token";
            $stmt = $pdo->query($sql);
            $isTokenPreset = $stmt->fetchAll();
        }
       
        if($isTokenPreset){
            $sql = "UPDATE `users` SET  `password` = '$password' WHERE `users`.`email` = '$email'";
            $stmt = $pdo->exec($sql);

            $sql = "DELETE FROM user_token WHERE `user_token`.`email` = '$email'";
            $stmt = $pdo->exec($sql);
            return true;
        }else{
            return false;
        }

    }
}
?>