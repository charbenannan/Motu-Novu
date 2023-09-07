<?php
namespace classes;

class SessionManager {
    public function startSession() {
        session_start();
    }

    public function setRole($role) {
        $_SESSION['role'] = $role;
    }

    public function getRole() {
        return isset($_SESSION['role']) ? $_SESSION['role'] : null;
    }

    public function isLoggedIn() {
        return isset($_SESSION['username']);
    }

    public function login($username) {
        $_SESSION['username'] = $username;
    }

    public function logout() {
        session_unset();
        session_destroy();
    }
}

?>