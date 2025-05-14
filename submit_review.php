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
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $district = trim($_POST['district']);
    $state = trim($_POST['state']);
    $address = trim($_POST['address']);
    $review = $_POST['review'];
    $feedback = trim($_POST['feedback']);

    // Prepare and bind
    $sql = "INSERT INTO reviews (name, phone, district, state, address, review, feedback) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Check if the prepare() failed
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssssss", $name, $phone, $district, $state, $address, $review, $feedback);

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
