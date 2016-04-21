<html>
    <head>
        <title>Compose a diary</title>
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
$uname= $_POST['uname'];
 ?>
<div class="form-register">

<form action="up_diary.php" method="post" class="form-register">
    <td colspan="1"><h2>Compose a diary:</h2></td>
    <input type="hidden" name="uname" value= <?php echo $uname; ?> >
    <hr>
    <table>
        <tr>
            <td>Title:</td>
            <td>
                <textarea name="title" rows="1" cols="50"></textarea>
            </td>
        </tr>

        <tr>
            <td>Content:</td>
            <td>
                <textarea name="content" rows="20" cols="50"></textarea>
            </td>
        </tr>

        <tr>
            <td>This diary would be visible to:</td>
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
        </div>


        <table cellpadding="2" cellspacing="5" border="0" width="400px" >
        
        <tr>
            <td>
             <button class="btn btn-lg btn-success btn-block form-center" type="submit" onclick = "window.location.href='up_diary.php'">Submit</button>
            </td>

        
        </tr>
        </table>
        </form>
        
</body>
</html>
