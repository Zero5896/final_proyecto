<?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    
        header("Location: login.php");
        exit();
    }


    if (isset($_SESSION['username'])) {
        $logged_user = $_SESSION['username'];
    }

$server = "localhost";
$username = "root";
$password = "";
$database = "sneaker";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Product ID is missing.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <meta charset="UTF-8">
    <title>Zero Kicks</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="assets/icon.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> 
    <style >

    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="assets/4.png" alt="Zero Kicks"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Women</a></li>
                        <li><a class="dropdown-item" href="#">Men</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($logged_user) && !empty($logged_user)): ?>
         
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user"></i><?php echo htmlspecialchars($logged_user); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?logout">Logout</a>
                    </li>
                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
    <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
</li>
        
            </ul>
        </div>
    </div>
</nav>



    <div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="assets/<?php echo $row['image_url']; ?>" class="img-fluid" alt="<?php echo $row['name']; ?>">
        </div>
        <div class="col-md-6">
           
            <div class="card product-details">
                <div class="card-body">
                    <h2 class="card-title"><?php echo $row['name']; ?></h2>
                    <p class="card-text">Brand: <?php echo $row['brand']; ?></p>
                    <p class="card-text">Gender: <?php echo $row['gender']; ?></p>
                    <p class="card-text">Size: <?php echo $row['size']; ?></p>
                    <p class="card-text">Price: $<?php echo number_format($row['price'], 2); ?></p>
     
                    <p class="card-text">Description: <?php echo $row['description']; ?></p>
                    <p class="card-text">Stock Quantity: <?php echo $row['stock_quantity']; ?></p>
                    <p class="card-text">Origin: <?php echo $row['origin']; ?></p>
                   
                    <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">

                  
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1">

                        
                        <label for="shoe_size">Select Size:</label>
                        <select name="shoe_size" id="shoe_size">
                            <?php
                           
                                for ($i = 6; $i <= 12; $i++) {
                                    echo "<option value='$i'>$i</option>";

                             
                                    $half = $i + 0.5;
                                    echo "<option value='$half'>$half</option>";
                                }
                            ?>
                        </select>

         
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
