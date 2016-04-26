<html>
    <head>
        <title>Decline</title>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/my.css" rel="stylesheet">
    </head>
<body>
<form class="form-register">
    <table>
<?php
include 'connect.php';
include('functions/alert.php');


$fID=$_GET['fID'];
$hID=$_GET['hID'];
$sql="UPDATE friend SET status='declined', res_time = current_timestamp
      where username2='{$hID}' and username='{$fID}'";
if(pg_query($conn, $sql))
{
	setSuccessAlert("You have decliend request from {$fID}");
} else {
}
?>
<div class="text-center">
<input class="btn btn-success btn-lg" type="button" value="Back to Home Page" 
       onclick = "window.location.href='home.php?uname=<?php echo $hID ?>';"/>
<input class="btn btn-primary btn-lg" type="button" value="Back to Friend Requests" 
       onclick = "window.location.href='friend_process.php?uname=<?php echo $hID ?>';"/>

       </div>

</body>
</html>