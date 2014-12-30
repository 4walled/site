<?php
include_once('header.php');
include_once('common.php');

    $help = TRUE;


?>


    <center>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.scrollTo.js"></script>
    <script type="text/javascript">
function checkScroll(initial) {

    if(($(window).scrollTop() == $(document).height()-$(window).height() || $(window).height() >= $(document).height()) && !loading) {
        loading = true;
        $("#loading").css("display", "block")

        content="<?php echo $_GET['content'];?>";
        coolface="<?php echo $_GET['dicks'];?>";
        random="<?php echo $_GET['random'];?>";
        board="<?php echo $_GET['board'];?>";
        res="<?php echo $_GET['rez'];?>";
        tags="<?php echo $_GET['tags'];?>";
        sfw="<?php echo $_GET['sfw'];?>";
        $.get("results.php?&lastID="+count+"&content="+content+"&dick="+coolface+"&random="+random+"&board="+board+"&rez="+res+"&tags="+tags+"&sfw="+sfw+"&help=true", function(data){
            $("#imageList").append(data)
            $("#loading").css("display", "none")
            $.scrollTo("-=1");
            count=count+30;
            if(initial === true) {
                $.scrollTo(0);
            }
            loading = false;
        });
    }
}
var loading = false;
var count=0;
$(document).ready(function () {
    checkScroll(true)
});
$(window).scroll(function() {
    checkScroll()
});
    </script>
<table class="sofT" cellspacing="0" border="0"id="dave" width="99%">
    <tr>
        <td colspan="6" class="helpHed" align="center">
            Search Result<br>Search took<?php  echo sprintf($strQueryTime, $querytime);?>
                <form method="GET" action="help.php">
                        <br>Filter:
                        <select name="board" id="board">
                            <option value="">All</option>
                            <option value="wg">/wg/</option>
			    <option value="hr">/hr/</option>
                            <option value="w">/w/</option>
                            <option value="7chan">7chan</option>
                        </select>
                        <input type="hidden" name="help" value="true">Randomize search?
                        <input type="checkbox" id=tags name="random" value="hRandom"';
               <?php if ($random=="hRandom"){
                    echo 'checked="yes">';
                } else {
                    echo ">";
                }?>
                <input type="submit" class="button" value="Filter"></form>

        </td>
    </tr>
</table>
<ul id="imageList"><!--Work of wintallo-->
<?php
    include("results.php");
?>
</ul>
<div id="loading" style="display: none">
    <img src="images/loading.gif" alt="Loading..." />
</div>
</center>
</body>
</html>
