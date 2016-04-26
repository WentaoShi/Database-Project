<html>
  <head>
    <title>Homepage</title>
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



  <?php
    include("connect.php");
    include("functions/alert.php");
    
    if (isset($_COOKIE['admin'])) {
        $admin = $_COOKIE['admin'];
    } else {
        $admin = "";
    }

    include("functions/navi_bar.php");
    $dir = "images";
    $uname= $_GET['uname'];

    if ($admin == NULL || $admin != $uname) {
      setAlert("Please log in.");
      echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
      die;
    }

    $sql="SELECT * FROM users WHERE username='{$uname}'";  
    $result= pg_query($conn, $sql);
    $row = pg_fetch_array($result);

    ?>
    <div class="container">

    <h1>
    <!--
    <a href="logout.php?uname=<?php echo $uname; ?>" class="btn btn-warning btn-lg pull-right" role="button">Log out</a>
    <a href="newfeeds.php?uname=<?php echo $uname;?>" class="btn btn-primary btn-lg pull-left" role="button">Feeds</a>-->
    &nbsp;
    <span style="color:#FF717E">Welcome, <?php echo $row['name'] ?>! This is your home page!</span>
    </h1>
  
    
      

    <hr class="hr2"></hr>
    
    <div class="col-md-3">


    <?php
        include("functions/storePicToTmp.php");
      ?>
<!-Display Profile Photo->
      <?php
        include("connect.php");
        $sql="SELECT user_photo FROM users WHERE username='{$uname}';";  
        $picresult= pg_query($conn, $sql);
        $resultarray = pg_fetch_array($picresult, NULL, PGSQL_BOTH);
        if($resultarray['user_photo'] != NULL) {
          echo "<img src='profile_pic/{$uname}_profile.jpg' class='img-thumbnail' alt='Your Profile' width='400'>";
        } else {
          echo "<img src='images/default-profile.jpg' class='img-thumbnail' alt='Your Profile' width='400'>";
        }

       ?>

<!-Profile Starts here->
<?php
        $sql_p="SELECT * FROM profile WHERE pid in (select pid from post_p where username = '{$uname}') order by time_stamp desc;"; 

        $pro_result= pg_query($conn, $sql_p);
        $pro_resultarray = pg_fetch_array($pro_result, NULL, PGSQL_BOTH);
        if($pro_resultarray['pid'] != NULL) {
          echo "<h5>{$pro_resultarray['content']}</h5>";
        } else {
          echo setAlert("No profiles here.");
        }

?>
<!-Write a Profile->
<form action="up_profile.php" method="post" class="form-register">
<input type="hidden" name="uname" value= <?php echo $admin; ?> >
<input type="hidden" name="return" value="home" >
<span style="color:#FF717E"><h5>Say somethin' (Your profile):</h5></span>
<textarea name="content" rows="2" cols="33"></textarea>
<input type="submit" value="Post saying" name="submit" class="btn btn-sm btn-warning btn-block">
<a href="profile.php?uname=<?php echo $uname; ?>" class="btn btn-info btn-sm btn-block" role="button">View all your saying</a>
</form>


<!-Upload Profile Photo->
<table>
<form action="photo_up_process.php" method="post" enctype="multipart/form-data" class="form-register">

  <tr><td>
      <?php 
        if($resultarray['user_photo'] != NULL) {
          echo "<p><h5><span style='color:#FF717E'>Change your profile photo!</h5></span></td>";
        } else {
          echo "<p><h5><span style='color:#FF717E'>Upload your profile photo!</h5></span></td>";
        }

       ?>
      
    </tr>
    <tr><td>
      <input type="file" name="fileToUpload" id="fileToUpload" class="form-control"></td><tr><td>
      <input type="hidden" name="uname" value= <?php echo $uname; ?> >
      <input type="hidden" name="type" value="profile">
      <input type="submit" value="Upload Image" name="submit" class="btn btn-sm btn-success btn-block form-next"></td></tr>
    </tr><p>


    <tr>
        <td colspan="2">
            <small><em> * We accept <span style="color:blue">GIF</span>, <span style="color:blue">JPG/JPEG</span> and <span style="color:blue">PNG</span> as image formats.<br>* Please note this photo can be seen by anyone.</em></small>
        </td>
    </tr>
