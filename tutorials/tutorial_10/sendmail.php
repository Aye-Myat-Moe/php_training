<?php
  require_once "config.php";

  $email = '';
  $errors = [];
  $data = [];
  $isMaliIndb = FALSE;

  $sql = "SELECT email FROM users";
  $results = $conn->query($sql);

  if (isset($_POST['submit'])) {
    $email = $_POST['email'] ?? '';

    foreach ($results as $result) {
      $isMaliIndb = $isMaliIndb || $result['email'] == $email;
    }
    if (!$email) {
      $errors['email'] = '*Email is required!';
    } elseif (!$isMaliIndb) {
      $errors['email'] = '*Email does not register!';
    }

    if (isMaliIndb) {
      $sql = "SELECT * FROM users WHERE email='".$email."'";
      $results = $conn->query($sql);
      foreach ($results as $result) {
        $data['id'] = $result['id'];
        $data['code'] = randomString();
      }
    }
    $serialData = serialize($data);

    if (!$errors) {
      $to = $email;
      $subject = "Reset Your Password";
      $message = "http://localhost/bib/php_training/tutorials/tutorial_10/reset_password.php?data=$serialData";
      $header = "From:sale@bib.com\r\n";
      $header .= "Content-Type:text/html";
      $mail = mail($to,$subject,$message,$header);
      $stmt = $conn->prepare("INSERT INTO reset_codes (name, status) VALUES (?, ?)");
      $stmt->bind_param("si", $na, $sta);
      $na = $data['code'];
      $sta = 1;
      $stmt->execute();
    } 
  }

  function randomString()
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 10; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
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
      <?php
        if($mail) {
          echo "<p class='alert'>Plete check your mail!</p>";
        }
      ?>
     <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="add-form" autocomplete="off">
      <div class="form-row">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="email" placeholder="Enter your eamil" value="<?= $email ?>">
        <small class="error-message"><?= $errors['email'] ?? '' ?></small>
      </div>
      <div class="form-row clear-fix">
        <button type="submit" name="submit" class="btn btn-save btn-send">Send</button>
      </div>
     </form>
   </div>
</body>
</html>