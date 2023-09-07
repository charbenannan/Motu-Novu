<?php

namespace classes;

use PDO; 

class Product {
    private $dbConnection;

    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public function addProduct($username, $name, $description, $price) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("INSERT INTO products (username, name, description, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $name, $description, $price]);
            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function getProducts($username) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("SELECT * FROM products WHERE username = ?");
            $stmt->execute([$username]);
            

    
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $products;
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return [];
        }
    }
    
    public function getAllProducts() {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("SELECT * FROM products");
            $stmt->execute();
            

    
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $products;
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return [];
        }
    }

    
    
    public function getProductById($product_id) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$product_id]);

            
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            return $product;
        } catch (\PDOException $e) {
            
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }

    public function updateProduct($product_id, $name, $description, $price) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
            $stmt->execute([$name, $description, $price, $product_id]);

            
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

    public function getAllProductName(){
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->query("SELECT name FROM products");
           
            $productItem = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $names = array_column($productItem, 'name');
    
            return $names;
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return [];
        }
    }
    public function deleteProduct($product_id) {
        try {
            $conn = $this->dbConnection->connect();
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
    
            
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
    
    
}

?>
