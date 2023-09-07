<?php
session_start();
if (!isset($_SESSION['username'])) {
    
    echo "Kindly login/sign up to view this page.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/form.css">
    <title>Create Order</title>
</head>
<body>
    <h1>Create Order</h1>

    <form action="backend/process_order.php" method="POST">
        <label for="product">Product</label>
        <select id="product" name="product">
            <option value="">Select a Product</option>
            <?php
            require_once('backend/autoload.php');
            session_start();
            use classes\DbConnection;
            use classes\Product;

            $dbConnection = new DbConnection();
            $product = new Product($dbConnection);

            $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

            $products = $product->getProducts($username);

            foreach ($products as $product) {
                echo '<option value="' . $product['name'] . '">' . htmlspecialchars($product['name']) . '</option>';
            }
            ?>
        </select>

        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity">

        <label for="customer">Customer</label>
        <select id="customer" name="customer">
    <option value="">Select a customer</option>
    
<?php
    require_once('backend/autoload.php');
    session_start();
    use classes\DbConnection as MyDbConnection;
    use classes\Customer;
    use classes\User;

    $dbConn = new MyDbConnection();
    $customer = new Customer($dbConn);
   
    
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    var_dump($username);

            $customers = $customer->getCustomer($username);

            foreach ($customers as $customer) {
                echo '<option value="' . $customer['name'] . '">' . htmlspecialchars($customer['name']) . '</option>';
            }
    ?>
</select>
        <input type="submit" value="Create Order" id="submitButton">
    </form>

    <script>
        document.getElementById("submitButton").addEventListener("click", function(event) {
            var productField = document.getElementById("product");
            var quantityField = document.getElementById("quantity");
            var customerField = document.getElementById("customer");;

            if (productField.value.trim() === "") {
                alert("Please select a Product to order. You can only order from what is in store");
                event.preventDefault();
                return;
            }

            if (quantityField.value.trim() === "") {
                alert("Please fill in the Quantity field.");
                event.preventDefault();
                return;
            }

            if (customerField.options[customerField.selectedIndex].value.trim() === "") {
    alert("Please select/create the Customer field. Orders are associated with Customers");
    event.preventDefault();
    return;
}

        });
    </script>
</body>
</html>
