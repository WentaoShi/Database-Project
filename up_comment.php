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

    $uname= $_POST['uname'];
    $sender = $_POST['comment_sender'];
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
    $cid = uniqid();

    switch ($_POST['type']) {
        case 'diary':
            $did = $_POST['did'];
            $sql1 = "INSERT INTO comment VALUES ('{$cid}', '{$did}', NULL, '{$encode_content}', current_timestamp);";
            break;
        case 'media':
            $mid = $_POST['mid'];
            $sql1 = "INSERT INTO comment VALUES ('{$cid}', NULL, '{$mid}', '{$encode_content}', current_timestamp);";
            echo $sql1;
            break;
        
        default:
            echo "cannot identify the type of comment.";
            break;
    }
    
    
    

    
    if (!pg_query($conn, $sql1)){
       die(pg_last_error());
    }
    $sql2 = "INSERT INTO send VALUES ('{$sender}','{$cid}');";
    if (!pg_query($conn, $sql2)){
       die(pg_last_error());
    } else {

      echo setSuccessAlert("Great! You comment has been posted!");
      switch ($_POST['type']) {
        case 'diary':
            header("location: display_diary.php?uname={$uname}&did={$did}");
            break;
        case 'media':
            $file_name = $_POST['file'];
            header("location: display_pic.php?uname={$uname}&mid={$mid}&file={$file_name}");
            break;
        
        default:
            echo "cannot identify the type of comment.";
            break;
        }
      
    }


?>


<div class="text-center">
<a href="home.php?uname=<?php echo $uname; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>
</div>

</body>
    </html>