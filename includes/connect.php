<?php
$connect = mysql_connect('localhost','username','password');
if(!$connect){die('Could not connect to database!');}
mysql_select_db("stocks", $connect);
?>