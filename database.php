<?php
$hostName = "localhost";
$userName = "root";
$password = "";
$databaseName = "wzb";
$conn = new mysqli($hostName, $userName, $password, $databaseName);
// Check connection
if (!$conn) {
  die("Error connecting to database: " . mysqli_connect_error());
}
?>