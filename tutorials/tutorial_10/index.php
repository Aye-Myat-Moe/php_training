<?php
  session_start();

  require_once "config.php";

  if (!$_SESSION['auth']) {
    header("Location:login.php");
    exit();
  }

  $sql = "SELECT * FROM sale_items";
  $results = $conn->query($sql);
  $i= 1;
  $category = ['Vehicle', 'Food & Drink', 'Electronic'];

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
    <a href="logout.php" class="btn btn-logout">Logout</a>
   <h1 class="ttl">ITEM LIST</h1>
   <div class="container">
     <div class="btn-wrapper clearfix">
      <a href="add.php" class="btn btn-add">Add Item</a>
      <a href="graph.php" class="btn btn-graph">Sale Graph</a>
     </div>
     <table class="item-table">
        <tr>
          <th>No.</th>
          <th>Item</th>
          <th>Category</th>
          <th>Count</th>
          <th>Price</th>
          <th>Customer</th>
          <th>Action</th>
        </tr>

        <?php if(mysqli_num_rows($results) > 0): ?>
          <?php foreach($results as $result): ?>
            <tr>
              <td><?=$i?></td>
              <td><?= ucwords($result['item']) ?></td>
              <td><?= $category[$result['category'] - 1]?></td>
              <td><?= $result['count'] ?></td>
              <td><?= $result['price'] ?></td>
              <td><?= ucwords($result['customer']) ?></td>
              <?php $id = $result['id']; $i++ ?>
              <td>
                <a href="update.php?id=<?= $id ?>" class="btn btn-edit">Edit</a>
                <a href="delete.php?id=<?= $id ?>" class="btn btn-delete">Delete</a>
              </td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
        
      </table>
   </div>
</body>
</html>