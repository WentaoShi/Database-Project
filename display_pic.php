<html>
  <?php
    include("connect.php");
    include("functions/alert.php");
    
    $mid = $_GET['mid'];
    $uname= $_GET['uname'];
    if (isset($_GET['type']) and $_GET['type'] == 'feeds'){
      // ready to display photos directed from newfeeds.php
    } else{
      $file_name = $_GET['file'];
    }
    if (isset($_COOKIE['admin'])) {
        $admin = $_COOKIE['admin'];
    } else {
        $admin = "";
    }

    if ($admin == NULL) {
      setAlert("Please log in.");
      echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
      die;
    }
    include("functions/navi_bar.php");

    $sql="select * from media where mid = '{$mid}';";
    $result = pg_query($conn, $sql);
    $arr = pg_fetch_array($result, NULL, PGSQL_BOTH);
    $title = $arr['title'];
    $body = $arr['des_text'];
    $date = substr($arr['media_time'], 0, 16);
    $visib = $arr['visib'];
    switch ($visib) {
      case 'f':
        $visib = "My Friends";
        break;
      case 'fof':
        $visib = "Friends of My Friends";
        break;
      case 'all':
        $visib = "Whole World";
        break;
      default:
        $visib = "Whole World";
        break;
    }

    $sql1="select name, username from users where username = (select username from post_m where mid = '{$mid}');";


    $result1 = pg_query($conn, $sql1);
    $arr1 = pg_fetch_array($result1, NULL, PGSQL_BOTH);
    $name = $arr1['name'];
    $author = $arr1['username'];

    if (isset($_GET['type']) and $_GET['type'] == 'feeds'){
      $sql = "select * from media where mid='{$mid}'";
      $res = pg_query($conn, $sql);
      $tup = pg_fetch_array($res, NULL, PGSQL_BOTH);
      $photo_dbObj = $tup['photo'];
      $photo_data = pg_unescape_bytea($photo_dbObj);
      $file_name = "tmp/feeds_{$admin}_active.jpg";
      $photo_handle = fopen($file_name, 'wb');
      fwrite($photo_handle, $photo_data);
    }


?>
    <head>
        <title>Photo <?php echo $title; ?> by <?php echo $name; ?></title>
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
<h2>View photo:<h2><hr>

</div>

    <div class='col-md-12'>&nbsp;
      <div class='thumbnail'>
        <div class='caption text-center'>
        <img src='<?php echo $file_name; ?>' class='img-thumbnail' alt='<?php echo $title; ?>'>

          <h3><?php echo $title; ?></h3>
          <a href='<?php echo $file_name; ?>' class="btn btn-success btn-sm" role="button">View Original</a>

<?php
if ($author == $admin) {
  ?>

<div class="btn-group">
  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Change visibility
  </button>
  <div class="dropdown-menu">
    <li><a href="up_change.php?visib=f&uname=<?php echo $admin; ?>&mid=<?php echo $mid; ?>&file=<?php echo $file_name; ?>">Friends</a></li>
    <li><a href="up_change.php?visib=fof&uname=<?php echo $admin; ?>&mid=<?php echo $mid; ?>&file=<?php echo $file_name; ?>">Friends of My Friends</a></li>
    <li><a href="up_change.php?visib=all&uname=<?php echo $admin; ?>&mid=<?php echo $mid; ?>&file=<?php echo $file_name; ?>">Whole World</a></li>
  </div>
</div><br>
<em>Visible to: <?php echo $visib; ?></em>

  <?php
}

?>

          <h5>by:&nbsp;<strong><a href="visithome.php?uname=<?php echo $author; ?>"><?php echo $name; ?></a></strong></h5>
          At:&nbsp;<?php echo $date; ?><hr>
          <?php echo $body; ?>
          <br>
        </div>
      </div>
    </div>

<!-Comments display->

<?php
    $sql2="select * from comment where mid = '{$mid}' order by com_time desc;";
    $result2 = pg_query($conn, $sql2);
    $allcomment = pg_fetch_all($result2);
    $com_arr = pg_fetch_array($result2, NULL, PGSQL_BOTH);
    if ($com_arr == NULL) {
      echo "<strong>This photo has no comment. You can write one!</strong>";
    } else {
      ?>
      <div class="panel panel-success">
       <div class="panel-heading">
          <h1 class="panel-title">Comments:</h1>
       </div>
       <ul class="list-group">
       <?php 
          for ($i = 1; $i <= count($allcomment); $i++) {
            $arri = pg_fetch_array($result2, $i - 1, PGSQL_BOTH);
            $datei = substr($arri['com_time'], 0, 16);
            $cidi=$arri['cid'];
            $contenti=$arri['content'];
            $sql3="select * from send where cid = '{$cidi}';";
            $result3 = pg_query($conn, $sql3);
            $send_row = pg_fetch_array($result3, 0, PGSQL_BOTH);
            $sender = $send_row['username'];
            $sql4="select name from users where username = '{$sender}';";
            $result4 = pg_query($conn, $sql4);
            $name_row = pg_fetch_array($result4, 0, PGSQL_BOTH);
            $sender_name = $name_row['name'];
            ?>
            <li class="list-group-item"><strong> <a href="visithome.php?uname=<?php echo $sender; ?>"><?php echo $sender_name; ?></a> (username: <?php echo $sender; ?>) </strong>&nbsp;&nbsp;&nbsp;Said At <?php echo $datei; ?><br><?php echo $contenti; ?></li>
            <?php
          } // for i
    }
?>
</ul>
</div>
  

<!-Write Comments->
<div class="text-center">
<form action="up_comment.php" method="post" class="form-register">
<input type="hidden" name="uname" value= <?php echo $uname; ?> >
<input type="hidden" name="comment_sender" value= <?php echo $admin; ?> >
<input type="hidden" name="mid" value= <?php echo $mid; ?> >
<input type="hidden" name="file" value= <?php echo $file_name; ?> >
<input type="hidden" name="type" value='media' >
<table>
        <tr>
            <td>Write a comment:</td>
            <td>
                <textarea name="content" rows="2" cols="40"></textarea>
            </td><td>&nbsp;</td>
            <td><input type="submit" value="Post comment" name="submit" class="btn btn-md btn-warning btn-block"></td>
        </tr>
</table>
</form>
</div>


<div class="text-center">
<form action='delete_d.php' method="get" class="form-register">
  <a href="home.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>
  
  <?php 

    if ($admin == NULL || $admin != $author) {

    } else { ?>
    <input type="hidden" name="uname" value= <?php echo $author; ?> >
    <input type="hidden" name="mid" value= <?php echo $mid; ?> >
    <input type="submit" value="Delete This Photo" name="submit" class="btn btn-lg btn-danger">
  <?php } ?>
</form>

</div>

</div>
  <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
</body>
    </html>