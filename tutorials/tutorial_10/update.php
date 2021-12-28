<?php
  session_start(); 
  
  require_once "config.php";

  if (!$_SESSION['auth']) {
    header("Location:login.php");
    exit();
  }

  $id = $_GET['id'];
  $item = '';
  $category = '';
  $count = '';
  $price = '';
  $customer = '';

  $sql = "SELECT * FROM sale_items WHERE id = $id";
  $results = $conn->query($sql);
  
  foreach($results as $result) {
    $item = $result['item'];
    $category = $result['category'];
    $count = $result['count'];
    $price = $result['price'];
    $customer = $result['customer'];
  }

  if(isset($_POST['save'])) {

    $item = $_POST['item'];
    $category = $_POST['category'];
    $count = $_POST['count'];
    $price = $_POST['price'];
    $customer = $_POST['customer'];
    $id = $_POST['id'];

    $stmt = $conn->prepare("UPDATE sale_items 
                            SET item = ?, category = ?, count = ?, price = ?, customer = ? 
                            WHERE id = ? ;"
                          );
    $stmt->bind_param("siiisi", $it, $ca, $co, $p, $cu, $i);
    $it = $item;
    $ca = intval($category);
    $co = intval($count);
    $p = intval($price);
    $cu = $customer;
    $i = intval($id);
    $stmt->execute();
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
     <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="add-form">
        <input type="hidden" name="id" value="<?= $id ?>">
       <div class="form-row">
         <label for="item">Item</label>
         <input type="text" name="item" id="item" class="item" placeholder="Item name" value="<?= $item ?>" required>
       </div>
       <div class="form-row">
        <label for="category">Category</label>
        <select name="category" id="category">
          <option value="1"<?= $category == '1' ? 'selected' : '' ?>>Vehicle</option>
          <option value="2"<?= $category == '2' ? 'selected' : '' ?>>Food & Drink</option>
          <option value="3"<?= $category == '3' ? 'selected' : '' ?>>Electronic</option>
        </select>
      </div>
      <div class="form-row">
        <label for="count">Count</label>
        <input type="number" name="count" id="count" class="count" placeholder="Item count" value="<?= $count ?>" required>
      </div>
      <div class="form-row">
        <label for="price">Price</label>
        <input type="text" name="price" id="price" class="price" placeholder="Item price" value="<?= $price ?>" required>
      </div>
      <div class="form-row">
        <label for="customer">Customer</label>
        <input type="text" name="customer" id="customer" class="customer" placeholder="customer name" value="<?= $customer ?>" required>
      </div>
      <div class="form-row clearfix">
        <a href="index.php" class="btn btn-back">Cancle</a>
        <button type="submit" name="save" class="btn btn-save">Update</button>
      </div>
     </form>
   </div>
</body>
</html>