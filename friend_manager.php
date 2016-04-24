<html>
  <?php
    include("connect.php");
    include("functions/alert.php");

    $uname= $_POST['uname'];
    $sql1="select name from users where username = '{$uname}';";
    $result1 = pg_query($conn, $sql1);
    $arr1 = pg_fetch_array($result1, NULL, PGSQL_BOTH);
    $name = $arr1['name'];

  ?>
  <head>
    <title><?php echo $name; ?>'s Friends Requests:</title>
    <script type="text/javascript" src="js/check.js"></script>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
    <meta charset="utf-8">
  </head>
<body>
<div class="form-register">
  <!-- Does user have any friends? -->
  <?php

  $sql = "select * from friend
          where username = '{$uname}' and status in ('accepted', 'pending');";
  $result = pg_query($conn, $sql);
  $friends_num = pg_num_rows($result);
  if ($friends_num == 0){
    setAlert("No friends yet... How about add new friends?");
  ?>
  <div>
    <form action='friend_request.php' method="post" class="form-center">
    <input type="hidden" name="uname" value= <?php echo $uname; ?> >
    <input type="submit" value="Add Friends" name="submit" class="btn btn-primary btn-danger form-next">
    </form>
  </div>
  <?php
  die();
  }?>


  <!--  Friends List & See/Delete Friends -->
  <?php
    $friends = pg_fetch_all($result);
  ?>
  <table class="table table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>Username</th>
      <th>Time (min)</th>
      <th>Option</th>
    </tr>
  </thead>
  <tbody>
  
  <?php 
    date_default_timezone_set('America/New_York');
    for ($i = 1; $i <= count($friends); $i++) {
      $arri = pg_fetch_array($result, $i - 1, PGSQL_BOTH);
      $friendi = $arri['username2'];
      $datei = substr($arri['res_time'], 0, 16);
      $timei = strtotime($datei);
      $timen = time();
      $duration = round(abs($timen - $timei)/60, 2);

      echo "
        <tr>
          <th scope='row'>{$i}</th>
          <td>{$friendi}</td>
          <td>{$duration}</td>
          <td>
            <a href='friend_delete.php?username={$uname}&username2={$friendi}' class='btn btn-danger btn-xs' role='button'>Delete</a>
          </td>
        </tr>
      ";
    }
 ?>
  </tbody>
</table>
</div>
</body>
</html>