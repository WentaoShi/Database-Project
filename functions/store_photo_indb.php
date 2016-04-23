<?php include("connect.php");
$file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

// Convert the photo to bytea: $es_data
$img = fopen($file, 'r') or die("cannot read image\n");
$data = fread($img, filesize($file));
$es_data = pg_escape_bytea($data);
fclose($img);

$mid = uniqid();
$sql = "INSERT INTO media VALUES ('{$mid}', '{$es_data}', NULL, NULL, '{$title}', '{$desc}', current_timestamp, '{$visib}');";
if (!pg_query($conn, $sql)){
    die(pg_last_error());
}

$sql2 = "INSERT INTO post_m VALUES ('{$uname}','{$mid}');";
if (!pg_query($conn, $sql2)){
       die(pg_last_error());
    } else {
      echo setSuccessAlert("Great! You photo has been posted!");
      echo "<center><a href='gallery.php?uname={$uname}' class='btn btn-success btn-lg' role='button'>Go to your gallery</a></center>";
    }

pg_close($conn);
?>