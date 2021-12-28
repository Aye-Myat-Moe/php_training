<?php
  session_start();

  require_once "config.php";

  $email = '';
  $password = '';
  $errors = [];
  $emailsInDb = [];
  $passwordsInDb = '';

  $sql = "SELECT email FROM users";
  $results = $conn->query($sql);

  foreach ($results as $result) {
    array_push($emailsInDb, $result['email']);
  }

  if (isset($_POST['submit'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if(!$email) {
      $errors['email'] = '*Email is required!';
    } elseif (!in_array($email,$emailsInDb)) {
      $errors['email'] = '*Email is not register!';
    }

    $sql = "SELECT password FROM users WHERE email='".$email."'";
    $results = $conn->query($sql);

    foreach ($results as $result) {
      $passwordsInDb = $result['password'];
    }

    if (!$password) {
      $errors['password'] = '*Password is required!';
    } elseif ($password !== $passwordsInDb) {
      $errors['password'] = '*Password is wrong!';
    }
    
    if (!$errors) {
        $_SESSION['auth'] = TRUE;
        header('Location:index.php');
        exit();
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tutorial 10</title>
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1 class="ttl">Login Here</h1>

    <div class="container">
     <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="add-form" autocomplete="off">
      <div class="form-row">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="email" placeholder="Enter your eamil" value=<?= $email ?>>
        <small class="error-message"><?= $errors['email'] ?? '' ?></small>
      </div>
      <div class="form-row">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="password" placeholder="Enter your password">
        <small class="error-message"><?= $errors['password'] ?? '' ?></small>
      </div>
      <div class="form-row">
        <a href="sendmail.php" class="forget-pass">Forget password?</a>
      </div>
      <div class="form-row btn-wrapper">
        <button type="submit" name="submit" class="btn btn-save">Login</button>
        <a href="register.php" class="btn btn-register">Register</a>
      </div>
     </form>
   </div>
</body>
</html>