<html>
  <head>
    <title>Visit Homepage</title>
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
        $visitor = $admin;
    } else {
        $admin = "";
    }

    include("functions/navi_bar.php");
    $dir = "images";
    $uname = $_GET['uname'];
    $host= $_GET['uname'];

    if ($admin == NULL) {
      setAlert("Please log in.");
      echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
      die;
    }

    $sql="SELECT * FROM users WHERE username='{$host}'";  
    $result= pg_query($conn, $sql);
    $row = pg_fetch_array($result);
    $host_name = $row['name'];
    $host_gender = $row['gender'];
    switch ($host_gender) {
    	case 'm':
    		$host_gender_call = "his";
    		break;
    	case 'f':
    		$host_gender_call = "her";
    		break;
    	default:
    		# code...
    		break;
    }

    $sqlv="SELECT * FROM users WHERE username='{$visitor}'";  
    $resultv= pg_query($conn, $sqlv);
    $rowv = pg_fetch_array($resultv);
    $visitor_name = $rowv['name'];

    ?>
    <div class="container">

    <h1>
    <!--
    <a href="logout.php?uname=<?php echo $uname; ?>" class="btn btn-warning btn-lg pull-right" role="button">Log out</a>
    <a href="newfeeds.php?uname=<?php echo $uname;?>" class="btn btn-primary btn-lg pull-left" role="button">Feeds</a>-->
    &nbsp;
    <span style="color:#f76f6f">Welcome, <?php echo $visitor_name; ?>! This is <?php echo $host_name; ?>'s home page!</span>
    </h1>
  
    
      

    <hr class="hr2"></hr>
    
    <div class="col-md-3">

<!-Display Profile Photo->
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
<br>
<!-Profile Starts here->
<?php
        $sql_p="SELECT * FROM profile WHERE pid in (select pid from post_p where username = '{$uname}') order by time_stamp desc;"; 

        $pro_result= pg_query($conn, $sql_p);
        $pro_resultarray = pg_fetch_array($pro_result, NULL, PGSQL_BOTH);
        if($pro_resultarray['pid'] != NULL) {
          echo "<h5>{$pro_resultarray['content']}</h5><a href='profile.php?uname={$uname}' class='btn btn-info btn-md btn-block' role='button'>View all {$host_gender_call} saying</a>";
        } else {
          echo setAlert("No profiles here.");
        }
?>
<br>
<a href="greeting.php?host=<?php echo $host; ?>" class="btn btn-warning btn-block" role="button">Send Greeting!</a>
<hr class="hr2"></hr>


<!-Friend start here->

<h2>
        <span class="cap"><?php echo $host_name; ?>'s Friends:</span>
    </h2>

    <?php

    $sql3="SELECT * from friend where username2='{$uname}' and status='pending'"; 
    $rs3=pg_query($conn,$sql3); 
    $num3=pg_num_rows($rs3);

    ?>


    <form action='friend_manager.php' method="get" class="form-register">
    <input type="hidden" name="uname" value= <?php echo $uname; ?> >
    <input type="submit" value="View <?php echo $host_name; ?>'s Friends" name="submit" class="btn btn-primary btn-block">
    </form>


        
        <br>
        <hr class="hr2"></hr>
    <h1>
      <span class="cap"><?php echo $host_name; ?>'s Information:</span>
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
	<form action='diary_list.php' method="get" class="form-register">
        <input type="hidden" name="uname" value= <?php echo $uname; ?> >
        <input type="submit" value="View All <?php echo $host_gender_call; ?> Diaries!" name="submit" class="btn btn-lg btn-primary form-next">
      </form></td></tr>
</table>
    </div>



    <h1><span class="cap"><?php echo $host_name; ?>'s Diaries:</span></h1>
    <hr style="height:1px;border:none;color:#FFFFFF;background-color:#FFFFFF;" />


