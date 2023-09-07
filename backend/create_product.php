<?php
require_once('autoload.php');
use classes\DbConnection;
use classes\Product;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    $dbConnection = new DbConnection();
    $product = new Product($dbConnection);

    if ($product->addProduct($username, $name, $description, $price)) {
        echo "Product added successfully!";
    } else {
        echo "Failed to add the product.";
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


function getUserIdByUsername($dbConnection, $dbname, $username) {
    try {

        $pdo = $dbConnection->connect($dbname);
        $stmt = $pdo->prepare("SELECT id FROM customers WHERE LOWER(TRIM(username)) = LOWER(?)");
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
?>
