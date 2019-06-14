<?php
  include_once './process.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Start</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
body {
  background: linear-gradient(87deg, #FF416C 0, #FF4B2B 100%) !important;
  color: white !important;
}
table{
  width:100%;
}
#example_filter{
  float:right;
}
#example_paginate{
  float:right;
}
label {
  display: inline-flex;
  margin-bottom: .5rem;
  margin-top: .5rem;

}

</style>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
  $('#example').DataTable(

       {

    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "iDisplayLength": 10
     }
      );
  $('#example2').DataTable(

       {

    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "iDisplayLength": 10
     }
      );
} );


function checkAll(bx) {
var cbs = document.getElementsByTagName('input');
for(var i=0; i < cbs.length; i++) {
  if(cbs[i].type == 'checkbox') {
    cbs[i].checked = bx.checked;
  }
}
}
</script>
  </head>
  <body>
    <div class="container" style="padding: 50px 0px;">

  <?php foreach ($resultSupport as $l) {
    # code...
    // print_r ($l);
    // echo "\n";
  } ?>
	<div class="row">
    <h3 style="text-align: center; width: 100%; margin-bottom: 50px;">Support</h3>
	<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Item</th>
                <th>Support Count</th>
                <th>Support</th>
            </tr>
        </thead>
        <tbody>
          <?php
            foreach ($resultSupport as $i) {
              # code...
              foreach ($i as $j) {
                # code...
                ?>
                <tr>
                  <td>
                    <ul>
                      <?php
                      // $result = "{";
                        for ($l=0; $l < sizeof($j['item_id']); $l++) {
                          # code...
                          ?>
                          <li>
                            <?php echo $j['item_id'][$l]['item']; ?>
                          </li>
                          <?php
                          // if ($l == sizeof($j['item_id']) - 1){
                          //   $result  = $result . ;
                          // } else {
                          //   $result  = $result . $j['item_id'][$l]['item'] . ",";
                          // }
                        }
                        // echo $result = $result . "}";
                        ?>
                    </ul>
                  </td>
                  <td><?php echo $j['count'] ?></td>
                  <td><?php echo $j['support'] . '%'; ?></td>
                </tr>
                <?php
              }
            }
          ?>
        </tbody>
        <tfoot>
            <tr>
              <th>Item</th>
              <th>Support Count</th>
              <th>Support</th>
            </tr>
        </tfoot>
    </table>
	</div>
  <div class="row">
    <h3 style="text-align: center; width: 100%; margin-bottom: 50px; margin-top: 50px;">Confidence</h3>
    <table id="example2" class="table table-striped table-bordered" style="width:100%">
          <thead>
              <tr>
                  <th>Item</th>
                  <th>Support</th>
                  <th>Confidence</th>
              </tr>
          </thead>
          <tbody>
            <?php
              foreach ($resultSupport as $i) {
                # code...
                foreach ($i as $j) {
                  # code...
                  ?>
                  <tr>
                    <td>
                      <ul>
                        <?php
                        // $result = "{";
                          for ($l=0; $l < sizeof($j['item_id']); $l++) {
                            # code...
                            ?>
                            <li>
                              <?php echo $j['item_id'][$l]['item']; ?>
                            </li>
                            <?php
                            // if ($l == sizeof($j['item_id']) - 1){
                            //   $result  = $result . ;
                            // } else {
                            //   $result  = $result . $j['item_id'][$l]['item'] . ",";
                            // }
                          }
                          // echo $result = $result . "}";
                          ?>
                      </ul>
                    </td>
                    <td><?php echo $j['count'] * 10 ?></td>
                    <td><?php echo $j['support'] * 10 . '%'; ?></td>
                  </tr>
                  <?php
                }
              }
            ?>
          </tbody>
          <tfoot>
              <tr>
                <th>Item</th>
                <th>Support</th>
                <th>Confidence</th>
              </tr>
          </tfoot>
      </table>
  </div>
</div>
  </body>
</html>
