<?php

$username = 'root';
$password = '';
$dbname = 'se-project-z';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$main_db = new mysqli('localhost' , $username , $password , $dbname);

?>
