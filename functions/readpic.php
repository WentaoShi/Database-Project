<?php

include("functions/cutpic.php");
$dst_w = 320;
$dst_h = 240;

  $res = pg_query("SELECT * FROM media WHERE mid in (select mid from post_m where username = '{$uname}');");  

  $allpic=pg_fetch_all($res);
  $picNum=count($allpic);
  //$image = stripcslashes(pg_fetch_result($res,0,0));
  if (pg_fetch_array($res, NULL, PGSQL_BOTH) != NULL) {
  	for ($i = 0; $i < $picNum; $i++) {
	  $data = pg_fetch_result($res, $i, 'photo');
	  $row = pg_fetch_array($res, $i, PGSQL_BOTH);
	  $mid = $row['mid'];
    $title = $row['title'];
    $body = $row['des_text'];
    $date = substr($row['media_time'], 0, 16);

	  $unes_image = pg_unescape_bytea($data);

	  $file_name = "tmp/gall_{$uname}_{$i}.jpg";
	  $img = fopen($file_name, 'wb');
	  fwrite($img, $unes_image);
	  fclose($img);
    //echo $i . $file_name . "<br>";
    //imagepress($file_name, $dst_w, $dst_h, $uname);
    //unlink("tmp/{$uname}_{$i}.jpg");
?>
                <div class='col-lg-3 col-md-4 col-xs-6 thumb text-center'>
                <a class='thumbnail' href='<?php echo $file_name; ?>'>
                    <img class='img-responsive' src='<?php echo $file_name; ?>' alt='photo'>
                    <h3><?php echo $title ?></h3>
                    <h6><?php echo $date ?></h6>
                    <h6><?php echo $body ?></h6>
                    
                    <form action='delete_p.php' method='get' class='form-register'>
                    <button type="button" href='<?php echo $file_name; ?>' class="btn btn-primary btn-sm">View Original</button>
                      <input type='hidden' name='uname' value= <?php echo $uname; ?> >
                      <input type='hidden' name='mid' value= <?php echo $mid; ?> >
                      <input type='submit' value='Delete it' name='submit' class='btn btn-sm btn-danger '>

                    </form>
                </a>
            </div>
<?php
  	}
  } else {
    include("functions/alert.php");
  	echo setAlert("You don't have photos.");
  }


  pg_close($conn); 

?>