<?php
$servername = "localhost";
$username = "root";
$password = "ayemyatmoe3394";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS php_training;";
$conn->query($sql);

$sql = "use php_training;";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS sale_items (
          id INT AUTO_INCREMENT, 
          item VARCHAR(255) NOT NULL, 
          category INT(11) NOT NULL,
          price INT(11) NOT NULL, 
          count INT(11) NOT NULL, 
          customer VARCHAR(255) NOT NULL, 
          PRIMARY KEY(id)
        );";

$conn->query($sql);

$userSql = "CREATE TABLE IF NOT EXISTS users (
              id INT AUTO_INCREMENT, 
              email VARCHAR(255) NOT NULL, 
              password varchar(255) NOT NULL,
              PRIMARY KEY(id)
            );";

$conn->query($userSql);

$userSql = "CREATE TABLE IF NOT EXISTS reset_codes (
  id INT AUTO_INCREMENT, 
  name VARCHAR(255) NOT NULL,
  status  INT(1) NOT NULL,
  PRIMARY KEY(id)
);";

$conn->query($userSql);