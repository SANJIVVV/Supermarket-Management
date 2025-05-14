<?php
// Database connection
$host = 'localhost';
$dbname = 'supermarket';
$user = 'root';  // Default XAMPP username
$pass = '';  // Default XAMPP password is empty

try {
    // Establish a database connection using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if both product_name and quantity are set and not empty in the POST request
if (!empty($_POST['product_name']) && !empty($_POST['quantity']) && !empty($_POST['customer_id'])) {
    $product_name = $_POST['product_name'];
    $quantity = (int)$_POST['quantity'];
    $customer_id = (int)$_POST['customer_id'];  // Ensure customer_id is passed through the POST request

    // Look up the product ID and stock quantity based on the product name
    $stmt = $pdo->prepare("SELECT id, stock_quantity FROM products WHERE name = ?");
    $stmt->execute([$product_name]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Get the product ID and stock quantity
        $product_id = $product['id'];
        $stock_quantity = (int)$product['stock_quantity'];

        // Ensure there's enough stock to add the requested quantity
        if ($quantity <= $stock_quantity) {
            // Check if the product is already in the cart for the current customer
            $stmt = $pdo->prepare("SELECT * FROM cart WHERE product_id = ? AND customer_id = ?");
            $stmt->execute([$product_id, $customer_id]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($item) {
                // If the product is already in the cart, update the quantity
                $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + ? WHERE product_id = ? AND customer_id = ?");
                $stmt->execute([$quantity, $product_id, $customer_id]);
            } else {
                // Insert a new product into the cart
                $stmt = $pdo->prepare("INSERT INTO cart (product_id, customer_id, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$product_id, $customer_id, $quantity]);
            }

            // Update the stock in the products table
            $new_stock_quantity = $stock_quantity - $quantity;
            $stmt = $pdo->prepare("UPDATE products SET stock_quantity = ? WHERE id = ?");
            $stmt->execute([$new_stock_quantity, $product_id]);

            echo "Product added to cart successfully!";
            
            // Redirect to the cart page after adding the product
            header("Location: cart.php");
            exit;
        } else {
            echo "Insufficient stock available.";
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product name, customer ID, and quantity are required.";
}
?>
