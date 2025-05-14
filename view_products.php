<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "supermarket"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch products from the SUPERM table
$sql = "SELECT id, name, category, price, stock_quantity FROM products"; 
$result = $conn->query($sql);

// Check if query executed successfully
if ($result === false) {
    die("Error in query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('s4.jpg'); /* Background image path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-transform: uppercase;
        }
        .header {
            text-align: center;
            background-color: red; /* Red background color */
            color: white; /* White text color */
            width: 100%;
            padding: 20px 0;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-bottom: 5px solid darkred; /* Dark red accent border */
        }
        .header h1 {
            margin: 0;
            font-size: 36px;
            font-weight: bold;
            font-family: 'Roboto', sans-serif;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        table {
            width: 100%;
            max-width: 1000px;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.9); /* White background with opacity */
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid lightgray; /* Light gray border */
        }
        th {
            background-color: red; /* Red background for table headers */
            color: white; /* White text color */
        }
        tr:nth-child(even) {
            background-color: lightgray; /* Light gray background for even rows */
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: red; /* Red color */
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>View Products</h1>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['stock_quantity']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No products found.</p>
    <?php endif; ?>

    <a href="USER.html" class="back-link">Back to Home</a>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
