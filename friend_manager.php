<html>
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

    if ($admin == NULL) {
      echo setAlert("Please log in.");
      echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
      die;
    }

    include("functions/navi_bar.php");

  ?>
  <head>
    <title><?php echo $name; ?>'s Friends</title>
    <script type="text/javascript" src="js/check.js"></script>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
    <meta charset="utf-8">
  </head>
<body>
<div class="form-register">
  <!-- Does user have any friends? -->
  <?php
  // pgsql procedure: FetchFriendTable
  $procedure = file_get_contents('./functions/fetch_friendList.sql');
  $result = pg_query($conn, $procedure);
  $sql = "select * from FetchFriendTable('{$uname}');";
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
  <h4>Hi, <?php echo $uname?>, your friends are listed: </h4>
  <table class="table table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>Username</th>
      <th>Friendship Time (min)</th>
      <th>Option</th>
    </tr>
  </thead>
  <tbody>
  
  <?php 
    date_default_timezone_set('America/New_York');
    for ($i = 1; $i <= count($friends); $i++) {
      $arri = pg_fetch_array($result, $i - 1, PGSQL_BOTH);
      $friendi = $arri['direct_friend'];
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
          <a href='visithome.php?uname={$friendi}' class='btn btn-info btn-xs' role='button'>View Homepage</a>
          ";
            if ($admin == NULL || $admin != $uname) {

            } else {
              echo "<a href='friend_delete.php?username={$uname}&username2={$friendi}' class='btn btn-danger btn-xs' role='button'>Delete</a>";
            }
            

          "</td>
        </tr>
      ";
    }
 ?>
  </tbody>
</table>
</div>

  <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>