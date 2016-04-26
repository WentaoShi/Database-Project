<!DOCTYPE html>
<html lang="en">

<head>

<?php
include("connect.php");
include("functions/alert.php");
$uname= $_GET['uname'];
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


foreach (glob("tmp/gall_{$uname}_*.jpg") as $filename) {
    $fn = rtrim($filename,".jpg");
    unlink($filename);
}
?>
<?php if ($admin == $uname) {
    ?>
    <title>Your Gallery</title>
 <?php
} else {?>
    <title><?php echo $uname; ?>'s Gallery</title>

 <?php
} ?>

    <script type="text/javascript" src="js/dropdown.js"></script>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/mycss.css" rel="stylesheet" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A home page of the website.">
    <meta name="author" content="Wentao Shi">


</head>

<body>
<?php include("functions/navi_bar.php"); ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php if ($admin == $uname) {
                ?>
                <h1>Your Gallery</h1>
             <?php
            } else {?>
                <h1><?php echo $uname; ?>'s Gallery</h1>

             <?php
            } ?>
            <hr>
            <?php
            include("functions/readpic.php");
?>

        </div >

<?php if ($admin == $uname) {
    ?>

        <div class='text-center'>
        <form action='choose_photo.php' method="get" class="form-register">
        <input type="hidden" name="uname" value= <?php echo $uname; ?> >
        <input type="submit" value="Upload a Photo!" name="submit" class="btn btn-lg btn-danger form-next">
      
        <a href='home.php?uname=<?php echo $uname; ?>' class='btn btn-success btn-lg' role='button'>Go Back home!</a>
        <hr></div></form>
 <?php
} else {?>
        <div class='text-center'>
        <button type='button' class='btn btn-info btn-lg' onClick='history.go(-1);return true;'>Go Back</button></div>
 <?php
} ?>



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
  <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>

      <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
