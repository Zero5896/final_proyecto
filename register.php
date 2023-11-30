<?php
    $server = "localhost";
    $user = "root";
    $contra = "";
    $db = "sneaker"; // Updated database name
    $table = "users"; // Updated table name

    $conn = new mysqli($server, $user, $contra, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["mail"];
        $username = $_POST["username"];
        $phone = $_POST["phone"];
        $password = $_POST["pass"];
        $payment_method = $_POST["payment_method"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        
        // Insert user details into the 'users' table
        $sql = "INSERT INTO $table (email, username, phone, password, payment_method, Name, Lastname) VALUES ('$email', '$username', '$phone', '$password', '$payment_method', '$first_name', '$last_name')";
        if ($conn->query($sql) === TRUE) {
            // Registration successful - Redirect to login.php with a success message
            header("Location: login.php?success=1");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="style.css" rel="stylesheet"> 
    
    
    </style>
</head>
<body>

<div class="register-form">
  
    <div class="register-form">
    <h2 class="text-center mb-4">Register</h2>
    <form action="" method="post">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" name="mail" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" name="username" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Phone" name="phone" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="pass" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Payment Method" name="payment_method" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="First Name" name="first_name" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Last Name" name="last_name" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
    </form>
</div>

    </form>
    <?php
        
        if(isset($_GET['success']) && $_GET['success'] == 1) {
            echo '<div class="success-box">Congrats, you can now login!</div>';
        }
    ?>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
