<?php
require_once('backend/autoload.php');
session_start();
use classes\DbConnection;
use classes\Product;

$dbConnection = new DbConnection();
$product = new Product($dbConnection);

$product_id = isset($_GET['id']) ? $_GET['id'] : '';


$productDetails = $product->getProductById($product_id);

if (empty($productDetails)) {
    echo "Product not found.";
    exit;
}
if (!isset($_SESSION['username'])) {
    
    echo "Kindly login/sign up to view this page.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirmDelete = isset($_POST['confirmDelete']) ? $_POST['confirmDelete'] : '';

    if ($confirmDelete === 'yes') {
        $success = $product->deleteProduct($product_id);

        if ($success) {
            header("location: home.php");
            exit;
        }
    } 
    
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Delete Product</title>
</head>
<body>
<div class="del">
    <h1>Delete Product</h1>
    <p>Are you sure you want to delete the product: <strong><?= htmlspecialchars($productDetails['name']) ?></strong>?</p>
    <form method="POST" id="deleteForm">
        <input type="hidden" name="confirmDelete" id="confirmDeleteInput" value="">
        <button type="button" onclick="confirmDeletion('yes')">Yes</button>
        <a href="home.php"><button type="button">No</button></a>
    </form>
</div>
    <script>
        function confirmDeletion(value) {
            document.getElementById('confirmDeleteInput').value = value;
            document.getElementById('deleteForm').submit();
        }
    </script>
</body>
</html>

