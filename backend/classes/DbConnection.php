<?php
namespace classes;

use PDO;

class DbConnection {
    private $server = 'localhost';
    private $dbname = 'motu_novu';
    private $username = 'root';
    private $password = '';

    public function connect() {
        try {
            $conn = new PDO('mysql:host=' . $this->server . '; dbname=' . $this->dbname, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
}

?>
