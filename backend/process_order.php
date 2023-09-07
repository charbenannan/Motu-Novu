<?php
require_once('autoload.php');
session_start();

use classes\DbConnection;
use classes\Order;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product'];
    $quantity = $_POST['quantity'];

   
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $customer_name = $_POST['customer'];
    $dbConnection = new DbConnection();
    $order = new Order($dbConnection);

   
    $pdo = $dbConnection->connect();
    $dbname = getDbNameFromPDO($pdo);

    
    $customer_id = getCustomerIdByName($pdo, $customer_name);

    if ($customer_id !== null) {
        $success = $order->createOrder($customer_id, $product_id, $quantity, $customer_name);
        var_dump($success);

        if ($success) {
            echo "Order created successfully!";
            header("location:../home.php");
        } else {
            echo "Failed to create the order.";
        }
    } else {
        echo "Selected customer name not found in the database.";
    }
} else {
    echo "User not logged in or missing username in session.";
}

}

function getDbNameFromPDO($pdo) {
    try {
        $stmt = $pdo->query("SELECT DATABASE()");
        $dbname = $stmt->fetchColumn();
        return $dbname;
    } catch (\PDOException $e) {
        return null;
    }
}

function getCustomerIdByName($pdo, $customer_name) {
    try {
        $stmt = $pdo->prepare("SELECT id FROM customers WHERE name = ?");
        $stmt->execute([$customer_name]);
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
?>
