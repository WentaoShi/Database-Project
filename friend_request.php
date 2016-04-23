<html>
  <head>
    <title>Make Friends</title>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">

  </head>

  <body>
    <?php
      $uname= $_POST['uname'];
    ?>
    <div class="container form-center" >
        <form class="form-signin" method="post" action="friend_request_do.php">
        <h2 class="form-signin-heading">Input the user name of your friend:</h2><br>
        <label for="inputuname" class="sr-only">User Name: </label>
        <input type="text" id="fname" name="fname" class="form-control" placeholder="User Name" required autofocus>
        <input type="hidden" id="uname" name="uname" value= <?php echo $uname; ?>>
        <br>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Request</button>
        </form>
        
    </div>




  </div>
  </body>
</html>