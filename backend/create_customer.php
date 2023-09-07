    <?php
    require_once('autoload.php');
    session_start();

    use classes\DbConnection;
    use classes\Customer;

    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_num = $_POST['phone_num'];

        
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

        $dbConnection = new DbConnection();
        $customer = new Customer($dbConnection); 

        $success = $customer->createCustomer($name, $email, $phone_num, $username); 

        if ($success) {
            header("location:../home.php");
        } else {
            echo "This customer already exists.";
        }
    }
    ?>