</table>

</form>
<hr class="hr2"></hr>

<!-Friend start here->


<h2>
        <span class="cap">Your Friends:</span>
    </h2>



    <?php

    $sql3="SELECT * from friend where username2='{$uname}' and status='pending'"; 
    $rs3=pg_query($conn,$sql3); 
    $num3=pg_num_rows($rs3);

    if($num3){
                ?>
<form  class="form-register">

        <?php setYellowAlert("You have <strong>{$num3}</strong> friend requests !"); ?>

          <input type="button" class="btn btn-sm btn-warning btn-block" value="Go to process!"
          onclick="window.location.href='friend_process.php?uname=<?php echo $uname; ?>'" />
    </form>
    <?php
    }
    else{ //setYellowAlert("<em>You have no friend request now!</em>");
    
    }
    ?>

    <form action='friend_request.php' method="get" class="form-register">
    <input type="hidden" name="uname" value= <?php echo $uname; ?> >
    <input type="submit" value="Add Friends" name="submit" class="btn btn-primary btn-danger btn-block">
    </form>
    <form action='friend_manager.php' method="get" class="form-register">
    <input type="hidden" name="uname" value= <?php echo $uname; ?> >
    <input type="submit" value="Friends Manager" name="submit" class="btn btn-primary btn-block">
    </form>


        
        <br>
        <hr class="hr2"></hr>
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
            <em>City: </em>
          </td>
          <td>
            <?php echo $row['city'] ?>
          </td>
        </tr>
      </table>
    </form>
    </div>

    <hr>
    <div class="btn-group pull-right" role="group" aria-label="...">
<table><tr><td>
      <form action='write_diary.php' method="get" class="form-register">
        <input type="hidden" name="uname" value= <?php echo $uname; ?> >
        <input type="submit" value="Write a diary!" name="submit" class="btn btn-lg btn-danger form-next">
      </form>

      </td><td>&nbsp;</td><td>
	<form action='diary_list.php' method="get" class="form-register">
        <input type="hidden" name="uname" value= <?php echo $uname; ?> >
        <input type="submit" value="View All Your Diaries!" name="submit" class="btn btn-lg btn-primary form-next">
      </form></td></tr>
</table>
    </div>



    <h1><span class="cap">Your Diaries:</span></h1>
    <hr style="height:1px;border:none;color:#FFFFFF;background-color:#FFFFFF;" />


<!- Thumbnails Starts here->
<?php 
  include("connect.php");
  include("functions/thumbnail.php");
  $sql2="select * from diary where did in (select did from post_d where username = '{$uname}') order by diary_time desc;";  
  $diaryresult= pg_query($conn, $sql2);
  $alldiary=pg_fetch_all($diaryresult);
  $diaryNum=count($alldiary);
  $testarray = pg_fetch_array($diaryresult, NULL, PGSQL_BOTH);

  for ($i = 0; $i <= 2; $i++) {
    if ($diaryNum == 1 && $testarray['did'] == NULL) { 
      echo "<h5>You don't have any diaries. Write one!</h5>";
      break; }


    if ($diaryNum > $i) {
      $diaryresultarray = pg_fetch_array($diaryresult, $i, PGSQL_BOTH);
      $body = $diaryresultarray['body'];
      if (strlen($body) <= 30) {
      	$body .= "<br><br><br>";
      } else if (strlen($body) <= 70) {
      	$body .= "<br><br>";
      }
      $title = ucfirst(strtolower($diaryresultarray['title']));
      $shortTitle = strlen($title) > 14 ? substr($title, 0, 14) . " ..." : $title;
      $shortBody = strlen($body) > 90 ? substr($body, 0, 90) . " ..." : $body;
      $shortDate = substr($diaryresultarray['diary_time'], 0, 16);
      echo textThumbnail($shortTitle, $shortDate, $shortBody, $uname, $diaryresultarray['did']);
    }
  }
  if ($diaryNum < 3 && $testarray['did'] != NULL) {
    echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>";
  }
