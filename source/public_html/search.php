<?php

include_once('header.php');
//include_once('common.php');

if (is_null($offset)) {
    $offset = 30;
}
$url = sprintf("results.php?search=%s&board=%s&width_aspect=%s&tags=%s&searchstyle=%s&sfw=%s&offset=",
              htmlspecialchars(get_mode()),
              htmlspecialchars($_GET['board']),
              htmlspecialchars($_GET['width_aspect']),
              htmlspecialchars($_GET['tags']),
              htmlspecialchars($_GET['searchstyle']),
              htmlspecialchars($_GET['sfw']))
?>
<?php
    echo "<!-- LOOK " . $_GET['sfw'] . " " . !($_GET['sfw'] === null) . " -->";
    if ($_GET['sfw'] == 0 && !($_GET['sfw'] === null) && !($_GET['sfw'] === "")) {
        include_once('ads.results.inc');
    }
?>
<?php include_once('google-stats.inc'); ?>
    <center>
    <script type="text/javascript">
function checkScroll(initial) {
    //console.log(($(window).scrollTop() + " == " + $(document).height() + " - " + $(window).height() + " || " + $(window).height() + " >= " + $(document).height()) + " && " + !loading);
    if(($(window).scrollTop() > $(document).height()-$(window).height()-10 || $(window).height() >= $(document).height()) && !loading) {
        loading = true;
        $("#loading").css("display", "block")
        //alert(<?php echo "'" . $url . "'"; ?> + (<?php echo $offset; ?> + checkScroll.count))
        $.get(<?php echo "'" . $url . "'"; ?> + (<?php echo $offset; ?> + checkScroll.count) , function(data){
            $("#imageList").append(data)
            $("#loading").css("display", "none")
            checkScroll.count += 30;
            if (data.indexOf("This is the end of the internet!") == -1) {
                //Don't reset loading to keep from repeating the above phrase
                loading = false;
            }
        });
    }
}
var loading = false;
checkScroll.count = 0;
$(document).ready(function () {
    checkScroll(true)
});
$(window).scroll(function() {
    checkScroll()
});
    </script>

<ul id="imageList"><!--Work of wintallo-->
<?php include("results.php"); ?>
</ul>
<div id="loading" style="display: none">
    <img src="images/loading.gif" alt="Loading..." />
</div>
</center>
</body>
</html>
