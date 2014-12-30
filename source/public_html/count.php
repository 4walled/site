<?php
    // You can do anything with the data. Just think of the possibilities!
include('common.php');

$select = make_search("searchdata",
               array("COUNT(*)"),
               $criteria,
               0);

$res = mysql_query($select) or die(mysql_error());
$rec_count = mysql_fetch_array($res);
if(TRUE)
{
  echo "There are ".$rec_count[0]." matching records found. Click Search to view result.";
}

?>
