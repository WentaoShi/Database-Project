<html>
  <head>
    <title>Homepage</title>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/mycss.css" rel="stylesheet" />
  </head>

  <body>
  <?php
    include("connect.php");


    $dir = "images";
    $uname= $_GET['uname'];

    $sql="SELECT * FROM users WHERE username='{$uname}'";  
    $result= pg_query($conn, $sql);
    $row = pg_fetch_array($result);

    ?>
    <div class="container">
    <h1>
        <span style="color:orange">Welcome <?php echo $row['name'] ?>! This is your home page!</span>
    </h1>
    <hr>
    
    <div class="col-md-5">


    

<table>
  <tr>
    <td>
      <?php
        include("functions/storePicToTmp.php");
      ?>
      <?php
        include("connect.php");
        $sql="SELECT user_photo FROM users WHERE username='{$uname}';";  
        $picresult= pg_query($conn, $sql);
        $resultarray = pg_fetch_array($picresult, NULL, PGSQL_BOTH);
        if($resultarray['user_photo'] != NULL) {
          echo "<img src='profile_pic/{$uname}_profile.jpg' class='img-thumbnail' alt='Your Profile' width='300'>";
        } else {
          echo "<img src='images/default-profile.jpg' class='img-thumbnail' alt='Your Profile' width='300'>";
        }

       ?>
      
    </td>
  </tr>
<form action="photo_up_process.php" method="post" enctype="multipart/form-data" class="form-register">

  <tr><td>
      <?php 
        if($resultarray['user_photo'] != NULL) {
          echo "<p><h5><span class='cap'>Change your profile photo!</h5></span></td>";
        } else {
          echo "<p><h5><span class='cap'>Upload your profile photo!</h5></span></td>";
        }

       ?>
      
    </tr>
    <tr><td>
      <input type="file" name="fileToUpload" id="fileToUpload" class="form-control"></td><td>
      <input type="hidden" name="uname" value= <?php echo $uname; ?> >
      <input type="submit" value="Upload Image" name="submit" class="btn btn-sm btn-primary btn-block form-next"></td>
    </tr><p>


    <tr>
        <td colspan="2">
            <small><em> * We accept <span style="color:blue">GIF</span>, <span style="color:blue">JPG/JPEG</span> and <span style="color:blue">PNG</span> as image formats.<br>* Please note this photo can be seen by anyone.</em></small>
        </td>
    </tr>
</table>

</form>

    <h1>
      <span class="cap">Personal Information:</span>
    </h1>
    <form  class="form-register">
      <table class="table table-hover">
        <tr>
          <td>
            <em>User Name:</em>
          </td>
          <td>
            <?php echo $row['username'] ?>
          </td>
        </tr>
        <tr>
          <td>
            <em>Name:</em>
          </td>
          <td>
            <?php echo $row['name'] ?>
          </td>
        </tr>
        <tr>
          <td>
            <em>Birthday:</em>
          </td>
          <td>
            <?php echo $row['birthday'] ?>
          </td>
        </tr>
        <tr>
          <td>
            <em>City:</em>
          </td>
          <td>
            <?php echo $row['city'] ?>
          </td>
        </tr>
      </table>
    </form>
    </div>


    <hr>


         <hr class="hr2"></hr>
        <div id="footer">
            <p>&copy; built by Wentao Shi, Yun Yan and Liang Shan</p>
        </div>
    </div>
  </body>
</html>
