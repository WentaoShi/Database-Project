<html>
  <head>
    <title>Homepage</title>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/mycss.css" rel="stylesheet" />
  </head>

  <body>
  <?php
    include("connect.php");


    $dir = "images";
    $uname= $_GET['uname'];
    ?>
    <div class="container">
    <h1>
        <img src="images/welcome.jpg" alt="welcome" title="Welcome to your home page!" />
    </h1>
    <hr>
    
    <div class="col-md-4">
    <?php
    $sql="select * from users where username='{$uname}'";  
    $result= pg_query($conn, $sql);
    $row = pg_fetch_array($result);
    ?>
    <h1>
      <span class="cap">Personal Information:</span>
    </h1>
    <form  class="form-register">
      <table class="table table-hover">
        <tr>
          <td>
            <em>User Name:</em>
          </td>
          <td>
            <?php echo $row['username'] ?>
          </td>
        </tr>
        <tr>
          <td>
            <em>Name:</em>
          </td>
          <td>
            <?php echo $row['name'] ?>
          </td>
        </tr>
        <tr>
          <td>
            <em>Birthday:</em>
          </td>
          <td>
            <?php echo $row['birthday'] ?>
          </td>
        </tr>
        <tr>
          <td>
            <em>City:</em>
          </td>
          <td>
            <?php echo $row['city'] ?>
          </td>
        </tr>
      </table>
    </form>
    </div>


    <hr>


         <hr class="hr2"></hr>
        <div id="footer">
            <p>&copy; built by Wentao Shi, Yun Yan and Liang Shan</p>
        </div>
    </div>
  </body>
</html>
