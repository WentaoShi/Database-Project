<html>
  <head>
    <title>Homepage</title>
    <script type="text/javascript" src="js/dropdown.js"></script>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/mycss.css" rel="stylesheet" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Search Result.">
    <meta name="author" content="SL">
  </head>
<body>
<?php
include 'connect.php';

include("functions/alert.php");
    
    if (isset($_COOKIE['admin'])) {
        $admin = $_COOKIE['admin'];
    } else {
        $admin = "";
    }

include("functions/navi_bar.php");

$search= $_GET['search'];

    $sql7 = file_get_contents('./functions/fetch_friendList.sql', true);
    $sql8 = file_get_contents('./functions/fetch_FofList.sql', true);
    $sql9 = file_get_contents('./functions/fetch_reachedPersonNames.sql', true);
    pg_query($conn, $sql7);
    pg_query($conn, $sql8);
    pg_query($conn, $sql9);
    $sql_feedsDiary = file_get_contents('./functions/fetch_feeds.sql', true);
    pg_query($conn, $sql_feedsDiary); // procedure: FetchFeedsXXXX4Me

    $sql_reachedPerson_diary = "select * from FetchFeedsDiary4Me('{$admin}')";
    $query_reachedPersonDiaries = pg_query($conn, $sql_reachedPerson_diary);
    $reachedPersonDiaries = pg_fetch_all($query_reachedPersonDiaries);

    $sql_reachedPerson_media = "select * from FetchFeedsMedia4Me('{$admin}')";
    $query_reachedPersonMedia = pg_query($conn, $sql_reachedPerson_media);
    $reachedPersonMedia = pg_fetch_all($query_reachedPersonMedia);
  
echo "<div class='text-center'>";
echo "<font size=5>","<em>","Users result about '".$search."':</em>","</br>","</font>";
$sql="SELECT DISTINCT * from users where users.name like '%{$search}%' or users.username like '%{$search}%'"; 
$rs=pg_query($conn,$sql);
$num=pg_num_rows($rs);
if($num){
while($row=pg_fetch_array($rs)){	
		?>
    <table >
    <tr><em> User Name :</em> <?php echo $row['username']   ?></tr>
    <tr><em> Real Name :</em> <?php echo $row['name']   ?></tr>
    
    </table>
  <?php
}
}
else{
	echo "No User about '". $search ."'!";
}

echo "<font size=5>","<em>","<br>","Photos result about '".$search."':</em>","</br>","</font>";
$sql1="SELECT * from media, post_m where media.mid=post_m.mid and media.mid in (select mid from FetchFeedsMedia4Me('{$admin}'))
       and (media.title like '%{$search}%' or media.des_text like '%{$search}%')limit 5"; 
$rs1=pg_query($conn, $sql1);
if($rs1) {
$num1=pg_num_rows($rs1);
if($num1){
	?>
	<table cellpadding="2" cellspacing="5" border="0" width="700px">
	<tr><td><em> Pictures : </em></td>
  <td><em> title: </em></td>
  <td><em> describe:</em></td>
  <td><em> time: </em></td>
  <td><em> posted by:</em></td></tr>
 
  <?php   
  while($row=pg_fetch_array($rs1)){
 
$img=pg_unescape_bytea($row['photo']);
 $img2=base64_encode($img);
  ?>  
  
    <tr><td><img alt="10x10" class="img-responsive" src="data:image/jpg;charset=utf8;base64,<?php echo $img2 ?>" width="100px" height="100px" />
      </td>
      <td><?php echo $row['title'] ?></td>
      <td><?php echo $row['des_text'] ?></td>
      <td><?php echo $row['media_time'] ?></td>
      <td><?php echo $row['username'] ?></td></tr>
      <?php
     }  ?>    
    </table> <?php
  }
else{
	echo "No photo about '" . $search ."'!";
}
}

echo "<font size=5>","<em>","<br>","Diaries result about '".$search."':</em>","</br>","</font>";
$sql2="SELECT * from diary,post_d where diary.did= post_d.did and diary.did in (select did from FetchFeedsDiary4Me('{$admin}'))
       and (diary.title like '%{$search}%' or diary.body like '%{$search}%') limit 5"; 
$rs2=pg_query($conn,$sql2); 
$num2=pg_num_rows($rs2);
if($num2){
	?>
	<table cellpadding="3" cellspacing="5" border="0" width="500px">
    <tr><td><em>title: </em></td>
      <td><em>content: </em></td>
    <td><em>time: </em></td>
    <td><em>author: </em></td></tr>
  <?php     
  while($row=pg_fetch_array($rs2)){  ?>
        <tr>
      <td> <?php echo $row['title'] ?></td>
    <td> <?php echo $row['body'] ?></td>
    <td> <?php echo $row['diary_time'] ?></td>
    <td> <?php echo $row['username'] ?></td>
    </tr>   
    <?php } ?>     
    </table><?php
}
else{
	echo "No diary about '" . $search ."'!";
}

?>
<br></br></div>

</body>
</html>