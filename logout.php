<html>
    <head>
        <title>Log Out</title>
        <script type="text/javascript" src="js/check.js"></script>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Delete your diary">
        <meta name="author" content="Wentao Shi">
    </head>
<body>

  <?php
    include("connect.php");
    include("functions/alert.php");

    $uname= $_GET['uname'];
    if (isset($_COOKIE['admin'])) {
        $admin = $_COOKIE['admin'];
    } else {
        $admin = "";
    }
    if ($admin == NULL || $admin != $uname) {
      setAlert("Please log in.");
      echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
      die;
    } else {
        setcookie("admin", NULL, time()-3600);
        echo setSuccessAlert("You have been successfully logged out. Good Bye!");
        //header("location: login.php?");
    }


    

?>

<div class="text-center">

<a href="login.php?" class="btn btn-success btn-lg" role="button">Go Log in!</a>
</div>