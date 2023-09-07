<?php

namespace classes;

class User {
    private $dbname;

    public function __construct($dbname) {
        $this->dbname = $dbname;
    }

    public function createUser($username, $password, $role_id) {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->dbname->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashedPassword, $role_id]);
    }

    public function getUserByUsername($username) {

        $stmt = $this->dbname->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function verifyPassword($password, $hashedPassword) {

        return password_verify($password, $hashedPassword);
    }
   
    
}

?>

