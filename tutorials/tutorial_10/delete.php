<?php
  session_start();
  
  require_once "config.php";

  if (!$_SESSION['auth']) {
    header("Location:login.php");
    exit();
  }

  $id = $_GET['id'];
  $sql = "DELETE FROM sale_items WHERE id = $id";
  $results = $conn->query($sql);
  header("Location:index.php");
  
?>
