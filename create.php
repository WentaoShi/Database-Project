
<html>
<head>
	<title> Final Project! </title>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/creat.css" rel="stylesheet">
</head>
<body>
<div class="container form-center">
<?php 
include("connect.php");

if (!$conn)
  {
    die('Could not connect:' . pg_last_error());
  }

$sql = file_get_contents('./functions/createtable.sql', true);

if (pg_query($conn, $sql)) {
    ?><h1> Presentation Start!! </h1>
<table cellpadding="2" cellspacing="3" border="0" width="80%">
<tr>
<td> Let's Start!</td>
<td><button class="btn btn-success" type="submit" onclick = "window.location.href='login.php'">Continue!</button>
</td>
</tr>
</table>
</div>
<?php
} 
else {
   ?><table cellpadding="2" cellspacing="3" border="0" width="50%">
<tr>
<td> Error creating table :<?php echo pg_last_error()?></td>
<td><button class="btn btn-success" type="submit" onclick = "window.location.href='index.php'">Start again!</button>
</td>
</tr>
</table>
</div>   
   <?php
}
pg_close($conn);
?> 
</body>
</html>