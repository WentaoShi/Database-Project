<html>
    <head>
        <title>Decline</title>
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
$sql="UPDATE friend SET status='declined' where username2='{$hID}' and username='{$fID}'";
if(pg_query($conn, $sql))
{
	?>
	<tr><td> You have decline <?php echo $fID ?> as your friend! </td></tr><?php
}
?><tr><td>
<input class="btn btn-primary btn-block" type="button" value="Back to Home Page" 
       onclick = "window.location.href='home.php?uname=<?php echo $hID ?>';"/>
</td></tr></table></form>
</body>
</html>