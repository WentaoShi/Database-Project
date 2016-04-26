<html>

<head>
<title>Feeds:</title>
<script type="text/javascript" src="js/check.js"></script>
<link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="css/register.css" rel="stylesheet">
<meta charset="utf-8">
</head>

  <?php
    include("connect.php");
    include("functions/alert.php");
    if (isset($_GET['uname'])){
    $uname= $_GET['uname'];
    } else {
      die(setAlert("Please Log in."));
    }
    if (!$uname){
      setAlert("Please log in.");
      echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
      die();
    }
    $sql1="select name from users where username = '{$uname}';";
    $result1 = pg_query($conn, $sql1);
    $arr1 = pg_fetch_array($result1, NULL, PGSQL_BOTH);
    $name = $arr1['name'];
    $admin = $_COOKIE['admin'];
    if ($admin == NULL || $admin != $uname) {
      setAlert("Please log in.");
      echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
      die();
    }

  ?>

<body>

<!-- List all feeds of friends + FoF of user -->
<div class="container-fluid">
<div class="row clearfix">
<div class="col-md-12 column">
  <!-- Does user have any friends? If not, there is nothing to show at all -->
  <?php
  // pgsql procedure: FetchFriendNameList
  $procedure = file_get_contents('./functions/fetch_friendList.sql');
  $result = pg_query($conn, $procedure);
  $sql = "select * from FetchFriendNameList('{$uname}');";
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

<!-- Find all reached persons feeds -->
  <?php
    $sql2 = file_get_contents('./functions/fetch_friendList.sql', true);
    $sql3 = file_get_contents('./functions/fetch_FofList.sql', true);
    $sql4 = file_get_contents('./functions/fetch_reachedPersonNames.sql', true);
    pg_query($conn, $sql2);
    pg_query($conn, $sql3);
    pg_query($conn, $sql4);
    $sql_feedsDiary = file_get_contents('./functions/fetch_feeds.sql', true);
    pg_query($conn, $sql_feedsDiary); // procedure: FetchFeedsXXXX4Me

    $sql_reachedPerson_diary = "select * from FetchFeedsDiary4Me('{$uname}')";
    $query_reachedPersonDiaries = pg_query($conn, $sql_reachedPerson_diary);
    $reachedPersonDiaries = pg_fetch_all($query_reachedPersonDiaries);

    $sql_reachedPerson_media = "select * from FetchFeedsMedia4Me('{$uname}')";
    $query_reachedPersonMedia = pg_query($conn, $sql_reachedPerson_media);
    $reachedPersonMedia = pg_fetch_all($query_reachedPersonMedia);
  ?>
<hr>

<div class="col-md-6 column">
<h2>New Diaries:</h2>

<table class="table table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>Title</th>
      <th>Author</th>
      <th>Date</th>
      <th>Option</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    if (pg_num_rows($query_reachedPersonDiaries) < 0){
      setAlert("No Feeds available for you.");
    } else {

      for ($i = 0; $i < pg_num_rows($query_reachedPersonDiaries); $i++) {
        $arri = pg_fetch_array($query_reachedPersonDiaries, $i, PGSQL_BOTH);
        $titlei = $arri['title'];
        $datei = substr($arri['diary_time'], 0, 16);
        $didi=$arri['did'];
        $personi = $arri['username'];
        $index = $i + 1;
        echo "
          <tr>
            <th scope='row'>{$index}</th>
            <td>{$titlei}</td>
            <td>{$personi}</td>
            <td>{$datei}</td>
            <td>
              <a href='display_diary.php?uname={$personi}&did={$didi}' class='btn btn-info btn-xs' role='button'>&nbsp;View&nbsp;</a>
              ";
              if ($admin == NULL || $admin != $personi) {

              } else {
                echo 
              "<a href='delete_d.php?uname={$personi}&did={$didi}' class='btn btn-danger btn-xs' role='button'>Delete</a>";
              }
            echo "</td>
          </tr>
        ";
      }
    }

   ?>
  </tbody>
</table>
</div> <!-- col-lg-6 of diaries ends here -->


<div class="col-md-6 column">
<h2>New Media:</h2>


  <?php 
    if (pg_num_rows($query_reachedPersonMedia) < 0){
      setAlert("No Feeds available for you.");
    } else {
    echo "<table class='table table-hover'>
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Author</th>
          <th>Date</th>
          <th>Option</th>
        </tr>
      </thead>
      <tbody>";
      for ($i = 0; $i < pg_num_rows($query_reachedPersonMedia); $i++) {
        $arri = pg_fetch_array($query_reachedPersonMedia, $i, PGSQL_BOTH);
        $titlei = $arri['title'];
        $datei = substr($arri['media_time'], 0, 16);
        $midi=$arri['mid'];
        $personi = $arri['username'];
        $index = $i + 1;
        echo "
          <tr>
            <th scope='row'>{$index}</th>
            <td>{$titlei}</td>
            <td>{$personi}</td>
            <td>{$datei}</td>
            <td>
              <a href='display_pic.php?uname={$personi}&did={$midi}' class='btn btn-info btn-xs' role='button'>&nbsp;View&nbsp;</a>
              ";
              if ($admin == NULL || $admin != $personi) {

              } else {
                echo 
              "<a href='delete_d.php?uname={$personi}&did={$midi}' class='btn btn-danger btn-xs' role='button'>Delete</a>";
              }
            echo "</td>
          </tr>
        ";
      }
    }

   ?>
  </tbody>
</table>

</div>


</div> <!-- col-lg-12 ends here -->
</div> <!-- row ends here -->
</div> <!-- container ends here -->
</body>

</html>

