<html>
    <head>
        <title>Preview your uploaded diary</title>
        <script type="text/javascript" src="js/check.js"></script>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Write a diary.">
        <meta name="author" content="Wentao Shi">
    </head>

<body>
  <?php
    include("connect.php");
    include("functions/alert.php");

    $host= $_POST['host'];
    $sender = $_POST['sender'];
    if (isset($_COOKIE['admin'])) {
        $admin = $_COOKIE['admin'];
    } else {
        $admin = "";
    }

    if ($admin == NULL) {
      setAlert("Please log in.");
      echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
      die;
    }
    
    $content= $_POST['content'];
    $encode_content = htmlspecialchars($content, ENT_QUOTES);

    $sql1 = "INSERT INTO greeting VALUES ('{$sender}', '{$host}', current_timestamp, '{$encode_content}', 'unread');";
    
    
    
    

    
    if (!pg_query($conn, $sql1)){
       die(pg_last_error());
    } else {

      echo setSuccessAlert("Great! You greeting has been sent!");

      header("location: greeting.php?host={$host}");
    }

?>



</body>
    </html>