<?php
ob_start();
include("./donatepage/connect.php");
include("./donatepage/cache.php");
$sql="UPDATE admin_test SET timesdonated=$_POST[d_times], totaltimesdonated=$_POST[d_t_times], donatedmoney=$_POST[d_cash], admoney=$_POST[ad_cash], monthpaid=$_POST[month], costs=$_POST[s_costs] WHERE id=1";

if (!mysql_query($sql))
{
  die('Error: ' . mysql_error());
}

mysql_close();

@unlink(_cache_don4t3);

header("Location: ./donate.php");
ob_end_flush();
?>