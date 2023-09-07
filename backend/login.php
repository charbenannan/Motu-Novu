<?php
require_once ('autoload.php');
use classes\DbConnection;
use classes\User;
use classes\SessionManager;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $dbConnection = new DbConnection();
    $dbname = $dbConnection->connect();

    $user = new User($dbname);
    $userData = $user->getUserByUsername($username);

    $sessionManager = new SessionManager();
    $sessionManager->startSession();

    if ($userData && $user->verifyPassword($password, $userData['password'])) {
        $sessionManager->login($username);
        $sessionManager->setRole($userData['role_id']);
        header("Location: ../home.php");
    } else {
        echo "Invalid username or password.";
    }
    
}
    
?>