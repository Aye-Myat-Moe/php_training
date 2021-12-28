<?php
  session_start();

  require_once "config.php";

  if (!$_SESSION['auth']) {
    header("Location:login.php");
    exit();
  }

  if(isset($_POST['save'])) {
    $item = $_POST['item'];
    $category = $_POST['category'];
    $count = $_POST['count'];
    $price = $_POST['price'];
    $customer = $_POST['customer'];

    $stmt = $conn->prepare("INSERT INTO sale_items (item, category, count, price, customer) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisis", $it, $ca, $co, $p, $cu);
    $it = $item;
    $ca = intval($category);
    $co = intval($count);
    $p = intval($price);
    $cu = $customer;
    $stmt->execute();
    header('Location:index.php');
  }
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tutorial 10</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <h1 class="ttl">ADD TO ITEM</h1>
   <div class="container">
     <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="add-form">
       <div class="form-row">
         <label for="item">Item</label>
         <input type="text" name="item" id="item" class="item" placeholder="Item name" required>
       </div>
       <div class="form-row">
        <label for="category">Category</label>
        <select name="category" id="category">
          <option value="1">Vehicle</option>
          <option value="2">Food & Drind</option>
          <option value="3">Electronic</option>
        </select>
      </div>
      <div class="form-row">
        <label for="count">Count</label>
        <input type="number" name="count" id="count" class="count" placeholder="Item count" value="1" required>
      </div>
      <div class="form-row">
        <label for="price">Price</label>
        <input type="text" name="price" id="price" class="price" placeholder="Item price" required>
      </div>
      <div class="form-row">
        <label for="customer">Customer</label>
        <input type="text" name="customer" id="customer" class="customer" placeholder="customer name" required>
      </div>
      <div class="form-row clearfix">
        <a href="index.php" class="btn btn-back">Cancle</a>
        <button type="submit" name="save" class="btn btn-save">Save</button>
      </div>
     </form>
   </div>
</body>
</html>