<html>
  <?php
    include("connect.php");

    $uname= $_GET['uname'];
    $did = $_GET['did'];

    $sql="select * from diary where did = '{$did}';";
    $result = pg_query($conn, $sql);
    $arr = pg_fetch_array($result, NULL, PGSQL_BOTH);
    $title = $arr['title'];
    $body = $arr['body'];
    $date = substr($arr['diary_time'], 0, 16);

    $sql1="select name from users where username = (select username from post_d where did = '{$did}');";


    $result1 = pg_query($conn, $sql1);
    $arr1 = pg_fetch_array($result1, NULL, PGSQL_BOTH);
    $name = $arr1['name'];

?>
    <head>
        <title><?php echo $title; ?> by <?php echo $name; ?></title>
        <script type="text/javascript" src="js/check.js"></script>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Write a diary.">
        <meta name="author" content="Wentao Shi">
    </head>
<body>



<div class="form-register">
<div>
<h2>View diary:<h2><hr>

</div>

    <div class='col-md-12'>
      <div class='thumbnail'>
        <div class='caption'>
          <h3><?php echo $title; ?></h3><hr>
          <h5>Written by:&nbsp;<strong><?php echo $name; ?></strong></h5>
          At:&nbsp;<?php echo $date; ?><hr>
          <p><?php echo $body; ?></p>
          <br>
        </div>
      </div>
    </div>



<div class="text-center">
<form action='delete_d.php' method="get" class="form-register">
  <a href="home.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>
  <input type="hidden" name="uname" value= <?php echo $uname; ?> >
  <input type="hidden" name="did" value= <?php echo $did; ?> >
  <input type="submit" value="Delete it" name="submit" class="btn btn-lg btn-danger">
</form>
</div>

</div>
</body>
    </html>