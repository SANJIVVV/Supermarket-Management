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
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Not hashed
    $dob = trim($_POST['dob']);
    $address = trim($_POST['address']);
    $state = trim($_POST['state']);
    $country = trim($_POST['country']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    
    // Prepare and bind
    $sql = "INSERT INTO CUSTOMER_REG (username, password, address, state, country, mobile, email ,dob) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Check if the prepare() failed
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssssss", $username, $password, $dob, $address, $state, $country, $mobile, $email);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
        // You can redirect to another page if needed
        // header("Location: success_page.php");
        // exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
