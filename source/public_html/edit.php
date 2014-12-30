<?php

function imageResize($width, $height, $target) {
    if ($width > $height) {
        $percentage = ($target / $width);
    } else {
        $percentage = ($target / $height);
    }
    $width = round($width * $percentage);
    $height = round($height * $percentage);
    return "width=\"$width\" height=\"$height\"";
}

include_once('common.php');

$id = mysql_real_escape_string($_GET['id']);

$query = "UPDATE Image SET downloads = downloads + 1 WHERE id = '$id';";
mysql_query($query);

$query = "SELECT md5, extension, Image.id, width, height, downloads, date_added, rating,
                 Source.name as board, Poster.name as postername, Poster.tripcode as posttrip
          FROM Image, Source, Poster
          WHERE Image.id = " . $id . " AND Source.id = Image.source_id AND  Poster.id = Image.poster_id;";
$result = mysql_query($query);
$missing = false;
if(mysql_num_rows($result) == 0) {
    $missing = true;
}
$imageData = mysql_fetch_assoc($result);

$width = $imageData["width"];
$height = $imageData["height"];


$query = "SELECT name, Tag.id FROM Tag, Tag_Image
          WHERE Tag_Image.image_id = " . $id . " AND Tag.id = Tag_Image.tag_id;";
$result = mysql_query($query);

while($data = mysql_fetch_array($result)) {
    if (isset($tags)) {
        $tags = $tags . ", " . $data['name'];
    } else {
        $tags = $data['name'];
    }
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>4walled - <?php if($missing) { echo "Missing Image!"; } else { echo "Image ".$imageData["id"]; } ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="robots" content="NoIndex, NoFollow" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/edit.js"></script>
</head>
<body>
<?php
if($missing) {
    echo "The image you requested does not exist.";
    echo "</body></html>";
    die;
}
?>
<div id="sidebar">
    Tagging 101<hr />
    <ol>
        <li>If it's a desktop, report it. Don't bother tagging it, I'll know if it's a desktop.</li>
        <li>If it's a screenshot of something like a browser or not wallpaper related, click report.</li>
        <li>If you don't know what it is, don't tag it.</li>
        <li>If you know what it is, tag it with words that you would use to find that image. Seperate multiple tags with a comma (e.g. rain, beach).</li>
    </ol>
</div>
<div id="lsidebar">
    Image Information<hr />
    <!-- <b>Original File Name:</b> <span id="info_imagename"><?php echo $imageData["imagename"]; ?></span><br /> -->
    <b>Resolution:</b> <span id="info_resolution"><?php echo $width . "x" . $height; ?></span><br />
    <b>Board:</b> <span id="info_board"><?php echo $imageData["board"]; ?></span><br />
    <b>Poster's Name:</b> <span id="info_postername"><?php echo $imageData["postername"]; ?></span><br />
    <b>Poster's Tripcode:</b> <span id="info_posttrip"><?php echo $imageData["posttrip"]; ?></span><br />
<b>Downloads:</b> <span id="info_downloads"><?php echo $imageData["downloads"]; ?></span><br />
    <b>Date Added:</b> <span id="info_dateadded"><?php echo $imageData["date_added"]; ?></span><br />
    <?php if ($imageData["rating"] == "") {
        $rating = "Not yet rated";
    } else {
        $rating = $sfwText[$imageData["rating"]];
    }
    ?>
    <b>SFW:</b> <span id="info_sfw"><?php echo $rating ?></span><br />
<div id="ajaxResponse"></div>
</div>
<div id="mainImage">
<a href="<?php echo $imgsrc . substr($imageData["md5"], 0, 2) . "/" . $imageData["md5"] . "." . $imageData["extension"]; ?>">
    <img alt="<?php echo $imageData["imagename"]; ?>" src="<?php echo $imgsrc . substr($imageData["md5"], 0, 2) . "/" . $imageData["md5"] . "." . $imageData["extension"]; ?>" <?php echo imageResize($width, $height, 600); ?> />
</a>
<br style="clear: both;" />
<p style="text-align: center;">
<strong>Please don't direct-link to images! To share use this URL:<br />
<?php
$printurl = "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
?>
<a href="<?php echo $printurl; ?>"><?php echo $printurl; ?></a></strong>
</p>

<form action="" method="post">
    Tags:
    <input type="text" name="tagsText" id="tagsText" size="40" value="<?php echo $tags; ?>" />
    <input type="submit" name="submit" value="Update Tags" onclick="reportAjax('updatetags', <?php echo $imageData["id"]; ?>); return false;" /><br />
    Tags separator is <strong>,</strong> (comma). So:<br />
    <strong>Good tags</strong>: "code geass, kallen, cc"<br />
    Wrong tags: "code geass kallen cc"
    <br />
    <br />Safe for work?
    <select name="sfwSelect" id="sfwSelect">
        <option <?php if($imageData["sfw"] == 0) { echo "selected=\"selected\" "; } ?>value="0">Safe for Work</option>
        <option <?php if($imageData["sfw"] == 1) { echo "selected=\"selected\" "; } ?>value="1">Borderline</option>
        <option <?php if($imageData["sfw"] == 2) { echo "selected=\"selected\" "; } ?>value="2">NSFW</option>
    </select>
    <input type="submit" name="submit" value="Update Rating" onclick="reportAjax('updaterating', <?php echo $imageData["id"]; ?>); return false;" /><br />
    <br />Desktop (screenshot) or porn?
    <input type="submit" value="Report" onclick="reportAjax('report', <?php echo $imageData["id"]; ?>); return false;" />
    <br /><a href="javascript:window.close()">Close page</a>
</form>
<br />
<!-- <b>Current Tags:</b><br /><span id="currentTags"><?php echo $tags; ?></span> -->
</div>
<?php
    // I had to do this for the ad income. For the greater good. Please don't hate me. :(
    if ($imageData["rating"] == 0 && !($imageData["rating"] === null)) {
    // if ($imageData["rating"] != 2) {
        include_once('ads.details.inc');
    }
?>
<?php include_once('google-stats.inc'); ?>
</body>
</html>
