<html>
    <head>
        <title>Upload a photo</title>
        <script type="text/javascript" src="js/check.js"></script>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Upload a photo.">
        <meta name="author" content="Wentao Shi">
    </head>
<body>
<?php
$uname= $_GET['uname'];
 ?>

<form action="photo_up_process.php" method="post" enctype="multipart/form-data" class="form-register">
    <td colspan="1"><h2>Upload a photo:</h2></td>
    <hr><br>

    <table>
        <table>
        
        <tr>
            <td>Choose photo:</td>
            <td>
                <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
            </td>
        </tr>
        <tr>
            <td>Title:</td>
            <td>
                <textarea name="title" rows="1" cols="45"></textarea>
            </td>
        </tr>
        <tr>
            <td>Brief description:</td>
            <td>
                <textarea name="content" rows="4" cols="45"></textarea>
            </td>
        </tr>
        <tr>
            <td>This photo would be visible to:</td>
            <td>
                <div class="radio">
                  <label>
                    <input type="radio" name="visib" id="f" value="f">
                    Only my friends
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="visib" id="fof" value="option2">
                    My friends and the friends of my friends
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="visib" id="all" value="all" checked>
                    Whole world!
                  </label>
                </div>
            </td>
        </tr>
        </table>

<div class="text-center">

      <small><em> * We accept <span style="color:blue">GIF</span>, <span style="color:blue">JPG/JPEG</span> and <span style="color:blue">PNG</span> as image formats.<br>* Please note this photo can be seen by anyone.</em></small>
      <br><br>
      <input type="hidden" name="uname" value= <?php echo $uname; ?> >
      <input type="hidden" name="type" value="photo">
      <input type="submit" value="Upload Image" name="submit" class="btn btn-lg btn-success"></td>
      <a href='home.php?uname=<?php echo $uname; ?>' class='btn btn-primary btn-lg' role='button'>Go Back home!</a>


            
</div>

</form>

 </body>
 </html>