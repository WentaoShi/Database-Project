<html>
    <head>
        <title>User Register</title>
        <script type="text/javascript" src="js/check.js"></script>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/register.css" rel="stylesheet">
    </head>
<body>
<div class="form-register">
<form action="insert.php" method="get" class="form-register">
    <table>
        <tr>
            <td colspan="2"><h2>Register</h2></td>
        </tr>
        <tr>
            <td class="form-left">User name *</td>
            <td>
                <input type="text" name="uname" class="form-control" placeholder="User Name" id="username"/>
                <span id="usernameMsg"></span>
            </td>
        </tr>
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
        <tr>
            <td>Name *</td>
            <td><input type="text" name="name" class="form-control" placeholder="Name" id="name"/><span id="nameMsg"></span></td>
        </tr>
        <tr>
            <td>Birthday *</td>
            <td>
                <input type="date" name="birthday" class="form-control" placeholder="Birthday" id="birthday"/>
            </td>
        </tr>
        <tr>
            <td>Gender *</td>
            <td><select name="gender" id="gender">
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                </select>
                <span id="genderMsg"></span>
            </td>
        </tr>

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

        <tr>
            <td>Email *</td>
            <td>
                <input type="text" name="email" class="form-control" placeholder="Email" id="email"/>
                <span id="email"></span>
            </td>
        </tr>

        <tr>
            <td>Personal information</td>
            <td>
                <textarea name="per_info" rows="10" cols="50"></textarea>
            </td>
        </tr>
        </table>
        </div>


        <table cellpadding="2" cellspacing="5" border="0" width="400px" >
        
        <tr>
            <td>
             <button class="btn btn-lg btn-success btn-block form-center" type="submit" onclick = "window.location.href='Get.php'">Submit</button>
            </td>
            </form>
            <form class="form-register">
            <td>
             <button class="btn btn-lg btn-danger btn-block form-next" type="button" onclick = "window.location.href='login.php'">Go back login!</button>
            </td>
        
        </tr>
        </table>
        </form>
        
</body>
</html>
