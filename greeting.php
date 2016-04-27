<html>
  <?php
    include("connect.php");
    include("functions/alert.php");

    $host= $_GET['host'];
    
    if (isset($_COOKIE['admin'])) {
        $admin = $_COOKIE['admin'];
        //$visitor == $admin;
    } else {
        $admin = "";
    }
    if (isset($_GET['unread'])) {
        $unread_number = $_GET['unread'];
    } else {
        $unread_number = 0;
    }

    if ($admin == NULL) {
      setAlert("Please log in.");
      echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
      die;
    }
    include("functions/navi_bar.php");

    if ($host == $admin && $unread_number != 0) {
      $sql_read = "UPDATE greeting SET status='read' where username2='{$admin}';";
      if (!pg_query($conn, $sql_read)){
          die(pg_last_error());
      }
      header("location: greeting.php?host={$admin}");
    }


    $sql1="select name, username from users where username = '{$host}';";
    $result1 = pg_query($conn, $sql1);
    $arr1 = pg_fetch_array($result1, NULL, PGSQL_BOTH);
    $host_name = $arr1['name'];

?>
    <head>
        <title>View <?php echo $host_name; ?>'s Greeting</title>
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
<h2>View <?php echo $host_name; ?>'s Greeting:<h2><hr>

</div>


<!-Greetings display->

<?php
    $sql2="select * from greeting where username2 = '{$host}';";
    $result2 = pg_query($conn, $sql2);
    $allgreeting = pg_fetch_all($result2);
    $gre_arr = pg_fetch_array($result2, NULL, PGSQL_BOTH);
    if ($gre_arr == NULL) {
      echo setAlert("No greeting.");
    } else {
      ?>
      <div class="panel panel-info">
       <div class="panel-heading">
          <h1 class="panel-title">Greeting:</h1>
       </div>
       <ul class="list-group">
       <?php 
          for ($i = 1; $i <= count($allgreeting); $i++) {
            $arri = pg_fetch_array($result2, $i - 1, PGSQL_BOTH);
            $datei = substr($arri['gre_time'], 0, 16);
            $contenti=$arri['gre_text'];
            $sender=$arri['username'];

            $sql3="select name, username from users where username = '{$sender}';";
            $result3 = pg_query($conn, $sql3);
            $arr3 = pg_fetch_array($result3, NULL, PGSQL_BOTH);
            $sender_name = $arr3['name'];
            ?>
            <li class="list-group-item"><strong> <a href="visithome.php?uname=<?php echo $sender; ?>"><?php echo $sender_name; ?></a> (username: <?php echo $sender; ?>) </strong>&nbsp;&nbsp;&nbsp;Said At <?php echo $datei; ?><br><?php echo $contenti; ?></li>
            <?php
          } // for i
    }
?>
</ul>
</div>
  

<!-Write Comments->
<?php 
if ($host != $admin) {
  ?>  

<div>
<form action="up_greeting.php" method="post" class="form-register">
<input type="hidden" name="host" value= <?php echo $host; ?> >
<input type="hidden" name="sender" value= <?php echo $admin; ?> >
<table>
        <tr><h4>Write a greeting to <?php echo $host; ?>:</h4></tr>
        <tr>
            <td>
                <textarea name="content" rows="3" cols="50"></textarea>
            </td><td>&nbsp;</td>
            <td><input type="submit" value="Send greeting" name="submit" class="btn btn-md btn-warning btn-block"></td>
        </tr>
</table>
</form>
</div>

<?php
} else {

}


  ?>

</div>

  <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
</body>
    </html>