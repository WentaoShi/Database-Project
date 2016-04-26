<?php

function setAlertWithBackButton($text, $button) {
	echo "<div class='alert alert-danger' role='alert'><center><strong>{$text}</strong></center></div><br><center><button type='button' class='btn btn-info btn-lg' onClick='history.go(-1);return true;'>{$button}</button></tr></center>";
}

function setAlert($text) {
	echo "<div class='alert alert-danger' role='alert'><center><strong>{$text}</strong></center></div>";
}

function setSuccessAlert($text) {
	echo "<div class='alert alert-success' role='alert'><center><strong>{$text}</strong></center></div>";
}

function setSuccessAlertWithBackButton($text, $button, $uname) {
	echo "<div class='alert alert-success' role='alert'><center><strong>{$text}</strong></center></div><br><center>

<a href='home.php?uname={$uname}' class='btn btn-success btn-lg' role='button'>{$button}</a>

	</tr></center>";

}

function setSuccessAlertWithHistoryBackButton($text, $button) {
	echo "<div class='alert alert-success' role='alert'><center><strong>{$text}</strong></center></div><br>
	<center><button type='button' class='btn btn-info btn-lg btn-block' onClick='history.go(-1);return true;'>{$button}</button></tr></center>";

}

function setYellowAlert($text) {
	echo "<div class='alert alert-warning' role='alert'><center><strong>{$text}</strong></center></div>";
}

  ?>
