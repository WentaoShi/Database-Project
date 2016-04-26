<html>
  <head>
    <title>Make Friends</title>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">

  </head>

  <body>
    <?php
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


    ?>
    <div class="container form-center" >
        <form class="form-signin" method="post" action="friend_request_do.php">
        <h2 class="form-signin-heading">Input the user name of your friend:</h2><br>
        <label for="inputuname" class="sr-only">User Name: </label>
        <input type="text" id="fname" name="fname" class="form-control" placeholder="User Name" required autofocus>
        <input type="hidden" id="uname" name="uname" value= <?php echo $uname; ?>>
        <br>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Request</button>
        <a href="home.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg btn-block" role="button">Go Back home!</a>
        </form>

        
    </div>
  </div>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>