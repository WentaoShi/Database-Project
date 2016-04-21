<html>
    <head>
        <title>Delete your diary</title>
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
    $did = $_GET['did'];

    $sql="delete from post_d where did = '{$did}' and username = '{$uname}';";
    $result = pg_query($conn, $sql);


    $sql1="delete from diary where did = '{$did}';";

    $result1 = pg_query($conn, $sql1) or die;

    echo setSuccessAlert("This diary has been deleted.");

?>

<div class="text-center">

<a href="home.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>
<a href="diary_list.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg" role="button">Go to your diary list</a>

</div>