<html>
<head>
        <title>Process</title>
        <script type="text/javascript" src="js/check.js"></script>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
    </head>
<body>

<?php
include('connect.php');
include('functions/alert.php');
$uname=$_GET['uname'];

    if (isset($_COOKIE['admin'])) {
            $admin = $_COOKIE['admin'];
        } else {
            $admin = "";
        }

    if ($admin == NULL || $admin != $uname) {
          setAlert("Please log in.");
          echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
          die;
    }

    include("functions/navi_bar.php");
    echo "<center><h1> Your friend requests:</h1></center>";


$sql="SELECT * from friend where username2='{$uname}' and status='pending';"; 

$rs=pg_query($conn,$sql);
$num=pg_num_rows($rs);

if ($num == 0) {
        echo "<br><center><strong>You don't have friend request.</strong></center>";
        
    }
	while($row=pg_fetch_array($rs)){
    	
		?>

<form class="form-register">

    <table  class="table table-hover">
    <tr>
    <td width="70%">
     <em><span style="color:#FF717E"> <?php echo $row['username'] ?></span></em> request to be your friend.
     </td>
     <td> 
     <div  class="pull-right">
     <input class="btn btn-success" type="button" value="Accept" 
             onclick = "window.location.href='accept.php?hID=<?php echo $row['username2']?>&fID=<?php echo $row['username'] ?>';"/>

             <input class="btn btn-danger" type="button" value="Decline" 
             onclick = "window.location.href='decline.php?hID=<?php echo $row['username2'] ?>&fID=<?php echo $row['username']?>';"/>
            </div> 
        </td>
    </tr>
    </table>
<?php
}
?> 

<br><br><br>
<div class="text-center">

<a href="home.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>

</div>   
</body>
</html>