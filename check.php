<html>
<head>
	<title>check</title>
	<link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
</head>
<body>

<div class="container form-left">
<?php

header("content-type:text/html;charset=utf-8");

include("connect.php");



$uname=$_POST['uname'];

$password=$_POST['password'];


$sql="select * from users where username='{$uname}';";  

$result=pg_query($conn, $sql); 

$num=pg_num_rows($result); 

if($num == 1){ 

   $row=pg_fetch_array($result);

   if($password===$row['pwd'])
   { 
    echo "Login Success!";
    header("location: home.php?uname=$uname");

    }else{  ?>
<img src="images/cat.gif" alt="WAT" title="WAT??" />
<br><br>
<table cellpadding="2" cellspacing="3" border="0" width="500px">
<tr>
<td><span style="color:red">  Password Wrong!</span></td>
<td><button class="btn btn-danger form-center" type="submit" onclick = "window.location.href='login.php'">Try Again</button>
</td>
</tr>




</table>

<?php

} 

}else{ ?>
<img src="images/cat.gif" alt="WAT" title="WAT??" /><br><br>
<table cellpadding="2" cellspacing="3" border="0" width="470px" >
<tr>
<td><span style="color:red">  User Name Doen't Exist!</span></td>
<td><button class="btn btn-danger" type="submit" onclick = "window.location.href='login.php'">Try Again</button>

</td>
</tr>
</table>
</div><?php
}

?>

</body>
</html>