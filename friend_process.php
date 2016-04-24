<html>
<head>
        <title>Process</title>
        <link href="bootstrap-3.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
    </head>
<body>
<?php
include 'connect.php';

$uname=$_GET['uname'];
$sql="SELECT * from friend where username2='{$uname}' and status='pending'"; 
$rs=pg_query($conn,$sql);
$num=pg_num_rows($rs);
	while($row=pg_fetch_array($rs)){	
		?>
<form class="form-register">
<h1> Your friend requests</h1>
    <table cellpadding="3" cellspacing="5" border="0" width="300px">
    <tr><td> Request Sent from:</td>
    <td> <em> <?php echo $row['username'] ?></em> </td></tr>
     <tr><td> <input class="btn btn-success" type="button" value="Accept" 
             onclick = "window.location.href='accept.php?hID=<?php echo $row['username2']?>&fID=<?php echo $row['username'] ?>';"/>
        </td>
        <td>
             <input class="btn btn-danger" type="button" value="Decline" 
             onclick = "window.location.href='decline.php?hID=<?php echo $row['username2'] ?>&fID=<?php echo $row['username']?>';"/>
             
        </td>
    </tr>
    </table>
<?php
}
?>     
</body>
</html>