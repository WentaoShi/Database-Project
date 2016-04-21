<?php

function textThumbnail($title, $date, $body, $uname, $did) {

  echo "
    <div class='col-md-3'>
      <div class='thumbnail'>
        <div class='caption'>
          <h3>{$title}</h3>
          <p>{$date}</p>
          <p>{$body}</p>
          <br><form action='display_diary.php' method='get' class='form-register'>
          <input type='hidden' name='uname' value='{$uname}'>
          <input type='hidden' name='did' value='{$did}'>
          <input type='submit' value='View this diary' name='submit' class='btn btn-sm btn-sencondary btn-block form-next'>
          </form>
        </div>
      </div>
    </div>
  ";

}

 ?>

