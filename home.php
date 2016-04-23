<html>
  <head>
    <title>Homepage</title>
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


    $dir = "images";
    $uname= $_GET['uname'];

    $sql="SELECT * FROM users WHERE username='{$uname}'";  
    $result= pg_query($conn, $sql);
    $row = pg_fetch_array($result);

    ?>
    <div class="container">
    <h1>
        <span style="color:orange">Welcome, <?php echo $row['name'] ?>! This is your home page!</span>
    </h1>
    <hr class="hr2"></hr>
    
    <div class="col-md-3">


    <?php
        include("functions/storePicToTmp.php");
      ?>
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

<table>
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
      <input type="file" name="fileToUpload" id="fileToUpload" class="form-control"></td><tr><td>
      <input type="hidden" name="uname" value= <?php echo $uname; ?> >
      <input type="submit" value="Upload Image" name="submit" class="btn btn-sm btn-success btn-block form-next"></td></tr>
    </tr><p>


    <tr>
        <td colspan="2">
            <small><em> * We accept <span style="color:blue">GIF</span>, <span style="color:blue">JPG/JPEG</span> and <span style="color:blue">PNG</span> as image formats.<br>* Please note this photo can be seen by anyone.</em></small>
        </td>
    </tr>
</table>

</form>
<div class="btn-group pull-right" role="group" aria-label="...">

<h2>
        <span class="cap">Your Friend Request:</span>
      <!--<em>Your Friend Request :</em>-->
    </h2><?php

    $sql3="SELECT * from friend where username2='{$uname}' and status='pending'"; 
    $rs3=pg_query($conn,$sql3); 
    $num3=pg_num_rows($rs3);
    if($num3){
                ?>
    <table cellpadding="3" cellspacing="5" border="0" width="200px">
      <tr>
        <td>You have <?php echo $num3 ?> friend requests !</td>
        <td>
          <input type="button" class="btn btn-sm btn-warning" value="Go to process !"
          onclick="window.location.href='process.php?uname=<?php echo $uname ?>';" />
        </td>
      </tr>
    </table>
    <?php
    }
    else{
            ?> 
    <em>You have no friend request now !</em> <?php
    }
    ?>

    <div>
    <form action='friend_request.php' method="post" class="form-register">
    <input type="hidden" name="uname" value= <?php echo $uname; ?> >
    <input type="submit" value="Add Friends" name="submit" class="btn btn-primary btn-danger form-next">
    </form>
    <form action='friend_manager.php' method="post" class="form-register">
    <input type="hidden" name="uname" value= <?php echo $uname; ?> >
    <input type="submit" value="Friends Manager" name="submit" class="btn btn-primary form-next">
    </form>
    </div>


</div>
        
        <br>
        <br>
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
      <form action='write_diary.php' method="post" class="form-register">
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


    <h1><span class="cap">Diaries:</span></h1>
    <hr style="height:1px;border:none;color:#FFFFFF;background-color:#FFFFFF;" />


<!- Thumbnails Starts here-><?php 
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
      $shortBody = strlen($body) > 100 ? substr($body, 0, 100) . " ..." : $body;
      $shortDate = substr($diaryresultarray['diary_time'], 0, 16);
      echo textThumbnail($shortTitle, $shortDate, $shortBody, $uname, $diaryresultarray['did']);
    }
  }
  if ($diaryNum < 3 && $testarray['did'] != NULL) {
    echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>";
  }
?>

<hr>
<!- Photos Starts here->

<div class="btn-group pull-right" role="group" aria-label="...">
<table><tr><td>

      <form action='up_phot.php' method="post" class="form-register">
        <input type="hidden" name="uname" value= <?php echo $uname; ?> >
        <input type="submit" value="Upload a Photo!" name="submit" class="btn btn-lg btn-danger form-next">
      </form></td><td>&nbsp;</td><td>

      <form action='gallery.php' method="get" class="form-register">
        <input type="hidden" name="uname" value= <?php echo $uname; ?> >
        <input type="submit" value="View All your photos!" name="submit" class="btn btn-lg btn-primary form-next">
      </form></td></tr>
</table>
    </div>

<h1><span class="cap"> Photos:</span></h1>
<hr style="height:1px;border:none;color:#FFFFFF;background-color:#FFFFFF;" />

  <div class="col-md-3">
    <div class="thumbnail">
      <img style="height: 200px" src="images/welcome.jpg" alt="...">
      <div class="caption">
        <h3>Thumbnail label</h3>
        <p>2014-04-19</p>
      </div>
    </div>

  </div></div>



    <hr>


         <hr class="hr2"></hr>
        <div id="footer">
            &copy; built by Wentao Shi, Yun Yan and Liang Shan
        </div>
  </body>
</html>
