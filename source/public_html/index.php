<div id="wrapper">
<?php
include_once('header.php');
?>
<br>
<font size=3>
<center>
<p style="color:#D97E00;text-align:justify;"><!-- Announcements go here :p --></p>
<?php
include_once('searchform.php');
?>
</center>
<script type="text/javascript" language="javascript">
	document.getElementById("tags").focus();
</script>

<script type="text/javascript" src="ajax.js"></script>

<!-- <script type="text/javascript">
    function getScriptPage(div_id,content_id,get_count,board_id,rez,dongs,tags,sfw)
    {
        subject_id = div_id;
        board = document.getElementById(board_id).value;
        rez = document.getElementById(rez).value;
        tags = document.getElementById(tags).value;
        sfw = document.getElementById(sfw).value;
        if (get_count==1) http.open("GET", "count.php?content=" +content+"&count="+get_count+"&board="+board+"&rez="+rez+"&dongs="+dongs+"&tags="+tags+"&sfw="+sfw, true);
        if (get_count==0) window.location ="search.php?content=" +content+"&count="+get_count+"&board="+board+"&rez="+rez+"&dongs="+dongs+"&tags="+tags+"&sfw="+sfw;
        http.onreadystatechange = handleHttpResponse;
        http.send(null);
    }
</script> -->
<?php include_once('ads.frontpage.inc'); ?>
<?php include_once('google-stats.inc'); ?>
</div>
</body>
</html>
