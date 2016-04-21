<?php
  $res = pg_query("SELECT user_photo FROM users WHERE username='{$uname}'") or die ("no user photo");  
  $image = stripcslashes(pg_fetch_result($res,0,0));

  $data = pg_fetch_result($res, 'user_photo');
  $unes_image = pg_unescape_bytea($data);

  $file_name = "profile_pic/{$uname}_profile.jpg";
  $img = fopen($file_name, 'wb');
  fwrite($img, $unes_image);
  fclose($img);

  pg_close($conn); 

?>