<?php
include './db_connection.php';
ini_set('max_execution_time', 300);
$resultSupport = [];
$resultConfidence = [];

$support = $_POST['support'];
$confidence = $_POST['confidence'];

if (isset($support) && isset($confidence)){
  $min_suport = $support;
  $transaction = getTransaction($conn);
  $item = getLiterationOne($conn, $min_suport);
  if(sizeof($item) > 0){
    array_push($resultSupport, $item);
    $combineOne = combineOne($conn,$min_suport, $transaction, $item);
    if (sizeof($combineOne) > 0){
      array_push($resultSupport, $combineOne);
      $combine = combine($conn,$min_suport, $transaction, $combineOne, []);
      if (sizeof($combine) > 0){
        array_push($resultSupport, $combine);
        while (sizeof($combine) > 1) {
          $combine = combine($conn,$min_suport, $transaction, $combine, []);
          if (sizeof($combine) > 0){
            array_push($resultSupport, $combine);
          }
        }
      }
    }
  }
  // print_r($resultSupport);
  for ($i=1; $i < sizeof($resultSupport); $i++) {
    # code...
    $arr = [];
    for ($j=0; $j < sizeof($resultSupport[$i]); $j++) {
      # code...
      // print_r($resultSupport[$i][$j]);
      if (sizeof($resultSupport[$i][$j]['item_id']) == 2){
        getCount2($resultSupport[$i][$j], $resultSupport[$i-1]);
      }else if (sizeof($resultSupport[$i][$j]['item_id']) == 3){

      } else if (sizeof($resultSupport[$i][$j]['item_id']) == 4){

      } else if(sizeof($resultSupport[$i][$j]['item_id']) == 5){

      }
    }
  }
} else {
  header("Location: start.php");
}

function countCombine($arr, $resultSupport){
  $item_id = $arr['item_id'];
  for ($j=0; $j < sizeof($resultSupport); $j++) {
    $cek = 0;
    for ($i=0; $i < sizeof($resultSupport[$j]['item_id']); $i++) {
      # code...
      if ($resultSupport[$j]['item_id'][$i] == $item_id['id']){
        $cek++;
      }
    }
    if ($cek == sizeof($item_id)){
      return $resultSupport[$j]['count'];
    }
  }
  return 0;
}

function getCount2($arr, $resultSupport){
  $result = [];
  $item_id = $arr['item_id'];
  // print_r($item_id);
  // print_r(countCombine($item_id, $resultSupport));
  // array_push($result, ['from' => $item_id[0], 'to' => $item_id[1], 'count' => countCombine($item_id, $resultSupport), 'percent' => ]);
  // array_push($result, ['from' => $item_id[1], 'to' => $item_id[0], 'count' => countCombine($item_id, $resultSupport), 'percent' => ]);


}

function getCount3($arr, $resultSupport){

}

function getCount4($arr, $resultSupport){

}

function getCount5($arr, $resultSupport){

}

function getCount6($arr, $resultSupport){

}

function getCount($arr, $resultSupport){

}
// print_r($resultSupport);
// print_r($item);

function checkListItem($listItem, $arr){
  $new = [];
  foreach ($arr as $a) {
    # code...
    foreach ($listItem as $l) {
      # code...
      if ($a == $l['id']){
        array_push($new, $l['item']);
      }
    }
  }
  return $new;
}

function checkLiteration($conn, $transaction, $arr){
  $count = 0;
  foreach ($transaction as $t) {
    $cek = 0;
    foreach ($arr as $a) {
      # code...
      foreach ($t['item'] as $i) {
        # code...
        if ($a['id'] == $i){
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
      $new = [$arr[$i]['item_id'][0], $arr[$j]['item_id'][0]];
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

function combine($conn,$min_suport, $transaction, $arr, $resultSupport){
  $array_combine = [];
  for ($i=0; $i < sizeof($arr)-1; $i++) {
    for ($j=$i + 1; $j < sizeof($arr); $j++) {
      $cek = 0;
      for ($k=0; $k < sizeof($arr[$i]['item_id']) - 1; $k++) {
        # code...
        if ($arr[$i]['item_id'][$k]['id'] == $arr[$j]['item_id'][$k]['id']){
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
        // break;
      }
    }
  }
  // if (sizeof($array_combine) > 1){
  //   array_push($resultSupport, $array_combine);
  //   combine($conn,$min_suport, $transaction, $array_combine, $resultSupport);
  // } else {
  //   return $resultSupport;
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
  $sql = "SELECT transaction_detail.transaction_id, transaction_detail.item_id, item.item FROM transaction_detail INNER JOIN item
        ON transaction_detail.item_id = item.id ORDER BY item_id";
  $cek = mysqli_query($conn, $sql);
  $arr = [];
  $item = [];
  $transaction = [];

  if ($cek){
    if (mysqli_num_rows($cek) > 0){
      $item_id = "";
      $nama = "";
      $transaction_id = "";
      $count = 0;
      while ($row = mysqli_fetch_array($cek)) {
        // array_push($item, $row);
        // print_r($row);
        if ($item_id == ""){
          $count = 1;
          $item_id = $row['item_id'];
          $nama = $row['item'];
        } else if ($item_id != $row['item_id']){
          // print_r("two");
          if ($count >= $min_suport){
            array_push($item, ['item_id' => [['id' => $row['item_id'], 'item' => $row['item']]], 'count' => $count, 'support' => $count / 50 * 100]);
            // $item["'$item_id'"] = $count;
          }
          $count = 1;
          $item_id = $row['item_id'];
          $nama = $row['item'];
        } else {
          if ($transaction_id != $row['transaction_id']){
            $count++;
          }
          // $count++;
        }
        $transaction_id = $row['transaction_id'];
        // array_push($arr, ['id' => $row['id'], 'name' => $row['name'], 'kota' => []]);
        // print_r($item);
      }
      if ($count >= $min_suport){
        array_push($item, ['item_id' => [['id' => $item_id, 'item' => $nama]], 'count' => $count, 'support' => $count / 50 * 100]);
      }
      usort($item, function($a, $b) {
        return $a['count'] <= $b['count'];
      });
    }
    return $item;
  }
}
?>
