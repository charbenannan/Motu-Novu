<?php
require_once('backend/autoload.php');
session_start();
use classes\DbConnection;
use classes\Order;
use classes\Customer;
use classes\Product;

$dbConnection = new DbConnection();
$order = new Order($dbConnection);
$customer = new Customer($dbConnection);
$product = new Product($dbConnection);

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$order_id = isset($_GET['id']) ? $_GET['id'] : '';



$selectedProduct = isset($_POST['new_product']) ? $_POST['new_product'] : '';
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
$customer_name = isset($_POST['customer']) ? $_POST['customer'] : '';
if (!isset($_SESSION['username'])) {
    
    echo "Kindly login/sign up to view this page.";
    exit;
}

if (!empty($selectedProduct) && !empty($quantity) && !empty($customer_name)) {
    $success = $order->updateOrder($order_id, $selectedProduct, $quantity, $customer_name);

    if ($success) {
        header("location: home.php");
        exit;
    }
}





$productNamesList = $product->getProducts($username);


$customerNamesList = $customer->getCustomer($username);


$currentOrder = $order->getOrderById($order_id);


if (is_array($currentOrder)) {
    $selectedProduct = isset($currentOrder['product']) ? $currentOrder['product'] : '';
    $quantity = isset($currentOrder['quantity']) ? $currentOrder['quantity'] : '';
    $customer_name = isset($currentOrder['customer_name']) ? $currentOrder['customer_name'] : '';
} else {
   
    echo "Order not found.";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/edit.css">
    <title>Edit Order</title>
</head>
<body>

<h1>Edit Order</h1>

<form method="post">
    <label for="new_product"> Product:</label>
    <select id="new_product" name="new_product">
        <?php
    
        foreach ($productNamesList as $productItem) : ?>
            <option value="<?= htmlspecialchars($productItem['name']) ?>" <?= ($selectedProduct == $productItem['name']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($productItem['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label for="quantity">Quantity:</label>
    <input type="text" id="quantity" name="quantity" value="<?= htmlspecialchars($quantity) ?>"><br>

    <label for="customer">Customer Name:</label>
    <select id="customer" name="customer">
        <?php foreach ($customerNamesList as $customerItem) : ?>
            <option value="<?= htmlspecialchars($customerItem['name']) ?>" <?= ($customer_name == $customerItem['name']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($customerItem['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" value="Update Order">
</form>

</body>
</html>
