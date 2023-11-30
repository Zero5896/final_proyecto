<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$server = "localhost";
$username = "root";
$password = "";
$database = "sneaker";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id']; // Get the user ID from the session

// Query shopping cart items for the user using prepared statements
$cart_sql = "SELECT shoppingcart.quantity, products.name, products.price 
            FROM shoppingcart 
            INNER JOIN products ON shoppingcart.product_id = products.product_id 
            WHERE shoppingcart.user_id = ?";

$stmt = $conn->prepare($cart_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
 
</head>
<body>

 

    <div class="container mt-4">
        <h2>Your Shopping Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
     
                    $cart_sql = "SELECT * FROM shoppingcart WHERE user_id = $user_id";
                    $cart_result = $conn->query($cart_sql);
                    if ($cart_result->num_rows > 0) {
                        while ($row = $cart_result->fetch_assoc()) {
                            $product_id = $row['product_id'];
                            
                            $product_sql = "SELECT * FROM products WHERE product_id = $product_id";
                            $product_result = $conn->query($product_sql);
                            if ($product_result->num_rows > 0) {
                                $product = $product_result->fetch_assoc();
                        
                                $total_cost = $row['quantity'] * $product['price'];
                ?>
                                <tr>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                                    <td>$<?php echo number_format($total_cost, 2); ?></td>
                                </tr>
                <?php
                            }
                        }
                    } else {
                        echo "<tr><td colspan='4'>No products in the cart.</td></tr>";
                    }
                ?>
            </tbody>
        </table>

       
        <div>
            
            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    </div>

</body>
</html>