<!- Thumbnails Starts here->
<!- FetchFeeds->
<?php 
  include("connect.php");
  include("functions/thumbnail.php");

  $procedure = file_get_contents('./functions/fetch_friendList.sql');
  $result = pg_query($conn, $procedure);
  $sql = "select * from FetchFriendNameList('{$admin}');";
  $result = pg_query($conn, $sql);
  $friends_num = pg_num_rows($result);
  if ($friends_num == 0){
    // setAlert("No friends yet... How about add new friends?");
  }

  $sql2 = file_get_contents('./functions/fetch_friendList.sql', true);
  $sql3 = file_get_contents('./functions/fetch_FofList.sql', true);
  $sql4 = file_get_contents('./functions/fetch_reachedPersonNames.sql', true);
  pg_query($conn, $sql2);
  pg_query($conn, $sql3);
  pg_query($conn, $sql4);
  $sql_feedsDiary = file_get_contents('./functions/fetch_hosts_visithome.sql', true);
  pg_query($conn, $sql_feedsDiary); // procedure: FetchFeedsXXXX4Me

  $sql_reachedPerson_diary = "select * from FetchHostsFeedsDiary4Me('{$admin}', '{$host}')";

  $query_reachedPersonDiaries = pg_query($conn, $sql_reachedPerson_diary);
  $reachedPersonDiaries = pg_fetch_all($query_reachedPersonDiaries);

  $sql_reachedPerson_media = "select * from FetchHostsFeedsMedia4Me('{$admin}', '{$host}')";
  $query_reachedPersonMedia = pg_query($conn, $sql_reachedPerson_media);
  $reachedPersonMedia = pg_fetch_all($query_reachedPersonMedia);

// echo print_r($reachedPersonDiaries) . "\n";

// echo print_r($reachedPersonMedia);




  $diaryNum=count($reachedPersonDiaries);
  $testarray = pg_fetch_array($query_reachedPersonDiaries, NULL, PGSQL_BOTH);

  for ($i = 0; $i <= 2; $i++) {
    if ($diaryNum == 1 && $testarray['did'] == NULL) { 
      echo "<h5>No diaries.</h5>";
      break; }

    if ($diaryNum > $i) {
      $diaryresultarray = pg_fetch_array($query_reachedPersonDiaries, $i, PGSQL_BOTH);
      $did = $diaryresultarray['did'];
      $sql_diary = "select * from diary where did = '{$did}';";
      $result_diary = pg_query($conn, $sql_diary);
      $result_diary_arr = pg_fetch_array($result_diary, 0, PGSQL_BOTH);

      $body = $result_diary_arr['body'];
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

      <form action='gallery.php' method="get" class="form-register">
        <input type="hidden" name="uname" value= <?php echo $uname; ?> >
        <input type="submit" value="View All <?php echo $host_gender_call; ?> photos!" name="submit" class="btn btn-lg btn-primary form-next">
      </form></td></tr>
</table>
    </div>

<h1><span class="cap"><?php echo $host_name; ?>'s Photos:</span></h1>
<hr style="height:1px;border:none;color:#FFFFFF;background-color:#FFFFFF;" />


<?php

include("connect.php");
  foreach (glob("tmp/home_{$uname}_*.jpg") as $filename) {
    $fn = rtrim($filename,".jpg");
    unlink($filename);
  }
  $photoNum=count($reachedPersonMedia);
  $testarray1 = pg_fetch_array($query_reachedPersonMedia, NULL, PGSQL_BOTH);


  for ($i = 0; $i <= 2; $i++) {
    if ($photoNum == 1 && $testarray1['mid'] == NULL) { 
      echo "<h5>You don't have any photos. Upload one!</h5>";
      break; }


    if ($photoNum > $i) {
      $photoresultarray = pg_fetch_array($query_reachedPersonMedia, $i, PGSQL_BOTH);
      $mid = $photoresultarray['mid'];

      $sql_photo = "select * from media where mid = '{$mid}';";
      $result_photo = pg_query($conn, $sql_photo);
      $result_photo_arr = pg_fetch_array($result_photo, 0, PGSQL_BOTH);

      $data = $result_photo_arr['photo'];
      $unes_image = pg_unescape_bytea($data);
      $file_name = "tmp/home_{$uname}_{$i}.jpg";
      $img = fopen($file_name, 'wb');
      fwrite($img, $unes_image);
      fclose($img);

      $body = $result_photo_arr['des_text'];
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
