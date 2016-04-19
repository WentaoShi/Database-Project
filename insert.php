<!DOCTYPE html>
<html>
<head>
  <title>Insert</title>
  <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/signin.css" rel="stylesheet">
</head>
<body>
    <div class="container form-left">
        <?php 
        include("connect.php");

      $uname = $_GET['uname'];
      $password = $_GET['password'];
      $name = $_GET['name'];
      $birthday = $_GET['birthday'];
      $passwordn=$_GET['passwordn'];
      $gender=$_GET['gender'];
      $state=$_GET['state'];
      $city=$_GET['city'];
      $street=$_GET['street'];
      $email=$_GET['email'];
      $per_info = $_GET['per_info'];
      if (!empty($uname) && !empty($password) && !empty($name) && !empty($birthday) && !empty($gender) && !empty($city) && !empty($email))
      {
        if($password!=$passwordn){
         ?>
         <form action="register.php">
            <table cellpadding="2" cellspacing="3" border="0" width="350px" >
                <tr>
                    <td> Two Passwords doesn't match ! </td>
                    <td>
                        <button class="btn btn-success" type="submit">Again</button>
                        <!--<input type="button" value="Start!" onclick = "window.location.href='create.php'"/>-->
                    </td>
                </tr>
            </table>
        </form>
        <?php
    }
    else{
        $sql="SELECT * from users where username='{$uname}'";
        include("connect.php");
        
        if ($check_query = pg_query($conn, $sql))
        {
            if(pg_fetch_array($check_query, NULL, PGSQL_BOTH) != NULL)
            {
              ?>
              <form action="register.php">
                <table cellpadding="2" cellspacing="3" border="0" width="350px" >
                    <tr>
                        <td> User Name Existed! Please Change another ! </td>
                        <td>
                            <button class="btn btn-success" type="submit">Again</button>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
            exit;
            }  
        else{
          $uid = uniqid();
            $sql = "INSERT INTO users VALUES
            ('{$uid}','$_GET[uname]', '$_GET[password]', '$_GET[name]', '$_GET[gender]', '$_GET[birthday]', '$_GET[state]','$_GET[city]',  '$_GET[street]', '$_GET[email]');";
            if (!pg_query($conn, $sql)){
                die(pg_last_error());
            }
            else{
              
                ?>
                 <form action="login.php">
                    <table cellpadding="2" cellspacing="3" border="0" width="350px" >
                        <tr>
                            <td> Congratulations! You have registered successfully! </td>
                            <td>
                                <button class="btn btn-success" type="submit">TO LOGIN!</button>
                            </td>
                        </tr>
                    </table>
                  </form>

              <?php
            
            }
          }
      }
    }
}
else{
    ?>
    <form action="register.php">
        <table cellpadding="2" cellspacing="3" border="0" width="350px" >
            <tr>
                <td> Please Fill All Blanks ! </td>
                <td>
                    <button class="btn btn-success" type="submit">Again!</button>
                </td>
            </tr>
        </table>
    </form>
</div><?php
}
pg_close($conn);
?>
</body>
</html>