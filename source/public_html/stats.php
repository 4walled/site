<?php

    include('connect.php');
    
    // Get total number of images
    $query = "SELECT count(id) FROM Image;";
    $result = mysql_query($query) or die(mysql_error());
    $imageCount = mysql_result($result, 0, 0);
    
    // Get number of images from /w/
    $query = "SELECT count(id) FROM Image WHERE source_id = '1';";
    $result = mysql_query($query) or die(mysql_error());
    $wCount = mysql_result($result, 0, 0);

    // Get number of images from /wg/
    $query = "SELECT count(id) FROM Image WHERE source_id = '2';";
    $result = mysql_query($query) or die(mysql_error());
    $wgCount = mysql_result($result, 0, 0);

    // Get number of images from 7chan
    $query = "SELECT count(id) FROM Image WHERE source_id = '3';";
    $result = mysql_query($query) or die(mysql_error());
    $wpCount = mysql_result($result, 0, 0);

    // Get number of images from 7chan
    $query = "SELECT count(id) FROM Image WHERE source_id = '4';";
    $result = mysql_query($query) or die(mysql_error());
    $hrCount = mysql_result($result, 0, 0);

    $query = "SELECT md5, extension, width, height, downloads, id FROM Image WHERE `rating` = 0 ORDER BY downloads DESC LIMIT 0,20;";
    $ress = mysql_query($query) or die(mysql_error());

    $date = date('Y-m-d');
    $query = "SELECT md5, extension, width, height, id FROM Image ORDER BY id DESC LIMIT 0,1";
    $result = mysql_query($query) or die(mysql_error());
    $data = mysql_fetch_array($result);
    
    $latest = $data['id'];
    $latestrez = $data['width'] . "x" . $data["height"];
    $latestt = $data["md5"] . ".jpg";
    
    $query = "SELECT count(*) FROM Image where date_added > '" . $date . "';";
    $result = mysql_query($query) or die(mysql_error());
    $added = mysql_fetch_array($result);
    $added = $added[0];
    $hourly = round($added/(date("H")+1), 3);

?>  
<html>
<head>
<?php include_once('header.php');?>
<META NAME ="description" CONTENT="A wallpaper scraper for the popular 4chan and 7chan image boards">
<META name="Keywords" content="walls,wallpapers,customisations,custom,safe for work wallpapers,NSFW,4chan,7chan,wallpaper scraper,4scrape" />
</head>
<body><center>

    <table border="0" id=dave>
      <tr>
        <td width="400" height="109"><?php
    echo "Images in the database: $imageCount<br />";
    echo "Images from 4chan's /w/: $wCount<br />";
    echo "Images from 4chan's /wg/: $wgCount<br />";
    echo "Images from 7chan's /wp/: $wpCount<br />";
    echo "Images from 4chan's /hr/: $hrCount<br />";
    echo "Added Today: $added<br />";
    echo "Wallpapers/hour: $hourly<br />";
    //    echo "Total Downloads: $downloadCount<br />";
    ?>
        <td width="234" >Last Added:<br>
            <a href="<?php echo $linksrc . $latest; ?>"><img src="thumb/<?php echo substr($latestt, 0, 2) . "/" . $latestt;?>" alt="lolwat"></a><?php echo "<br>".$latestrez;?></td>
      
        
          <tr>
            <td height="109" colspan="5"><div align="center">20 Most Downloaded</div></td> </tr></td></tr>
    <?php 
    while($dldata=mysql_fetch_array($ress)) {
        if ($cols==4) {
            echo "<tr>";
        }
            echo "
                            <td><a href='" . $linksrc . $dldata['id'] . "' target='_blank'>
                            <img src='" . $thumbsrc . substr($dldata['md5'], 0, 2) . "/" . $dldata['md5'] . ".jpg'</a><br></a>
                            <br>Resolution: ".$dldata['width'] . "x" . $dldata['height'] ."</a>
                            <br>Downloads: ".$dldata['downloads']."
                            </td>
                            ";
if ($cols==3){echo "</tr>";$cols=-1;}
$cols+=1;
                }
                ?>  
      </table></center>
      </body>
      </html>
