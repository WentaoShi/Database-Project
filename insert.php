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

      $uname = $_POST['uname'];
      $password = $_POST['password'];
      $name = $_POST['name'];
      $birthday = $_POST['birthday'];
      $passwordn=$_POST['passwordn'];
      $gender=$_POST['gender'];
      $state=$_POST['state'];
      $city=$_POST['city'];
      $street=$_POST['street'];
      $email=$_POST['email'];
      $saying = $_POST['per_info'];
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

            $options = [
                'cost' => 11,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $hash_pwd = password_hash($password, PASSWORD_BCRYPT, $options);

            $sql = "INSERT INTO users VALUES
            ('$_POST[uname]', '{$hash_pwd}', '$_POST[name]', '$_POST[gender]', '$_POST[birthday]', '$_POST[state]','$_POST[city]',  '$_POST[street]', '$_POST[email]');";
            if (!pg_query($conn, $sql)){
                die(pg_last_error());
            }

            $pid = uniqid();
            $encode_content = htmlspecialchars($saying, ENT_QUOTES);
            $sql_saying = "INSERT INTO profile VALUES ('{$pid}', '{$encode_content}', current_timestamp);";
            if (!pg_query($conn, $sql_saying)){
                die(pg_last_error());
            }
            $sql2 = "INSERT INTO post_p VALUES ('{$uname}', '{$pid}');";

            if (!pg_query($conn, $sql2)){
               die(pg_last_error());
            }
              
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