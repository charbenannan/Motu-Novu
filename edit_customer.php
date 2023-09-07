<?php
require_once('backend/autoload.php');
session_start();
use classes\DbConnection;
use classes\Customer;

$dbConnection = new DbConnection();
$customer = new Customer($dbConnection);

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$user_id = isset($_GET['id']) ? $_GET['id'] : '';


$currentCustomer = $customer->getCustomerById($user_id);


if (is_array($currentCustomer)) {
    $name = isset($currentCustomer['name']) ? $currentCustomer['name'] : '';
    $phone_number = isset($currentCustomer['phone_number']) ? $currentCustomer['phone_number'] : '';
    $email = isset($currentCustomer['email']) ? $currentCustomer['email'] : '';
} else {
    
    echo "Customer not found.";
    exit;
}
if (!isset($_SESSION['username'])) {
    
    echo "Kindly login/sign up to view this page.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = isset($_POST['name']) ? $_POST['name'] : '';
    $newPhoneNum = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $newEmail = isset($_POST['email']) ? $_POST['email'] : '';

    
    $success = $customer->updateCustomer($user_id, $newName, $newPhoneNum, $newEmail);

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
    <title>Edit Customer</title>
</head>
<body>
    <h1>Edit Customer</h1>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>"><br><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" value="<?= htmlspecialchars($phone_number) ?>"><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
