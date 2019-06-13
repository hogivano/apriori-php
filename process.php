<?php
include './db_connection.php';
ini_set('max_execution_time', 300);

$min_suport = 4;
$transaction = getTransaction($conn);
// print_r($transaction);
$item = getLiterationOne($conn, $min_suport);
$combineOne = combineOne($conn,$min_suport, $transaction, $item);
$combine = combine($conn,$min_suport, $transaction, $combineOne, []);
$result = [];
if (sizeof($combine) > 0){
  $result = [$item, $combineOne, $combine];
  while (sizeof($combine) > 1) {
    $combine = combine($conn,$min_suport, $transaction, $combine, []);
    if (sizeof($combine) > 0){
      array_push($result, $combine);
    }
  }
}
print_r($result);
// print_r($item);

function checkLiteration($conn, $transaction, $arr){
  $count = 0;
  foreach ($transaction as $t) {
    $cek = 0;
    foreach ($arr as $a) {
      # code...
      foreach ($t['item'] as $i) {
        # code...
        if ($a == $i){
          $cek++;
        }
      }
    }
    if ($cek >= sizeof($arr)){
      $count++;
    }
  }
  return $count;
}

function combineOne($conn,$min_suport, $transaction, $arr){
  $array_combine = [];
  for ($i=0; $i < sizeof($arr) - 1; $i++) {
    $a = [];
    for ($j = $i + 1; $j < sizeof($arr); $j++) {
      # code...
      $new = [$arr[$i]['item_id'], $arr[$j]['item_id']];
      $count = checkLiteration($conn, $transaction, $new);
      if ($count >= $min_suport){
        array_push($array_combine, ['item_id' => $new, 'count' => $count, 'support' => $count / 50 * 100]);
      }
    }
  }
  // usort($array_combine, function($a, $b) {
  //   return $a['count'] <= $b['count'];
  // });
  return $array_combine;
}

function combine($conn,$min_suport, $transaction, $arr, $result){
  $array_combine = [];
  for ($i=0; $i < sizeof($arr)-1; $i++) {
    for ($j=$i + 1; $j < sizeof($arr); $j++) {
      $cek = 0;
      for ($k=0; $k < sizeof($arr[$i]['item_id']) - 1; $k++) {
        # code...
        if ($arr[$i]['item_id'][$k] == $arr[$j]['item_id'][$k]){
          $cek++;
        }
      }
      if ($cek == sizeof($arr[$i]['item_id']) - 1 ){
        $new = $arr[$i]['item_id'];
        array_push($new, $arr[$j]['item_id'][sizeof($arr[$i]['item_id']) - 1]);
        $count = checkLiteration($conn, $transaction, $new);
        if ($count >= $min_suport){
          array_push($array_combine, ['item_id' => $new, 'count' => $count, 'support' => $count / 50 * 100]);
        }
      } else {
        break;
      }
    }
  }
  // if (sizeof($array_combine) > 1){
  //   array_push($result, $array_combine);
  //   combine($conn,$min_suport, $transaction, $array_combine, $result);
  // } else {
  //   return $result;
  // }
  return $array_combine;
}

function getTransaction($conn){
  $sql = "SELECT * FROM transaction_detail ORDER BY transaction_id, item_id";
  $cek = mysqli_query($conn, $sql);
  $transaction = [];

  if ($cek){
    if (mysqli_num_rows($cek) > 0){
      $transaction_id = "";
      $item_id = "";
      $arr = [];
      while ($row = mysqli_fetch_array($cek)) {
        if ($transaction_id == ""){
          $transaction_id = $row['transaction_id'];
          array_push($arr, $item_id);
        } else if ($transaction_id != $row['transaction_id']){
          array_push($transaction, ['transaction_id' => $transaction_id, 'item' => $arr]);
          $arr = [];
          $transaction_id = $row['transaction_id'];
          array_push($arr, $row['item_id']);
        } else {
          if ($item_id != $row['item_id']){
            array_push($arr, $item_id);
          }
        }
        $item_id = $row['item_id'];
      }
      array_push($transaction, ['transaction_id' => $transaction_id, 'item' => $arr]);
      usort($transaction, function($a, $b) {
        return sizeof($a['item']) <= sizeof($b['item']);
      });
      // print_r($transaction);
    }
    return $transaction;
  }
}

function getLiterationOne($conn, $min_suport){
  $sql = "SELECT * FROM transaction_detail ORDER BY item_id";
  $cek = mysqli_query($conn, $sql);
  $arr = [];
  $item = [];
  $transaction = [];

  if ($cek){
    if (mysqli_num_rows($cek) > 0){
      $item_id = "";
      $transaction_id = "";
      $count = 0;
      while ($row = mysqli_fetch_array($cek)) {
        // array_push($item, $row);
        if ($item_id == ""){
          print_r("one");
          $count = 1;
          $item_id = $row[1];
        } else if ($item_id != $row[1]){
          // print_r("two");
          if ($count >= $min_suport){
            array_push($item, ['item_id' => $item_id, 'count' => $count, 'support' => $count / 50 * 100]);
            // $item["'$item_id'"] = $count;
          }
          $count = 1;
          $item_id = $row[1];
        } else {
          if ($transaction_id != $row[0]){
            $count++;
          }
          // $count++;
        }
        $transaction_id = $row[0];
        // array_push($arr, ['id' => $row['id'], 'name' => $row['name'], 'kota' => []]);
        // print_r($row);
      }
      if ($count >= $min_suport){
        array_push($item, ['item_id' => $item_id, 'count' => $count, 'support' => $count / 50 * 100]);
      }
      usort($item, function($a, $b) {
        return $a['count'] <= $b['count'];
      });
      // rsort($item);
      // print_r($item);
    }
    return $item;
  }
}

function checkItem(){

}
?>
