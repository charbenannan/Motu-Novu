<?php
require_once('backend/autoload.php');
session_start();
use classes\DbConnection;
use classes\Product;
use classes\Customer;
use classes\Order;

$dbConnection = new DbConnection();
$product = new Product($dbConnection);
$customer = new Customer($dbConnection);
$order = new Order($dbConnection);

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$products = !empty($username) ? $product->getProducts($username) : [];
$customers = !empty($username) ? $customer->getCustomer($username) : [];

$customer_id = !empty($username) ? $customer->getCustomerIdByUsername($username) : null;

if ($customer_id !== null) {
    $orders = $order->getOrder($customer_id);
} else {
    $orders = [];
}

$allProducts = $product->getAllProducts();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
    <title>Home</title>
</head>
<body>

<div>
    <?php if (!empty($username)) : ?>
    <div class="options">
        <a href="product.php">Add Products</a>
        <a href="order.php">Create Order</a>
        <a href="customer.php">Add Customer</a>
        <form action="backend/logout.php" method="post">
            <input type="submit" value="Sign Out">
        </form>
</div>
    <?php endif; ?>
</div>

<?php if (empty($username)) : ?>
    <p>You can only see the products list since you're not authorized/signed in</p>
    <br>
    <h1>Product List</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1; 
            foreach ($allProducts as $product) :
            ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td>$<?= htmlspecialchars($product['price']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
    

<?php if (!empty($username)) : ?>
    <h1>Product List</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1; 
            foreach ($products as $product) :
            ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td>$<?= htmlspecialchars($product['price']) ?></td>

                    <?php if ($_SESSION['role'] == 2) : ?>
                        
                        <td><a href="edit_product.php?id=<?= $product['id'] ?>">Edit</a></td>
                        <td><a href="delete_product.php?id=<?= $product['id'] ?>">Delete</a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
    

<?php if (!empty($username)) : ?>
    <h1>Customer List</h1>

    <table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $counter = 1; 
        foreach ($customers as $customer) :
        ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td><?= htmlspecialchars($customer['name']) ?></td>
                <td><?= htmlspecialchars($customer['email']) ?></td>
                <td><?= htmlspecialchars($customer['phone_number']) ?></td>
                
                <?php if ($_SESSION['role'] == 2) : ?>
                    <td><a href="edit_customer.php?id=<?= $customer['id'] ?>">Edit</a></td>
                    <td><a href="delete_customer.php?id=<?= $customer['id'] ?>">Delete</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
<?php endif; ?>
    

<?php if (!empty($username)) : ?>
    <h1>Order List</h1>

    <table>
    <thead>
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Date & Time</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $counter = 1; 
        foreach ($orders as $order) :
        ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                <td><?= htmlspecialchars($order['product']) ?></td>
                <td><?= htmlspecialchars($order['quantity']) ?></td>
                <td><?= htmlspecialchars($order['order_date']) ?></td>

                <?php if ($_SESSION['role'] == 2) : ?>
                    <td><a href="edit_order.php?id=<?= $order['id'] ?>">Edit</a></td>
                    <td><a href="delete_order.php?id=<?= $order['id'] ?>">Delete</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
<?php endif; ?>

</body>
</html>
