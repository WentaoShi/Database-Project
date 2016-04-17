<?php
// Connecting, selecting database
$conn = pg_connect("host=pdc-amd01.poly.edu port=5432 dbname=ws1105 user=ws1105 password=^vmaszqw")
    or die('Could not connect: ' . pg_last_error());
?>