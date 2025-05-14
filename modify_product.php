<?php
// Database connection
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "supermarket"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the form
$current_name = $_POST['current_name']; // The current name or ID of the product
$new_name = $_POST['new_name']; // The new name of the product
$new_category = $_POST['new_category']; // The new category of the product
$new_price = $_POST['new_price']; // The new price of the product
$new_stock_quantity = $_POST['new_stock_quantity']; // The new stock quantity of the product

// Prepare and bind the SQL statement
// We will use 'ssdis' for binding parameters: two strings (for new_name and new_category), two integers (for new_price and new_stock_quantity), and one string (for current_name).
$stmt = $conn->prepare("UPDATE products SET name = ?, category = ?, price = ?, stock_quantity = ? WHERE name = ?");
$stmt->bind_param("ssdis", $new_name, $new_category, $new_price, $new_stock_quantity, $current_name);

// Execute the statement
if ($stmt->execute()) {
    echo "Product modified successfully.";
} else {
    echo "Error modifying product: " . $conn->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
