<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Your Gallery</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/thumbnail-gallery.css" rel="stylesheet">
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
    }


foreach (glob("tmp/gall_{$uname}_*.jpg") as $filename) {
    $fn = rtrim($filename,".jpg");
    unlink($filename);
}




?>

</head>

<body>
    <!-- Page Content -->
    <div class="container">

        <div class="row">
                <h1>Your Gallery</h1>
            <hr>
            <?php
            include("functions/readpic.php");
?>

        </div >
        <div class='text-center'>
        <form action='choose_photo.php' method="get" class="form-register">
        <input type="hidden" name="uname" value= <?php echo $uname; ?> >
        <input type="submit" value="Upload a Photo!" name="submit" class="btn btn-lg btn-danger form-next">
      
        <a href='home.php?uname=<?php echo $uname; ?>' class='btn btn-success btn-lg' role='button'>Go Back home!</a>
        <hr></div></form>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; built by Wentao Shi, Yun Yan and Liang Shan</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
