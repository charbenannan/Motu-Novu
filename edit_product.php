<?php
require_once('backend/autoload.php');
session_start();
use classes\DbConnection;
use classes\Product;

$dbConnection = new DbConnection();
$product = new Product($dbConnection);


if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    
    $productDetails = $product->getProductById($product_id);

    if (!$productDetails) {
        echo "Product not found.";
        exit;
    }
} else {
   
    echo "Product ID is missing.";
    exit;
}
if (!isset($_SESSION['username'])) {
    
    echo "Kindly login/sign up to view this page.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['name'];
    $newDescription = $_POST['description'];
    $newPrice = $_POST['price'];

    $success = $product->updateProduct($product_id, $newName, $newDescription, $newPrice);

    if ($success) {
        header("location: home.php"); 
        exit;
    } 
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/edit.css">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($productDetails['name']) ?>"><br><br>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?= htmlspecialchars($productDetails['description']) ?>"><br><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?= htmlspecialchars($productDetails['price']) ?>"><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
