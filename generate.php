<?php
include './db_connection.php';
$file = fopen("./excel/online_retail.csv","r");

$i = 0;
$invoice_id = "";
$customer_id = "";
$date = "";
$arr = [];
while(! feof($file) && $i < 729)
  {
    $csv = fgetcsv($file);
    if ($i == 1){
      $invoice_id = $csv[0];
      $customer_id = $csv[6];
      $date = $csv[4];
      array_push($arr, $csv[1]);
      generateItem($csv, $conn);
    } else if ($i > 0){
      if ($invoice_id != $csv[0]){
        if ($customer_id !== ""){
          generateTransaction($arr, $customer_id, $invoice_id, $date, $conn);
          generateTransactionDetail($arr, $invoice_id, $conn);
        }
        $arr = [];
      }
      if ($csv[2] !== ""){
        array_push($arr, $csv[1]);
      }
      $invoice_id = $csv[0];
      $customer_id = $csv[6];
      $date = $csv[4];
      generateItem($csv, $conn);
    }
    // print_r($csv);
    $i++;
  }

fclose($file);

function generateTransaction($val, $customer_id, $invoice_id, $date, $conn){
  print_r($val);
  if ($invoice_id != ""){
    $sqlInsert = "INSERT INTO transaction (id, customer_id, created_at)
      VALUES ('$invoice_id', '$customer_id', $date)";
      if ($conn->query($sqlInsert) === TRUE) {
        print_r("New record created transaction successfully");
      } else {
        print_r("Error: " . $sqlInsert . "<br>" . $conn->error);
      }
  }
}

function generateTransactionDetail($arr, $transaction_id, $conn){
  foreach ($arr as $i) {
    $sqlInsert = "INSERT INTO transaction_detail (transaction_id, item_id)
      VALUES ('$transaction_id', '$i')";
      if ($conn->query($sqlInsert) === TRUE) {
        print_r("New record created detail transaction successfully");
      } else {
        print_r("Error: " . $sqlInsert . "<br>" . $conn->error);
      }
  }
}

function generateItem($val, $conn){
  $sql = "SELECT * FROM item WHERE id = '$val[1]'";
  $cek = mysqli_query($conn, $sql);
  $arr = [];

  if ($cek){
    if (mysqli_num_rows($cek) > 0){
      // while ($row = mysqli_fetch_array($cek)) {
      //   array_push($arr, ['id' => $row['id'], 'name' => $row['name'], 'kota' => []]);
      // }
    } else {
      $desc = str_replace("'", "", $val[2]);
      $sqlInsert = "INSERT INTO item (id, item)
        VALUES ('$val[1]', '$desc')";
      if ($desc !== ""){
        if ($conn->query($sqlInsert) === TRUE) {
          print_r("New record created successfully");
        } else {
          print_r("Error: " . $sqlInsert . "<br>" . $conn->error);
        }
      }
    }
  }
}
?>
