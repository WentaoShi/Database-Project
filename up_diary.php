<html>
    <head>
        <title>Preview your uploaded diary</title>
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
  <?php
    include("connect.php");
    include("functions/alert.php");

    $uname= $_POST['uname'];
    if (isset($_COOKIE['admin'])) {
        $admin = $_COOKIE['admin'];
    } else {
        $admin = "";
    }
    if ($admin == NULL || $admin != $uname) {
      setAlert("Please log in.");
      echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
      die;
    }
    
    $title= $_POST['title'];
    $content= $_POST['content'];
    $visib= $_POST['visib'];
    $did = uniqid();
    $encode_title = htmlspecialchars($title, ENT_QUOTES);
    $encode_body = htmlspecialchars($content, ENT_QUOTES);

    $sql1 = "INSERT INTO diary VALUES ('{$did}','{$encode_title}', '{$encode_body}', current_timestamp, '{$visib}');";

    if (!pg_query($conn, $sql1)){
       die(pg_last_error());
    }
    $sql2 = "INSERT INTO post_d VALUES ('{$uname}','{$did}');";
    if (!pg_query($conn, $sql2)){
       die(pg_last_error());
    } else {
      echo setSuccessAlert("Great! You diary has been posted!");
    }

?>


<div class="form-register">
<div>
<h2>Preview your uploaded diary:<h2><hr>

</div>

<div class="panel panel-success">
   <div class="panel-heading">
      <h1 class="panel-title"><?php echo $title; ?></h1>
   </div>
   <ul class="list-group">
      <li class="list-group-item">Written by <strong> <?php echo $uname; ?> </strong><br>
      At <?php date_default_timezone_set('America/New_York');echo date("Y-m-d  h:m") ?></li>
      <li class="list-group-item"><?php echo $content; ?></li>

   </ul>
</div>

<a href="home.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>


</div>
</body>
    </html>