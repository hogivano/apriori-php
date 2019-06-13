<?php
  //db_connection.php

  $servername = "localhost";
  $username = "root";
  $password = "op";
  $dbname = "apriori";

  $conn = mysqli_connect($servername, $username, $password);
  $find_db = mysqli_select_db($conn, $dbname);

  if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
  } else {
    // echo "DB Connected";
  }
?>
