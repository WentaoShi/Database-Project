<html>
  <head>
    <title>Homepage</title>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/mycss.css" rel="stylesheet" />
  </head>

  <body>

<?php
include("functions/alert.php");
$target_dir = "tmp/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$uname=$_POST['uname'];
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
$uptype=$_POST['type'];





if($_FILES['fileToUpload']['error'] != UPLOAD_ERR_OK)
{
    switch($_FILES['fileToUpload']['error'])
    {
        case UPLOAD_ERR_INI_SIZE: 
            die("
<div class='alert alert-danger' role='alert'><center><strong>The uploaded file size is too LARGE!</strong><br>The file size exceeds the upload_max_filesize directive in php.ini</center></div><br><center><button type='button' class='btn btn-info btn-lg btn-block' onClick='history.go(-1);return true;'>Go back to your home page</button></tr></center>
                ");
        break;
        case UPLOAD_ERR_FORM_SIZE: 
            die("
<div class='alert alert-danger' role='alert'><center><strong>The uploaded file size is too LARGE!</strong><br>This file exceeds the MAX_FILE_SIZE directive in the HTML form.</center></div><br><center><button type='button' class='btn btn-info btn-lg btn-block' onClick='history.go(-1);return true;'>Go back to your home page</button></tr></center>
                ");
        break;
        case UPLOAD_ERR_PARTIAL: 
            die("
<div class='alert alert-danger' role='alert'><center><strong>The uploaded file has not uploaded completely.</strong></center></div><br><center><button type='button' class='btn btn-info btn-lg btn-block' onClick='history.go(-1);return true;'>Go back to your home page</button></tr></center>
                ");
        break;
        case UPLOAD_ERR_NO_FILE: 
            die("
<div class='alert alert-danger' role='alert'><center><strong>OOPS!  No file has been selected!</strong></center></div><br><center><button type='button' class='btn btn-info btn-lg btn-block' onClick='history.go(-1);return true;'>Go back to your home page</button></tr></center>
                ");
        break;
        case UPLOAD_ERR_NO_TMP_DIR: 
            die("
<div class='alert alert-danger' role='alert'><center><strong>The server is missing a temporary folder.</strong></center></div><br><center><button type='button' class='btn btn-info btn-lg btn-block' onClick='history.go(-1);return true;'>Go back to your home page</button></tr></center>
                ");
        break;
        case UPLOAD_ERR_CANT_WRITE: 
            die("
<div class='alert alert-danger' role='alert'><center><strong>The server failed to write the uploaded file to disk.</strong></center></div><br><center><button type='button' class='btn btn-info btn-lg btn-block' onClick='history.go(-1);return true;'>Go back to your home page</button></tr></center>
                ");
        break;
        case UPLOAD_ERR_EXTENSION:
            die("
<div class='alert alert-danger' role='alert'><center><strong>File upload stopped by extension.</strong></center></div><br><center><button type='button' class='btn btn-info btn-lg btn-block' onClick='history.go(-1);return true;'>Go back to your home page</button></tr></center>
                ");
        break;
    }
}

list($width,$height,$type,$attr) = getimagesize($_FILES['fileToUpload']['tmp_name']);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo setSuccessAlert("File Type: " . $check["mime"] . " - This file is an image.");
        $uploadOk = 1;
    } else {
        echo setAlert("File is not an image.");
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo setAlert("Sorry, file already exists.");
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo setAlert("Sorry, your file is too large.");
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo setAlert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo setAlertWithBackButton("Sorry, your file was not uploaded.", "Go back to your home page");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo setSuccessAlertWithBackButton("This image ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.", "Go back to your home page", $uname);
        echo $type;
        switch ($uptype) {
            case 'profile':
                include("functions/store_profile_photo_indb.php");
                unlink("{$target_file}");
                break;
            case 'photo':
                $title=$_POST['title'];
                $desc=$_POST['content'];
                $visib=$_POST['visib'];
                include("functions/store_photo_indb.php");
                unlink("{$target_file}");
                break;
            default:
                echo "Failed to Store in DB.";
        }


    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}



?>

  </body>
</html>