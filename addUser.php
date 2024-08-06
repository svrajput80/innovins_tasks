<?php
require 'dbfunctions.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    switch ($_POST['update']) {
        case 1 : // Update User Details 
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
        
            try {
                $db = new DatabaseFunctions();
                $db->updateUser($id, $username, $email, $password);
                echo "Update User successfully!";
                header('Location: addShowUser.php');
            } catch (Exception $e) {
                echo "Failed to add user: " . $e->getMessage();
                header('Location: addShowUser.php');
            }
            break;

        case 2 : // Delete User Details 
            $id = $_POST['id'];
        
            try {
                $db = new DatabaseFunctions();
                $db->deleteUser($id);
                echo "Delete user successfully!";
                header('Location: addShowUser.php');
            } catch (Exception $e) {
                echo "Failed to add user: " . $e->getMessage();
                header('Location: addShowUser.php');
            }
            break;

        default: // Add New User Details 
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $gotLogIn = $_POST['gotLogIn'];
            try {
                $db = new DatabaseFunctions();
                $db->insertUser($username, $email, $password);
                echo "User added successfully!";
                $gotLogIn == 'login' ? header('Location: login.php') : header('Location: addShowUser.php');
            } catch (Exception $e) {
                echo "Failed to add user: " . $e->getMessage();
                header('Location: addShowUser.php');
            }
            break;
    }    
}

function getUsers(){
    $db = new DatabaseFunctions();
    return $db->getUsers();
}

?>