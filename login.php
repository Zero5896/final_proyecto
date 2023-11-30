<?php
    session_start();

    $success_message = '';
    $error_message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $server = "localhost";
        $user = "root";
        $password = "";
        $db = "sneaker";

        $conn = new mysqli($server, $user, $password, $db);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $mail = $_POST["mail"];
        $pass = $_POST["pass"];

        $stmt = $conn->prepare("SELECT email FROM users WHERE email=? AND password=?");
        $stmt->bind_param("ss", $mail, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $mail; 

            header("Location: index.php");
            exit();
        } else {
            $error_message = 'Invalid email or password.';
        }

        $stmt->close();
        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 
    <link href="style.css" rel="stylesheet"> 
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body class="login">
    <div class="login-form">
        <h2 class="text-center mb-4">Login</h2>


        <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" name="mail" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="pass" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Log in</button>
            </div>
        </form>


        <p class="text-center mt-3">Don't have an account? <a href="register.php">Register now</a></p>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
