<?php
// Connecting, selecting database
$conn = pg_connect("host=pdc-amd01.poly.edu port=5432 dbname=yy1533 user=yy1533 password=gaw2^9qj")
    or die('Could not connect: ' . pg_last_error());
?>