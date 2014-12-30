<?php
$conn = mysql_connect("HOST","USERNAME","PASSWORD") or die("could not connect to server");
 mysql_select_db("DATABASE NAME",$conn) or die("could not connect to database".mysql_error());
?>