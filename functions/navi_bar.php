<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Techies</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="home.php?uname=<?php echo $admin; ?>">Home <span class="sr-only">(current)</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Photo <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="gallery.php?uname=<?php echo $admin; ?>">Your Photos</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="choose_photo.php?uname=<?php echo $admin; ?>">Upload a photo</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Diary <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="diary_list.php?uname=<?php echo $admin; ?>">Your Diaries</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="write_diary.php?uname=<?php echo $admin; ?>">Write a Diary</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Friends <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="friend_request.php?uname=<?php echo $admin; ?>">Add Friends</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="friend_manager.php?uname=<?php echo $admin; ?>">Friend Manager</a></li>
          </ul>
        </li>
      </ul>





      <form class="navbar-form navbar-left" role="search">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Go!</button>
          </span>
        </div><!-- /input-group -->
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li> 
        <!-- get number of unread greeting -->
        <?php

          include("connect.php");
          $sql2="select * from greeting where username2 = '{$admin}' and status = 'unread';";  
          $greetingresult= pg_query($conn, $sql2);
          $alluread=pg_fetch_all($greetingresult);
          $unreadNum =count($alluread);

          if ($alluread == NULL) {
            echo "<a href='greeting.php?host={$admin}'>Greeting";
          } else {
            echo "<a href='greeting.php?host={$admin}&unread={$unreadNum}'>Greeting ";
            echo " <span class='badge'>{$unreadNum}</span>";
          }

        ?>

        </a>
        </li>
        <li><a href="newfeeds.php?uname=<?php echo $admin; ?>"><strong><span style="color:#FF717E">Feeds!</span></strong></a></li>
        <li><a href="logout.php?uname=<?php echo $admin; ?>">Log Out</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $admin ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Change Password</a></li>
            <li><a href="#">Change Profile</a></li>
            <li><a href="#">Change Address</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">About this website</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>