<?php
    session_start();


    $logged_user = '';


    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        if (isset($_SESSION['username'])) {
            $logged_user = $_SESSION['username']; 
        }
    }
    
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
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


    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
        <a class="navbar-brand" href="#"><img src="assets/4.png" alt="Zero Kicks"></a>
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
        <?php if ($logged_user !== ''): ?>
         
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-user"></i><?php echo htmlspecialchars($logged_user); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?logout">Logout</a>
            </li>
        <?php else: ?>
            <!-- Display login and register links if not logged in -->
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
</nav>







<div class="d-flex justify-content-center mt-4">
<div class="d-flex justify-content-center mt-4">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="max-width: 1000px;">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/ad01.png" class="d-block w-100" alt="Ad 01" style="max-height: 700px;">
            </div>
            <div class="carousel-item">
                <img src="assets/ad02.png" class="d-block w-100" alt="Ad 02" style="max-height: 700px;">
            </div>
            <div class="carousel-item">
                <img src="assets/ad03.png" class="d-block w-100" alt="Ad 03" style="max-height: 700px;">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>




</div>
<div class="container mt-4">
        <div class="row">
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        
            ?>
                        <div class="col-md-4 mb-4">
                            <div class="card" style="background-color: lightgrey;"> 
                                <a href="details.php?product_id=<?php echo $row['product_id']; ?>"> 
                                    <img src="assets/<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                    <label for="size">Select Size:</label>
                                    <select name="shoe_size" id="shoe_size">
                                            <?php
                                           
                                                for ($i = 6; $i <= 12; $i++) {
                                                    echo "<option value='$i'>$i</option>";

                                              
                                                    $half = $i + 0.5;
                                                    echo "<option value='$half'>$half</option>";
                                                }
                                            ?>
                                        </select>
                                    <a href="#" class="btn btn-primary">Add to Cart</a> 
                                    
                                </div>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo "No products available.";
                }
            ?>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

</script>
</body>
</html>
