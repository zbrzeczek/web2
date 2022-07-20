<?php
$hostName = "localhost";
$userName = "root";
$password = "";
$databaseName = "wzb";

try {
  $conn = new mysqli($hostName, $userName, $password, $databaseName);
  if ($conn->connect_errno!=0) {
    throw new Exeption(mysqli_connect_errno());
  }
}
catch(Exeption $er){
  echo '<span style="color:red;">Błąd serwera</span>';
  echo '<br>Informacja developerska: '.$er;
}
?>