<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermarket";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection  
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Get form data
$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$stock_quantity = $_POST['stock_quantity'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO products (name, category, price, stock_quantity) VALUES (?, ?, ?, ?)");

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssdi", $name, $category, $price, $stock_quantity);

// Execute the statement
if ($stmt->execute()) {
    echo "New product added successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
