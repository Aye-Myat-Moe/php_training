<?php
session_start();
$n = $_POST['name'];
$p = $_POST['password'];
$_SESSION['name'] = $n;
$_SESSION['password'] = $p;
echo "User Name is " . $_SESSION['name'];
echo "User Password is" . $_SESSION['password'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="logout.php">logout</a>
</body>
</html>