?>


<!- Photos Starts here->

<div class="btn-group pull-right" role="group" aria-label="...">
<table><tr><td>

      <form action='choose_photo.php' method="get" class="form-register">
        <input type="hidden" name="uname" value= <?php echo $uname; ?> >
        <input type="submit" value="Upload a Photo!" name="submit" class="btn btn-lg btn-danger form-next">
      </form></td><td>&nbsp;</td><td>

      <form action='gallery.php' method="get" class="form-register">
        <input type="hidden" name="uname" value= <?php echo $uname; ?> >
        <input type="submit" value="View All your photos!" name="submit" class="btn btn-lg btn-primary form-next">
      </form></td></tr>
</table>
    </div>

<h1><span class="cap">Your Photos:</span></h1>
<hr style="height:1px;border:none;color:#FFFFFF;background-color:#FFFFFF;" />


<?php

include("connect.php");
  foreach (glob("tmp/home_{$uname}_*.jpg") as $filename) {
    $fn = rtrim($filename,".jpg");
    unlink($filename);
  }
  $sql3="select * from media where mid in (select mid from post_m where username = '{$uname}') order by media_time desc;";  
  $mediaresult= pg_query($conn, $sql3);
  $allphoto=pg_fetch_all($mediaresult);
  $photoNum=count($allphoto);
  $testarray1 = pg_fetch_array($mediaresult, NULL, PGSQL_BOTH);

  for ($i = 0; $i <= 2; $i++) {
    if ($photoNum == 1 && $testarray1['mid'] == NULL) { 
      echo "<h5>You don't have any photos. Upload one!</h5>";
      break; }


    if ($photoNum > $i) {
      $photoresultarray = pg_fetch_array($mediaresult, $i, PGSQL_BOTH);
      $data = pg_fetch_result($mediaresult, $i, 'photo');
      $unes_image = pg_unescape_bytea($data);
      $file_name = "tmp/home_{$uname}_{$i}.jpg";
      $img = fopen($file_name, 'wb');
      fwrite($img, $unes_image);
      fclose($img);

      $body = $photoresultarray['des_text'];
      $title = ucfirst(strtolower($photoresultarray['title']));
      $shortTitle = strlen($title) > 14 ? substr($title, 0, 14) . " ..." : $title;
      $shortBody = strlen($body) > 50 ? substr($body, 0, 50) . " ..." : $body;
      $shortDate = substr($photoresultarray['media_time'], 0, 16);
      $mid = $photoresultarray['mid'];
      ?>
          <div class='col-lg-3 col-md-3 col-xs-6 thumb text-center'>
                <div class='thumbnail'>
                    <img class='img-responsive' src='<?php echo $file_name; ?>' alt='photo'>
                    <h3><?php echo $title ?></h3>
                    <h6><?php echo $shortDate ?></h6>
                    <h6><?php echo $body ?></h6>

                    <form action='display_pic.php' method='get' class='form-register'>
                    <input type='hidden' name='uname' value='<?php echo $uname ?>'>
                    <input type='hidden' name='mid' value='<?php echo $mid ?>'>
                    <input type='hidden' name='file' value='<?php echo $file_name ?>'>
                    <input type='submit' value='View this photo' name='submit' class='btn btn-sm btn-sencondary btn-block form-next'>
                    </form>

                    </form>
                </div>
            </div>
      <?php
    }
  }
?>


</div>





        

    <hr>


         <hr class="hr2"></hr>
        <div id="footer">
            &copy; built by Wentao Shi, Yun Yan and Liang Shan
        </div>

  <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
