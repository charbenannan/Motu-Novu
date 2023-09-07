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
    <title>Add Product</title>
</head>
<body>
    <h1>Create Product</h1>
    <form action="backend/create_product.php" method="POST">
        <label for="name">Product Name</label>
        <input type="text" id="name" name="name">

        <label for="description">Product Description</label>
        <input type="text" id="description" name="description">
        
        <label for="price">Price $</label>
        <input type="number" id="price" name="price">

        <input type="submit" id="submitButton">
    </form>
    
    <script>
        document.getElementById("submitButton").addEventListener("click", function(event) {
            var nameField = document.getElementById("name");
            var descriptionField = document.getElementById("description");
            var priceField=document.getElementById("price");
            
            if (nameField.value.trim() === "") {
                alert("Please fill in the Name field.");
                event.preventDefault(); 
                return;
            }

            if (descriptionField.value.trim() === "") {
                alert("Please fill in the Description field.");
                event.preventDefault(); 
                return;
            }
            if(priceField.value.trim()==="") {
                alert("Please fill in the Price field.");
                event.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>