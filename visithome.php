<?php

$cookie = $_COOKIE;
echo "Your cookie: ";
print_r($cookie);

$uname = $_GET['uname'];

?>

You are <?php echo $_COOKIE['admin']; ?>. You are visiting a home page of <?php echo $uname; ?>.