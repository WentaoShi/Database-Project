<html>
     <head>
        <title>Accept</title>
        <link href="bootstrap-3.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
    </head>
<body>
<form class="form-register">
    <table>
<?php
include 'connect.php';

$fID=$_GET['fID'];
$hID=$_GET['hID'];
// $cir=$_POST['cir'];
$sql="UPDATE friend SET status='accepted' where username2='{$hID}' and username='{$fID}'";

if(pg_query($conn,$sql))
{ ?>
	<tr><td> You have add <?php echo $fID ?> as your friend! </td></tr><?php
}
$sql1="INSERT INTO friend VALUES ('{$hID}','{$fID}','accepted',current_timestamp)";
       if(!pg_query($conn,$sql)){
          die('Error: ' . pg_last_error());
          }
       else{ ?>
        <?php
           }
?><tr><td>
<input class="btn btn-primary" type="button" value="Back to Home Page" 
       onclick = "window.location.href='home.php?uname=<?php echo $hID ?>';"/>
</td></tr></table></form>
</body>
</html>