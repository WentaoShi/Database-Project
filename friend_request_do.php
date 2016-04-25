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

// Whether $user_des existed?
$sql = "select username from users where username = '{$user_des}'";
$res = pg_query($conn, $sql);
if (pg_num_rows($res) == 0){
  setAlert("No users named: {$user_des}");
  $sql = "select username from users where username like '%{$user_des}%'";
  $res = pg_query($conn, $sql);
  if (pg_num_rows($res) > 0) {
    echo "<br><div class = 'text-center'>";
    echo "<p><strong>Perhaps you are looking for the following users?</strong></p>";
    for ($i = 0; $i < pg_num_rows($res); $i ++){
      $rowi = pg_fetch_array($res, $i, PGSQL_BOTH);
      echo $rowi['username']; 
      echo "&nbsp;";
      if ($i % 10 == 0) {
        echo "<br>";
      }
    }
    echo "</div>";
  }
  die();
}

// Whether $user_src ~ $user_des pair existed in database already
$sql = "select * from friend where username='{$user_src}' and username2='{$user_des}'";
$res = pg_query($sql);
$tuple = pg_fetch_array($res);
// src => des exists already
if ($tuple['status'] == 'pending'){
  die(setAlert("You have already sent request. Please Wait for respond from {$user_des}"));
}
if ($tuple['status'] == 'accepted'){
  die(setSuccessAlert("A-hah, {$user_des} is your friend already."));
}
if ($tuple['status'] == 'declined'){
  die(setAlert("Oops, you once were decliend."));
}

$sql = "INSERT INTO friend VALUES ('{$user_src}', '{$user_des}', 'pending', current_timestamp)";
$result = pg_query($conn, $sql);
if(!$result){
  die(setAlert(pg_last_error()));

} else{
  echo setSuccessAlert("Great! You request has been sent!");
}
?>