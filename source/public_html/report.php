<?php

include('connect.php');

$id = mysql_real_escape_string($_GET["id"]);
$reported_id = 176122;

if($_GET["mode"] == "report") {
    $ip = $_SERVER["REMOTE_ADDR"];
    $query = "SELECT * FROM Tag_Image WHERE image_id = '" . $id . "' AND tag_id = '" . $reported_id . "';";
    $result = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($result) == 0) {
        $query = "INSERT INTO Tag_Image (image_id, tag_id) VALUES ('" . $id . "', '" . $reported_id . "');";
        mysql_query($query) or die(mysql_error());
        echo "You have successfully reported image " . $id . ". Thank you!";
    } else {
        echo "Image " . $id . " has already been reported. Thank you!";
    }
} elseif($_GET["mode"] == "updaterating") {
    $sfw = intval($_GET["sfw"]);
    if( $sfw >= 0 && $sfw <= 2) {
        $query = "UPDATE Image SET rating = '" . $sfw . "' WHERE id = '" . $id . "';";
        mysql_query($query) or die(mysql_error());
        echo "The rating for image $id has been updated. Thank you!";
    }
} elseif($_GET["mode"] == "updatetags") {
    $tags = mysql_real_escape_string(strip_tags($_GET["tags"]));
    if (sizeof($tags != 0)) {
        $query = "DELETE FROM Tag_Image WHERE image_id = '" . $id . "';";        
    }
    mysql_query($query) or die(mysql_error());
    foreach (explode(",", $tags) as $tag) {
        $tag = mysql_escape_string(trim($tag));
        if ($tag != "") {
            $query = "SELECT id FROM Tag WHERE name = '" . $tag . "';";
            $result = mysql_query($query) or die(mysql_error());
            if (mysql_num_rows($result) == 0) {
                $query = "INSERT INTO Tag (name) VALUES ('" . $tag . "')";
                mysql_query($query) or die(mysql_error());
                $query = "SELECT id FROM Tag WHERE name = '" . $tag . "';";
                $result = mysql_query($query) or die(mysql_error());
                $tagid = mysql_fetch_array($result);
                $tagid = $result[0];
                $query = "INSERT INTO Tag_Image (image_id, tag_id) VALUES ('" . $id . "', '" . $tagid . "')";
                mysql_query($query) or die(mysql_error());                    
            } else {
                $tagid = mysql_fetch_array($result);
                $tagid = $tagid[0];
                $query = "INSERT INTO Tag_Image (image_id, tag_id) VALUES ('" . $id . "', '" . $tagid . "')";
                mysql_query($query) or die(mysql_error());                    
            }
        }
    }
    echo "The tags for image $id have been updated. Thank you!";
}

?>