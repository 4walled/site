<?php 
include('connect.php');
$File = "feed.xml"; 
$Handle = fopen($File, 'w');
$Data = "<?xml version=".chr(34)."1.0".chr(34)."?>\n<rss version=".chr(34)."2.0".chr(34).">\n<channel>\n\n"; 
fwrite($Handle, $Data); 
$Data = "<title>4walled Image Feed</title>
<description>RSS Feed for </description>
<link>http://4walled.cc</link>\n";
fwrite($Handle, $Data); 
$date=date('Y-m-d');
$select = "SELECT * FROM file,searchdata where file.dateadded='$date'";
$res = mysql_query($select) or die(mysql_error());
while($data=mysql_fetch_array($res))
    { 
    $write="<item>
<title>".$data['file.filename']."</title>
<description>".$data['searchdata.imagename']."</description>
<link>http://4walled.cc/src/".$data['searchdata.filename']."</link>
<guid isPermaLink=".chr(34)."true".chr(34).">http://4walled.cc/src/".$data['searchdata.filename']."</guid>
</item>\n\n";   $filelist=$filelist." ".$data['searchdata.filename'];
    fwrite($Handle, $write); 
    }   echo $filelist;
    $write="</channel>\n</rss>";
    fwrite($Handle, $write); 
fclose($Handle); 
?>