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
}
?>