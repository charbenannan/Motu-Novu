<?php
require_once('backend/autoload.php');
session_start();
use classes\DbConnection;
use classes\Order;

$dbConnection = new DbConnection();
$order = new Order($dbConnection);

$order_id = isset($_GET['id']) ? $_GET['id'] : '';


$orderDetails = $order->getOrderById($order_id);

if (empty($orderDetails)) {

    echo "Order not found.";
    exit;
}
if (!isset($_SESSION['username'])) {
    echo "Kindly login/sign up to view this page.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirmDelete = isset($_POST['confirmDelete']) ? $_POST['confirmDelete'] : '';

    if ($confirmDelete === 'yes') {
        $success = $order->deleteOrder($order_id);

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
    <title>Delete Order</title>
    
</head>
<body>
    <h1>Delete Order</h1>
  <div class="del">
    <p>Are you sure you want to delete <strong><?= htmlspecialchars($orderDetails['customer_name'])?>'s</strong> Order?</p>
    <p>Product:<strong><?= htmlspecialchars($orderDetails['product']) ?></strong></p>
    <p>Quantity:<strong><?= htmlspecialchars($orderDetails['quantity']) ?></strong></p>
 </div>
    <form method="POST" id="deleteForm">
        <input type="hidden" name="confirmDelete" id="confirmDeleteInput" value="">
        <button type="button" onclick="confirmDeletion('yes')">Yes</button>
        <a href="home.php"><button type="button">No</button></a>
    </form>

    <script>
        function confirmDeletion(value) {
            document.getElementById('confirmDeleteInput').value = value;
            document.getElementById('deleteForm').submit();
        }
    </script>
</body>
</html>

