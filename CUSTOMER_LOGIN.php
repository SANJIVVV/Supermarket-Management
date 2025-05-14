<?php
session_start(); // Start the session

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

$error = "";

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if username and password are set in the POST request and not empty
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("SELECT id, password FROM CUSTOMER_REG WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $db_password);
            $stmt->fetch();
            
            // Verify the password (no hashing in your case)
            if ($password === $db_password) {
                // Store user_id and username in session
                $_SESSION['user_id'] = $user_id; 
                $_SESSION['username'] = $username;

                // Redirect to home page
                header("Location: index.html");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "User not found! Please register.";
        }

        $stmt->close();
    } else {
        $error = "Please enter both username and password!";
    }
}

$conn->close();

// Display error message if any
if ($error) {
    echo "<p style='color: red;'>$error</p>";
}
?>
