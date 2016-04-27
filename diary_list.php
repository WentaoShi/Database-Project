<html>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
  <?php
    include("connect.php");
    include("functions/alert.php");

    $uname= $_GET['uname'];
    $sql1="select name from users where username = '{$uname}';";
    $result1 = pg_query($conn, $sql1);
    $arr1 = pg_fetch_array($result1, NULL, PGSQL_BOTH);
    $name = $arr1['name'];
    if (isset($_COOKIE['admin'])) {
        $admin = $_COOKIE['admin'];
    } else {
        $admin = "";
    }
    include("functions/navi_bar.php");
  ?>
    <head>
        <title><?php echo $name; ?>'s Diary List</title>
        <script type="text/javascript" src="js/check.js"></script>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="diary list.">
        <meta name="author" content="Wentao Shi">
    </head>
<body>

  <?php
    $sql="select * from diary where did in (select did from post_d where username = '{$uname}');";
    $result = pg_query($conn, $sql);
    $alldiary=pg_fetch_all($result);
    $arr = pg_fetch_array($result, NULL, PGSQL_BOTH);
    if ($arr == NULL) {
      die(setAlertWithBackButton("Sorry. This user don't have diaries.", "Go Back"));
    }



?>




<div class="form-register">
<div>
<h2>View diary:</h2><hr>

</div>
<table class="table table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>Title</th>
      <th>Date</th>
      <th>Option</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    for ($i = 1; $i <= count($alldiary); $i++) {
      $arri = pg_fetch_array($result, $i - 1, PGSQL_BOTH);
      $titlei = $arri['title'];
      $datei = substr($arri['diary_time'], 0, 16);
      $didi=$arri['did'];
      echo "
        <tr>
          <th scope='row'>{$i}</th>
          <td>{$titlei}</td>
          <td>{$datei}</td>
          <td>
            <a href='display_diary.php?uname={$uname}&did={$didi}' class='btn btn-info btn-xs' role='button'>&nbsp;View&nbsp;</a>";
            if ($admin == NULL || $admin != $uname) {

            } else {
              echo 
            "<a href='delete_d.php?uname={$uname}&did={$didi}' class='btn btn-danger btn-xs' role='button'>Delete</a>";}
          echo "</td>
        </tr>
      ";
    }

   ?>
    

  </tbody>
</table>

<div class="text-center">
  <a href="home.php?uname=<?php echo $admin; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>
</div>

</div>

</body>
    </html>