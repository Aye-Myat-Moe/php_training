<?php
  session_start();

  require_once "config.php";

  if (!$_SESSION['auth']) {
    header("Location:login.php");
    exit();
  }

  $vehicle = 0;
  $foodAndDrink = 0;
  $electronic = 0;

  $sql = "SELECT category,count FROM sale_items";
  $results = $conn->query($sql);

  foreach ($results as $result) {
      $category = $result['category'];
      $count = $result['count'];
      if ( $category == 1) {
          $vehicle += $count;
      } elseif ($category == 2) {
          $foodAndDrink += $count;
      } else {
          $electronic += $count; 
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
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <input type="hidden" name="vehicle" id="vehicle" value="<?= $vehicle ?>">
  <input type="hidden" name="food-drink" id="food-drink" value="<?= $foodAndDrink ?>">
  <input type="hidden" name="electronic" id="ele" value="<?= $electronic ?>">

  <div class="graph-wrapper">
    <h1 class="ttl">Sale Graph By Category</h1>
    <a href="index.php" class="btn btn-back-graph">Back</a>
    <canvas id="myChart" width="400" height="200"></canvas>
  </div>
  
  <script src="js/library/chart.js/dist/chart.js"></script>
  <script src="js/common.js"></script>
</body>
</html>