<html>
     <head>
        <title>Accept</title>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/my.css" rel="stylesheet">
    </head>
<body>
<?php
include('connect.php');
include('functions/alert.php');

$fID=$_GET['fID'];
$hID=$_GET['hID'];
// $cir=$_POST['cir'];
$sql="UPDATE friend SET status='accepted' where username2='{$hID}' and username='{$fID}'";

if(pg_query($conn,$sql))
{ 

  echo setSuccessAlert("You have add <?php echo $fID ?> as your friend!");

}
$sql1="INSERT INTO friend VALUES ('{$hID}','{$fID}','accepted',current_timestamp)";
       if(!pg_query($conn,$sql)){
          die('Error: ' . pg_last_error());
          }
       else{ 
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