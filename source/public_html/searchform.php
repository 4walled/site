<div class="ajax-div">
    <div class="input-div">
    <form method="GET" action="search.php">
    <table border="0">
    <tr align="left">
      <td align="right">Keyword:</td>
      <td>(Multiple keywords can be used but are limited to "OR" operation right now)<br /><input type="text" id="tags" name="tags" size="40" onKeyUp="getScriptPage('count_display','text_content','1','board','rez',0,'tags','sfw')"></td>
      </tr>

    <tr align="left">
      <td align="right">Board:</td>
      <td><select name="board" id="board" onmouseup="getScriptPage('count_display','text_content','1','board','rez',0,'tags','sfw')">
        <option value="">All</option>
        <option value="2">/wg/</option>
	<option value="4">/hr/</option>
        <option value="1">/w/</option>
        <option value="3">7chan</option>
        </select></td>
    </tr>

    <tr align="left">
      <td align="right">Resolution:</td>
      <td>(sorted by width, larger screens are closer to the bottom of the list)<br />
      <select name="width_aspect" id="aspect" onmouseup="getScriptPage('count_display','text_content','1','board','rez',0,'tags','sfw')">
        <option value="">Any</option>
        <option value="1024x133">1024x768</option>
        <option value="1152x150">1152x768</option>
        <option value="1280x177">1280x720</option>
        <option value="1280x166">1280x768</option>
        <option value="1280x160">1280x800</option>
        <option value="1280x150">1280x854</option>
        <option value="1280x133">1280x960</option>
        <option value="1280x125">1280x1024</option>
        <option value="1366x177">1366x768</option>
        <option value="1400x133">1400x1050</option>
        <option value="1440x160">1440x900</option>
        <option value="1440x150">1440x960</option>
        <option value="1600x177">1600x900</option>
        <option value="1600x133">1600x1200</option>
        <option value="1680x160">1680x1050</option>
        <option value="1920x177">1920x1080</option>
        <option value="1920x160">1920x1200</option>
        <option value="2048x133">2048x1536</option>
        <option value="2560x237">2560x1080</option>
        <option value="2560x178">2560x1440</option>
        <option value="2560x160">2560x1600</option>
        <option value="2560x125">2560x2048</option>
        <option value="2048x266">2x 1024x768</option>
        <option value="2560x266">2x 1280x960</option>
        <option value="2560x250">2x 1280x1024</option>
        <option value="3360x320">2x 1680x1050</option>
        <option value="3150x188">3x 1680x1050 in portrait</option>
		<option value="3840x355">2x 1920x1080</option>
		<option value="5760x533">3x 1920x1080</option>
        <option value="3840x375">2x 1920x1024</option>
        <option value="1080x56">1920x1080 in portrait</option>
    </select></td>
    </tr>
    
    <tr align="left">
      <td align="right">Search Style:</td>
      <td>
      <span title='Search for images that are exactly this resolution'>
	<input type='radio' name='searchstyle' value='exact'>Exact</input></span>
      <span title='Search for images with the same aspect ratio and at least as wide'>
	<input type='radio' name='searchstyle' value='larger' checked='true'>Equal|Greater</input></span>
      <span title='Search for images that have the same aspect ratio regardless of size'>
	<input type='radio' name='searchstyle' value='aspect'>Same Aspect</input></span>
      </td>
    </tr>

    <tr align="left">
      <td align="right">SFW:</td>
      <td>
        <select name="sfw" id=sfw onmouseup="getScriptPage('count_display','text_content','1','board','rez',0,'tags','sfw')">
            <option value="" selected="selected">All</option>
            <option value="-1">Unrated</option>
            <option value="0">Safe for Work</option>
            <option value="1">Borderline</option>
            <option value="2">NSFW</option>
            </select></td>
      </tr>
<tr align="left">
        <td width="139" align="right"></td>
        <td align="center">
            <input type="submit" class="button" name="search" value="search">
            <input type="submit" class="button" name="search" value="random">
        </td>
    </tr>
    </table>
</form>
        <div id="count_display">

        </div>
    </div>
