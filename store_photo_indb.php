<?php include("connect.php");
$file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

// Convert the photo to bytea: $es_data
$img = fopen($file, 'r') or die("cannot read image\n");
$data = fread($img, filesize($file));
$es_data = pg_escape_bytea($data);
fclose($img);

$sql = "UPDATE users SET user_photo='$es_data' where username='{$uname}';";
if (!pg_query($conn, $sql)){
    die(pg_last_error());
}

pg_close($conn);
?>
