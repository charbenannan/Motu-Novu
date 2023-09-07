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
    <title>Add Customer</title>
</head>
<body>
    <h1>Create Customer</h1>
    <form action="backend/create_customer.php" method="POST">
        <label for="name">Name </label>
        <input type="text" id="name" name="name">

        <label for="email">Email</label>
        <input type="email" id="email" name="email">
        
        <label for="phone_num">Phone Number</label>
        <input type="text" id="phone_num" name="phone_num">

        <input type="submit" id="submitButton">
    </form>
    
    <script>
        document.getElementById("submitButton").addEventListener("click", function(event) {
            var nameField = document.getElementById("name");
            var emailField = document.getElementById("email");
            var phoneField=document.getElementById("phone_num");
            
            if (emailField.value.trim() === "") {
                alert("Please fill in the Email field.");
                event.preventDefault(); 
                return;
            }

            if (phoneField.value.trim() === "") {
                alert("Please fill in the Phone Number field.");
                event.preventDefault(); 
                return;
            }
            if (nameField.value.trim() === "") {
                alert("Please fill in the Name field.");
                event.preventDefault(); 
                return;
            }
        });
    </script>
</body>
</html>