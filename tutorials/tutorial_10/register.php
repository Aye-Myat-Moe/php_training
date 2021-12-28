<?php
  require_once "config.php";

  $email = '';
  $password = '';
  $cfmPassword = '';
  $errors = [];
  $isMaliIndb = FALSE;

  $sql = "SELECT email FROM users";
  $results = $conn->query($sql);

  if (isset($_POST['submit'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $cfmPassword = $_POST['cfm-password'] ?? '';

    foreach ($results as $result) {
      $isMaliIndb = $isMaliIndb || $result['email'] == $email;
    }
    if (!$email) {
      $errors['email'] = '*Email is required!';
    } elseif ($isMaliIndb) {
      $errors['email'] = '*Email is already exist!';
    }

    if (!$password) {
      $errors['password'] = '*Password is required!';
    }
    if (!$cfmPassword) {
      $errors['cfmPassword'] = '*This field is required!';
    } elseif ($password !== $cfmPassword) {
      $errors['cfmPassword'] = '*Password does not match!';
    }

    if (!$errors) {
      $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
      $stmt->bind_param("ss", $em, $pass);
      $em = $email;
      $pass = $password;
      $stmt->execute();
      header("Location:login.php");
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
    <h1 class="ttl">Register Here</h1>

    <div class="container">
     <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="add-form" autocomplete="off">
      <div class="form-row">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="email" placeholder="Enter your eamil" value="<?= $email ?>">
        <small class="error-message"><?= $errors['email'] ?? '' ?></small>
      </div>
      <div class="form-row">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="password" placeholder="Enter your password"value="<?= $password ?>">
        <small class="error-message"><?= $errors['password'] ?? '' ?></small>
      </div>
      <div class="form-row">
        <label for="password">Comfirm Password</label>
        <input type="password" name="cfm-password" id="cfm-password" class="cfm-password" placeholder="Comfirm your password"value="<?= $cfmPassword ?>">
        <small class="error-message"><?= $errors['cfmPassword'] ?? '' ?></small>
      </div>
      <div class="form-row clear-fix">
        <a href="login.php" class="btn btn-back">Cancle</a>
        <button type="submit" name="submit" class="btn btn-save btn-reg">Register</button>
      </div>
     </form>
   </div>
</body>
</html>