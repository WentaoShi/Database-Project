<html>
    <head>
        <title>Delete your friends</title>
        <script type="text/javascript" src="js/check.js"></script>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
    </head>
<body>

  <?php
    include("connect.php");
    include("functions/alert.php");

    $uname= $_GET['username'];
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
    $fname = $_GET['username2'];

    $sql = "delete from friend
            where ((username='{$uname}' and username2='{$fname}')
                or (username='{$fname}' and username2='{$uname}'))
                and status = 'accepted'";
    $res = pg_query($conn, $sql);

    if ($res){
      setSuccessAlert("User '{$fname}' has been deleted from your friend lists.");
    } else {
      setAlert("None friends exists");
    }



?>

<div class="text-center">

<a href="home.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>

</div>