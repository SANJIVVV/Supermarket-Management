<?php
// Database configuration
$servername = "localhost"; 
$db_username = "root"; 
$db_password = ""; 
$dbname = "supermarket"; 

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign form inputs to variables
    $product_name = trim($_POST['product_name']);
    $category = trim($_POST['category']);
    $rating = (int)$_POST['rating']; // Cast to integer
    $quality = $_POST['quality'];
    $suggestion = trim($_POST['suggestion']);

    // Prepare and bind
    $sql = "INSERT INTO product_reviews (product_name, category, rating, quality, suggestion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Check if the prepare() failed
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssiss", $product_name, $category, $rating, $quality, $suggestion);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Review submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
