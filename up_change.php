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
        include("functions/alert.php");
    if (isset($_COOKIE['admin'])) {
        $admin = $_COOKIE['admin'];
    } else {
        setAlert("Please log in.");
        echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
        die;
    }
    // include("functions/navi_bar.php");

      $name = isset($_POST['name']) ? $_POST['name'] : "";
      $password = isset($_POST['password']) ? $_POST['password'] : "";
      $passwordn= isset($_POST['passwordn']) ? $_POST['passwordn'] : "";

      $state=isset($_POST['state']) ? $_POST['state'] : "";
      $city=isset($_POST['city']) ? $_POST['city'] : "";
      $street=isset($_POST['street']) ? $_POST['street'] : "";
      $email=isset($_POST['email']) ? $_POST['email'] : "";
      $saying = isset($_POST['saying']) ? $_POST['saying'] : "";

      $visib_d = isset($_GET['visib']) ? $_GET['visib'] : "";
      $did_d = isset($_GET['did']) ? $_GET['visib'] : "";

      if (isset($_GET['did'])) {
        $did = $_GET['did'];
        $visib_d = isset($_GET['visib']) ? $_GET['visib'] : "";
        $author = isset($_GET['uname']) ? $_GET['uname'] : "";
        if ($author == $admin) {
          $sql="UPDATE diary SET visib = '{$visib_d}' where did='{$did}'";
          if (!pg_query($conn, $sql)){
            die(pg_last_error());
          }
          else{
            header("location: display_diary.php?uname={$author}&did={$did}");
          }
        }
      }

      if (isset($_GET['mid'])) {
        $mid = $_GET['mid'];
        $visib_m = isset($_GET['visib']) ? $_GET['visib'] : "";
        $author = isset($_GET['uname']) ? $_GET['uname'] : "";
        $file_name = isset($_GET['file']) ? $_GET['file'] : "";
        if ($author == $admin) {
          $sql="UPDATE media SET visib = '{$visib_m}' where mid='{$mid}'";
          if (!pg_query($conn, $sql)){
            die(pg_last_error());
          }
          else{
            header("location: display_pic.php?uname={$author}&mid={$mid}&file={$file_name}");
          }
        }
      }

      if (!empty($password) && !empty($passwordn))
      {
        if($password!=$passwordn){
         ?>
            <table cellpadding="2" cellspacing="3" border="0" width="350px" >
                <tr>
                    <td> Two Passwords doesn't match ! </td>
                    <td>
                        <button class="btn btn-success" type="submit" onClick='history.go(-1);return true;'>Again</button>
                    </td>
                </tr>
            </table>
        <?php
        } else {
          $options = [
                'cost' => 11,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $hash_pwd = password_hash($password, PASSWORD_BCRYPT, $options);
          $sql="UPDATE users SET pwd = '{$hash_pwd}' where username='{$admin}'";
          if (!pg_query($conn, $sql)){
                die(pg_last_error());
            }
            else{
              setcookie("admin", NULL, time()-3600);
              
                ?>
                 <form action="login.php">
                    <table cellpadding="2" cellspacing="3" border="0" width="350px" >
                        <tr>
                            <td> You have successfully changed your password! </td>
                            <td>
                                <button class="btn btn-success" type="submit">TO LOGIN!</button>
                            </td>
                        </tr>
                    </table>
                  </form>

              <?php
            
            }

        }
    } // if pwd !empty

    if (!empty($email)) {
      $sql="UPDATE users SET email = '{$email}' where username='{$admin}'";
            if (!pg_query($conn, $sql)){
                die(pg_last_error());
            }
            else{              
                ?>
                    <table cellpadding="2" cellspacing="3" border="0" width="350px" >
                        <tr>
                            <td> You have successfully changed your email! </td>
                            <td>
                                <a href="home.php?uname=<?php echo $admin; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>
                            </td>
                        </tr>
                    </table>

              <?php
            
            }
    } // if email !empty

    if (!empty($name)) {
      $sql="UPDATE users SET name = '{$name}' where username='{$admin}'";
            if (!pg_query($conn, $sql)){
                die(pg_last_error());
            }
            else{              
                ?>
                    <table cellpadding="2" cellspacing="3" border="0" width="350px" >
                        <tr>
                            <td> You have successfully changed your name! </td>
                            <td>
                                <a href="home.php?uname=<?php echo $admin; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>
                            </td>
                        </tr>
                    </table>

              <?php
            
            }
    } // if email !empty

    if (!empty($saying)) {
      $pid = uniqid();
      $encode_content = htmlspecialchars($saying, ENT_QUOTES);
      $sql = "INSERT INTO profile VALUES ('{$pid}', '{$encode_content}', current_timestamp);";
      $sql1 = "INSERT INTO post_p VALUES ('{$admin}', '{$pid}');";
           if (!pg_query($conn, $sql)){
                die(pg_last_error());
            }
            if (!pg_query($conn, $sql1)){
                die(pg_last_error());
            }

                ?>
                    <table cellpadding="2" cellspacing="3" border="0" width="350px" >
                        <tr>
                            <td> You have successfully changed your saying (profile)! </td>
                            <td>
                                <a href="home.php?uname=<?php echo $admin; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>
                            </td>
                        </tr>
                    </table>

              <?php
            

    } // if saying !empty

    if (!empty($state) || !empty($city) || !empty($street)) {
      $sql="UPDATE users SET state = '{$state}', city = '{$city}', street = '{$street}' where username='{$admin}'";
            if (!pg_query($conn, $sql)){
                die(pg_last_error());
            }
            else{              
                ?>
                    <table cellpadding="2" cellspacing="3" border="0" width="350px" >
                        <tr>
                            <td> You have successfully changed your email! </td>
                            <td>
                                <a href="home.php?uname=<?php echo $admin; ?>" class="btn btn-success btn-lg" role="button">Go Back home!</a>
                            </td>
                        </tr>
                    </table>

              <?php
            
            }
    } // if address !empty


pg_close($conn);
?>
</body>
</html>