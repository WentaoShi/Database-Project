<html>
<head>
  <title>Status of Friend Request</title>
  <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/signin.css" rel="stylesheet">
</head>
<body>

<?php
include("connect.php");
include("functions/alert.php");

$user_src = $_POST['uname'];
$user_des = $_POST['fname'];

// echo $user_src;
// echo $user_des;
$sql = "INSERT INTO friend VALUES ('{$user_src}', '{$user_des}', 'pending', current_timestamp)";
if(!pg_query($conn, $sql)){
  echo setAlert(pg_last_error());
} else{
  echo setSuccessAlert("Great! You request has been sent!");
}
?>