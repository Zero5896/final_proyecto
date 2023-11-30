<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {

    header("Location: login.php"); 
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>

</head>
<body>


    <h1>Welcome to the Admin Panel</h1>

    <div>
        <a href="logout.php">Logout</a> 
    </div>

</body>
</html>
