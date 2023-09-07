<?php
require_once ('autoload.php');
use classes\DbConnection;
use classes\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role_id = $_POST['account_type'];

    $dbConnection = new DbConnection();
    $dbname = $dbConnection->connect();

    $user = new User($dbname);
    $existingUser = $user->getUserByUsername($username);

    if ($existingUser) {
        echo "Username already exists. Please choose another.";
    } else {
        $user->createUser($username, $password, $role_id);
        header("Location: ../index.html");
        
    }
}

?>