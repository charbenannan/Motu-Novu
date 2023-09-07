<?php
require_once('backend/autoload.php');
session_start();
use classes\DbConnection;
use classes\Customer;

$dbConnection = new DbConnection();
$customer = new Customer($dbConnection);

$customer_id = isset($_GET['id']) ? $_GET['id'] : '';


$customerDetails = $customer->getCustomerById($customer_id);

if (empty($customerDetails)) {

    echo "Customer not found.";
    exit;
}
if (!isset($_SESSION['username'])) {
    
    echo "Kindly login/sign up to view this page.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirmDelete = isset($_POST['confirmDelete']) ? $_POST['confirmDelete'] : '';

    if ($confirmDelete === 'yes') {
        $success = $customer->deleteCustomer($customer_id);

        if ($success) {
            header("location: home.php");
            exit;
        }else{
            echo "Couldn't delete customer";
        }
    } 
    
} 
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Delete Customer</title>
</head>
<body>
    <h1>Delete Customer</h1>l
<div class="del">
    <p>Are you sure you want to delete the customer: <strong><?= htmlspecialchars($customerDetails['name']) ?></strong>? <strong><br>Note:</strong> This will also delete every order created by <?= htmlspecialchars($customerDetails['name']) ?> </p>
    
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

