<?php
namespace classes;

use PDO;

class Customer {
    private $dbConnection;

    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public function createCustomer($name, $email, $phone_number, $username) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("INSERT INTO customers (name, email, phone_number, username) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone_number, $username]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getCustomer($username) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ?");
            $stmt->execute([$username]);

            $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $customers;
           
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return [];
        }
    }
    public function getCustomerIdByUsername($username) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("SELECT id FROM customers WHERE username = ?");
            $stmt->execute([$username]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result && isset($result['id'])) {
                return $result['id'];
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            return null;
        }
    }

    
public function getAllCustomerNames() {
    try {
        $conn = $this->dbConnection->connect();
        $stmt = $conn->query("SELECT name FROM customers");
        
        
        $customerNames = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        $names = array_column($customerNames, 'name');

        return $names;
    } catch (\PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        return [];
    }
}

public function getCustomerById($customer_id) {
    try {
        $conn = $this->dbConnection->connect();
        $stmt = $conn->prepare("SELECT name, email, phone_number FROM customers WHERE id = ?");
        $stmt->execute([$customer_id]);

        
        if ($stmt->rowCount() > 0) {
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);
            return $customer;
        } else {
            return null; 
        }
    } catch (\PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return null; 
    }
}



public function updateCustomer($customer_id, $name, $email, $phone_number) {
    try {
        $conn = $this->dbConnection->connect();
        $stmt = $conn->prepare("UPDATE customers SET Name = ?, email = ?, phone_number = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone_number, $customer_id]);

        
        if ($stmt->rowCount() > 0) {
            return true; 
        } else {
            return false; 
        }
    } catch (\PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}
public function deleteCustomer($customer_id) {
    try {
        $conn = $this->dbConnection->connect();
        $conn->beginTransaction();

        
        $stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
        $stmt->execute([$customer_id]);

      
        if ($stmt->rowCount() > 0) {
            $conn->commit(); 
            return true; 
        } else {
            $conn->rollBack(); 
            return false; 
        }
    } catch (\PDOException $e) {
        $conn->rollBack(); 
        error_log("Database Error: " . $e->getMessage());
        echo "An error occurred while deleting the customer: " . $e->getMessage();
        return false;
    }
}


}
?>