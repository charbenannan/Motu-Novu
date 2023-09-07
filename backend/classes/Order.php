<?php
namespace classes;

use PDO;

class Order {
    private $dbConnection;

    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public function createOrder($customer_id, $product, $quantity, $customer_name) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("INSERT INTO orders (customer_id, product, quantity, customer_name) VALUES (?, ?, ?, ?)");
            $stmt->execute([$customer_id, $product, $quantity, $customer_name]);
            return true;
        } catch (\PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    
    

    public function getOrder($customer_id) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("SELECT * FROM orders WHERE customer_id = ?");
            $stmt->execute([$customer_id]);
    
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $orders;
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return [];
        }
    }


    public function getOrderById($order_id) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->execute([$order_id]);
    
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            return $order;
            
        } catch (\PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }
    
    
    

    public function updateOrder($order_id, $product, $quantity, $customer_name) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("UPDATE orders SET product = ?, quantity = ?, customer_name = ? WHERE id = ?");
            $stmt->execute([$product, $quantity, $customer_name, $order_id]);
    
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
    
    public function deleteOrder($order_id) {
        try {
            $conn = $this->dbConnection->connect();
            $conn->beginTransaction();
    
            
            $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
            $stmt->execute([$order_id]);
    
            
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
            echo "An error occurred while deleting the order: " . $e->getMessage();
            return false;
        }
    }
    
    


    
    
    
    
}

?>