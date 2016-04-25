<?php

//date_default_timezone_set('America/New_York');
$newTZ = new DateTimeZone("-04");
$systemTimeZone = system('date +%Z');

$date1 = new DateTime('08/16/2013', $newTZ);
$date2 = new DateTime('08/23/2013', $systemTimeZone);
$diff = $date1->diff($date2);
print_r($diff); // or $diff->days
?>