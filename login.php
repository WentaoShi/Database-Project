<!DOCTPE html>
<html>
    <head>
        <title>User Login</title>
        <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/signin.css" rel="stylesheet">
    </head>
<body>
    <div class="container form-center" >
        <form class="form-signin" method="post" action="check.php">
        <h2 class="form-signin-heading">Please sign in:</h2><br>
        <label for="inputuname" class="sr-only">User Name: </label>
        <input type="text" id="uname" name="uname" class="form-control" placeholder="User Name" required autofocus>
        <label for="inputPassword" class="sr-only">Password </label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required><br><br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <tr>
        <td>
        </form>
        <form class="form-signin">
        <button class="btn btn-lg btn-success btn-block" type="button" onclick = "window.location.href='Register.php'">Register Now!</button>
        </td>
        </tr>
        </form>
        
        </div>

</body>
</html>



