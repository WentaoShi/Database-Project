<html>
    <head>
        <title>Delete your photo</title>
        <script type="text/javascript" src="js/check.js"></script>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Delete your photo">
        <meta name="author" content="Wentao Shi">
    </head>
<body>

  <?php
    include("connect.php");
    include("functions/alert.php");

    $uname= $_GET['uname'];
    $mid = $_GET['mid'];

    $sql="delete from post_m where mid = '{$mid}' and username = '{$uname}';";
    $result = pg_query($conn, $sql);


    $sql1="delete from media where mid = '{$mid}';";

    $result1 = pg_query($conn, $sql1) or die;

    echo setSuccessAlert("This photo has been deleted.");

?>

<div class="text-center">

<a href="home.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>
<a href="gallery.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg" role="button">Go to your gallery</a>

</div>