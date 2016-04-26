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

$sql2="SELECT email from users where username='{$user_des}'";
$result2=pg_query($conn,$sql2);
$row=pg_fetch_row($result2);
require("PHPMailer/PHPMailerAutoload.php");
require_once("PHPMailer/class.phpmailer.php");
require_once("PHPMailer/class.smtp.php");
require_once("PHPMailer/language/phpmailer.lang-es.php");

$mail  = new PHPMailer(); 

$mail->CharSet    ="UTF-8";                 
$mail->IsSMTP();                           
$mail->SMTPAuth   = true;                   
$mail->SMTPSecure = "ssl";                  
//$mail->SMTPDebug = 2;
$mail->Host       = "smtp.gmail.com";       
$mail->Port       = 465;                    
$mail->Username   = "zty213@gmail.com";  
$mail->Password   = "shanliang";        
$mail->SetFrom('leronshan@163.com', 'Facebook');    
$mail->AddReplyTo("leronshan@gmail.com","邮件回复人名称"); 
                                            
$mail->Subject    = 'Friend Request ';                     
$mail->AltBody    = "为了查看该邮件，请切换到支持 HTML 的邮件客户端"; 
                                            
$mail->MsgHTML("Hello! you have a friend request from '{$user_src}'");                         
$mail->AddAddress("$row[0]", "my friend");
//$mail->AddAttachment("images/phpmailer.gif"); // 附件 
if(!$mail->Send()) {
  setAlert($mail->ErrorInfo);
  die(setAlert("Cannot get contacted via email | Your friend did not tell us his/her email. Oops."));

    // echo "Error" . $mail->ErrorInfo;
} else {
    setSuccessAlert("Email has sent!");
}

if ($user_src == $user_des){
  die(setAlert("Keep Exploring World"));
}
// Whether $user_src ~ $user_des pair existed in database already
$sql = "select * from friend where username='{$user_src}' and username2='{$user_des}'";
$res = pg_query($sql);
$tuple = pg_fetch_array($res);
// src => des exists already
if ($tuple['status'] == 'pending'){
  die(setAlertWithBackButton("You have already sent request. Please Wait for respond from {$user_des}", "Go Back"));
}
if ($tuple['status'] == 'accepted'){
  die(setSuccessAlertWithHistoryBackButton("A-hah, {$user_des} is your friend already.", "Go Back"));
}
if ($tuple['status'] == 'declined'){
  die(setAlertWithBackButton("Oops, you once were decliend.", "Go Back"));
}

$sql = "INSERT INTO friend VALUES ('{$user_src}', '{$user_des}', 'pending', current_timestamp)";
$result = pg_query($conn, $sql);
if(!$result){
  die(setAlertWithBackButton(pg_last_error(), "Go Back"));

} else{
  echo setSuccessAlertWithHistoryBackButton("Great! You request has been sent!", "Go Back");
}
?>
