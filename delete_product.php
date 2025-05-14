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

// Capture form data
$name = $_POST['name']; // For name
 // For ID

// Prepare and bind
$stmt = $conn->prepare("DELETE FROM products WHERE name = ?");
$stmt->bind_param("s", $name);

// Execute the statement
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "Product deleted successfully.";
    } else {
        echo "No product found with that name.";
    }
} else {
    echo "Error deleting product: " . $conn->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
