<?php

include_once('connect.php');
include_once('common.php');

$offset = get_offset();
$search = get_mode();

if ($search == "random") {
    $select = make_search("Image, Tag, Tag_Image",
                          array("md5, extension, Image.id, width, height"),
                          get_search_parameters());

} elseif ($search == "search" and isset($offset)) {
    $select = make_search("Image, Tag, Tag_Image",
                          array("md5, extension, Image.id, width, height"),
                          get_search_parameters(),
                          $offset);

} else {
    $select = make_search("Image, Tag, Tag_Image",
                          array("md5, extension, Image.id, width, height"),
                          get_search_parameters(),
                          0);
    
}


list($usec, $sec) = explode(' ',microtime());
$querytime_before = ((float)$usec + (float)$sec);

//print_r($select);
$res = mysql_query($select) or die(mysql_error()."or this one");

$rec_count = mysql_num_rows($res);
if ($rec_count > 0) {
    //if ($search != "random")
    //{
    //    $thumbsrc = "http://4walled.cc.nyud.net/thumb/";
    //}
    while($data = mysql_fetch_array($res))
    {
        $thumbname = $data['md5'] . ".jpg";
        echo sprintf("\n\n<li class='image'><a href='%s' target='_blank'> <img alt='Missing!' src='%s' title='Aspect Ratio: %s    Resolution: %s'>",
             $pagesrc . "show-" . $data['id'],
             $thumbsrc . substr($thumbname, 0, 2) . "/" . $thumbname,
             round($data['width'] / $data['height'], 3),
             $data['width'] . "x" . $data['height']);
    
        echo "</a></li>";
    
    }
}
else
echo "<br /><center>This is the end of the internet! <img src=\"images/rageface.png\" /></center>";

?>
