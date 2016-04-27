<html>
    <?php
    include("connect.php");
    include("functions/alert.php");
    $type = $_GET['change'];
    if (isset($_COOKIE['admin'])) {
        $admin = $_COOKIE['admin'];
    } else {
        setAlert("Please log in.");
        echo "<div class='text-center'><a href='login.php?' class='btn btn-success btn-lg' role='button'>Go Log in!</a></div>";
        die;
    }
    include("functions/navi_bar.php");

    ?>
    <head>
        <title>Change Information</title>
        <script type="text/javascript" src="js/check.js"></script>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
    </head>
<body>
<div class="form-register">
<form action="up_change.php" method="post" class="form-register" id="form">
    <table>
        <tr>
            <td colspan="2"><h2>Change Information</h2></td>
        </tr>



    <?php

    switch ($type) {
        case 'pwd':
            ?>
        <tr>
            <td>Password *</td>
            <td>
                <input type="password" name="password" class="form-control" placeholder="Password" id="password"/>
                <span id="passwordMsg"></span>
            </td>
        </tr>
        <tr>
            <td>Password confirm *</td>
            <td>
                <input type="password" name="passwordn" class="form-control" placeholder="Password confirm" id="confirm"/>
                <span id="confirmMsg"></span>
            </td>
        </tr>
              <?php
            break;
        case 'name':
            ?>
        <tr>
            <td>Name<br> (This is not your username)</td>
            <td><input type="text" name="name" class="form-control" placeholder="Name" id="name"/><span id="nameMsg"></span></td>
        </tr>
              <?php
            break;
        case 'email':
            ?>
        <tr>
            <td>Email *</td>
            <td>
                <input type="text" name="email" class="form-control" placeholder="Email" id="email"/>
                <span id="email"></span>
            </td>
        </tr>
              <?php
            break;
        case 'profile':
            ?>
        <tr>
            <td>Say Somethin' about yourself<br>(Your profile)</td>
            <td>
                <textarea name="saying" rows="2" cols="40"></textarea>
            </td>
        </tr>
              <?php
            break;
        case 'address':
            ?>
        <tr>
            <td>State</td>
            <td><select name="state" id="state">
            <option value="AL">AL</option>
                    <option value="AK">AK</option>
                    <option value="AZ">AZ</option>
                    <option value="AR">AR</option>
                    <option value="CA">CA</option>
                    <option value="CO">CO</option>
                    <option value="CT">CT</option>
                    <option value="DE">DE</option>
                    <option value="FL">FL</option>
                    <option value="GA">GA</option>
                    <option value="HI">HI</option>
                    <option value="ID">ID</option>
                    <option value="IL">IL</option>
                    <option value="IN">IN</option>
                    <option value="IA">IA</option>
                    <option value="KS">KS</option>
                    <option value="KY">KY</option>
                    <option value="LA">LA</option>
                    <option value="ME">ME</option>
                    <option value="MD">MD</option>
                    <option value="MA">MA</option>
                    <option value="MI">MI</option>
                    <option value="MN">MN</option>
                    <option value="MS">MS</option>
                    <option value="MO">MO</option>
                    <option value="MT">MT</option>
                    <option value="NE">NE</option>
                    <option value="NV">NV</option>
                    <option value="NH">NH</option>
                    <option value="NJ">NJ</option>
                    <option value="NM">NM</option>
                    <option value="NY">NY</option>
                    <option value="NC">NC</option>
                    <option value="ND">ND</option>
                    <option value="OH">OH</option>
                    <option value="OK">OK</option>
                    <option value="OR">OR</option>
                    <option value="PA">PA</option>
                    <option value="RI">RI</option>
                    <option value="SC">SC</option>
                    <option value="SD">SD</option>
                    <option value="TN">TN</option>
                    <option value="TX">YX</option>
                    <option value="UT">UT</option>
                    <option value="VT">VT</option>
                    <option value="VA">VA</option>
                    <option value="WA">WA</option>
                    <option value="WV">WV</option>
                    <option value="WI">WI</option>
                    <option value="WY">WY</option>


                </select>
                <span id="genderMsg"></span>
            </td>
        </tr>

        <tr>
            <td>City *</td>
            <td>
                <input type="text" name="city" class="form-control" placeholder="City" id="city"/>
                <span id="city"></span>
            </td>
        </tr>

        <tr>
            <td>Street</td>
            <td>
                <input type="text" name="street" class="form-control" placeholder="Street" id="street"/>
                <span id="street"></span>
            </td>
        </tr>
              <?php
        default:
            # code...
            break;
    }

    ?>

        </table>
        </div>


<div class="text-center">

            <input type="submit" value="&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;" name="submit" class="btn btn-lg btn-success">

            </form>


<button type='button' class='btn btn-info btn-lg' onClick='history.go(-1);return true;'>Go Back</button>
        

</div>
  <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>   
        
</body>
</html>
