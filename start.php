<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Start Apriori</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
body{
  width:960px;
  margin:45px auto;
  background: linear-gradient(87deg, #FF416C 0, #FF4B2B 100%) !important;

}
form{
  width:330px;
  border-top:1px dotted #D9D9D9;
  margin:10px auto
}
input[type="button"]{
  width: 35px;
}
button{
  width:246px;
  height:40px;
  color:#FF416C;
  margin-bottom:20px;
  margin-left:20px;
}
input{
  width:250px;
  padding:5px;
  margin:10px 0 10px;
  border-radius:5px;
  border:4px solid #acbfa5
}
input[type = submit]{
  width:100px;
  background-color:#FF416C;
  border-radius:5px;
  border:2px solid #FF4B2B;
  color:#fff
}
h4{
  color:#4C4C4C;
  text-align:center
}
.container{
  text-align:center;
  width:50%;
  border-left:1px solid #D0D0D0;
  background-color:#fff;
  padding-top:40px;
  padding-bottom:40px;
  border-radius:5px;
  margin: 0 auto;
}
</style>
  </head>
  <body>
    <div class="container">
<form action="./result.php" method="post">
    <h4>Support Threshold(2 - etc)</h4>
    <input type="number" id="support" required name="support" placeholder="2 - etc" />
    <h4 style="margin-top: 20px">Confidence Threshold (%)</h4>
    <input type="number" id="confidence" required name="confidence" placeholder="0 - 100%" />
    <input type="submit" value="Submit">
</form>
</div>
  </body>
</html>
