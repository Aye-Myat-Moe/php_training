<?php
  require_once "config.php";

  $data = unserialize($_GET['data']);
  $getName = $data['code'] ?? '';
  $getId = $data['id'] ?? '';

  $sql = "SELECT * FROM reset_codes WHERE name='".$getName."'";
  $results = $conn->query($sql);
  foreach ($results as $result) {
    $status = $result['status'];
  }

  if($status != 1) {
    header("Location:login.php");
  }

  $password = '';
  $cfmPassword = '';
  $name = '';
  $id = '';
  $errors = [];

  if (isset($_POST['submit'])) {
    $name = $_POST['code'] ?? '';
    $id = $_POST['id'] ?? '';
    $password = $_POST['password'] ?? '';
    $cfmPassword = $_POST['cfm-password'] ?? '';
    
    if (!$password) {
      $errors['password'] = '*Password is required!';
    } 

    if (!$cfmPassword) {
      $errors['cfmPassword'] = '*Comfirm your password!';
    } elseif ($password !== $cfmPassword) {
      $errors['cfmPassword'] = '*Password does not match!';
    }

    if (!$errors) {
      $stmt = $conn->prepare("UPDATE reset_codes 
                              SET status = ?
                              WHERE name = ? ;"
                            );
      $stmt->bind_param("is", $sta, $na);
      $sta = 0;
      $na = $name;
      $stmt->execute();

      $stmt = $conn->prepare("UPDATE users 
                              SET password = ?
                              WHERE id = ? ;"
                            );
      $stmt->bind_param("si", $pass, $i);
      $pass = $password;
      $i = $id;
      $stmt->execute();

      header("Location:login.php");
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
    <h1 class="ttl">Your Email</h1>

    <div class="container">
     <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="add-form" autocomplete="off">
     <input type="hidden" name="code" value="<?= $getName ?>">
      <input type="hidden" name="id" value="<?= $getId ?>">
      <div class="form-row">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="password" placeholder="Enter password" value="<?= $password ?>">
        <small class="error-message"><?= $errors['password'] ?? '' ?></small>
      </div>
      <div class="form-row">
        <label for="cfm-password">Comfirm password</label>
        <input type="password" name="cfm-password" id="cfm-password" class="cfm-password" placeholder="Comfirm your password" value="">
        <small class="error-message"><?= $errors['cfmPassword'] ?? '' ?></small>
      </div>
      <div class="form-row clear-fix">
        <a href="login.php" class="btn btn-back">Cancle</a>
        <button type="submit" name="submit" class="btn btn-save btn-reg">Save</button>
      </div>
     </form>
   </div>
</body>
</html>