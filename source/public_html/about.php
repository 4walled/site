<?php
include_once("common.php");
?>
<html>
<head>
<META NAME ="description" CONTENT="A wallpaper scraper for the popular 4chan and 7chan image boards">
<META name="Keywords" content="walls,wallpapers,customisations,custom,safe for work wallpapers,NSFW,4chan,7chan,wallpaper scraper,4scrape" />
<link rel="stylesheet" type="text/css" href="style.css" >
<script type="text/javascript" src="script.js"></script>
<?php include_once('header.php'); ?>
<br>
<div id="wrapper">
<div style="padding: 2em; max-width: 50em; line-height: normal;">
<ol>
    <li><a href="#Whatis">What is this site?</a></li>
    <li><a href="#How">How does this work?</a></li>
    <li><a href="#Who">Who run 4walled?</a></li>
    <li><a href="#Contact">Where do I report problems? or I have this great idea, who do I tell?</a></li>
    <li><a href="#Tagging">How do I tag images?</a></li>
    <li><a href="#4scrape">What happed to 4scrape?</a></li>
    <li><a href="#WhyAds">Why are there ads everywhere?</a></li>
</ol>    
    
<h1 id="Whatis">What is this site?</h1>
<p>If you're aware of the 4chan or 7chan imageboards,<br />
then you would be aware they have wallpaper boards.<br />
The problem with these boards is they are frequently clogged<br />
with people posting the same wallpapers over and over again,<br />
so this site downloads all the wallpapers posted on 4chan’s /w/, /hr/, and /wg/ boards<br />
and 7chan’s /wp/ board.<br />
It then stores the image in a database ready for you to search.<br />
Some images have no searchable features<br />
(for example, the filename is "1251193196442.jpg")<br />
and so these images need tagging.</p>

<h1 id="How">How does it work?</h1>
<p>4walled uses a script to look for images posted on the boards listed above.<br />
When it finds new images, it adds them to a searchable database.</p>

<h1 id="Who">Who runs it?</h1>
<p>The site is currently run and moderated by 4 individuals.<br />
You can find them on <a href="irc://irc.rizon.net/#4walled">IRC</a> as ThermalSloth, slashbeast, jonathan and ffMeta.<br />
ThermalSloth handles administrative tasks such as paying for the server and handling ads and donations.<br />
slashbeast is the primary server adminstrater and handles software configurations.<br />
jonathan is the primary developer,<br />
and is responsible for adding new features to the site and improving existing ones.<br />
ffMeta wrote the image scraper that is used to collect images from the boards.</p>

<h1 id="Contact">Where do I report problems?<br />
or<br />
I have this great idea, who do I tell?</h1>
<p>If the problem prevents you from viewing the site,<br />
then send us an email at <a href="mailto:admin@4walled.org?subject=I%20can%20not%20view%204walled">admin@4walled.org</a>.<br />
Other problems or suggestions either e-mail or drop by on the <a href="irc://irc.rizon.net/#4walled">IRC</a> channel and let us know.</p>

<h1 id="Tagging">How do I tag images?</h1>
<p>Whenever you search for images, it shows the results in a thumbnailed form.<br />
When you click on the thumbnail, an image detail page is loaded with a field where you can edit tags.<br />
There is also a report button to report images which either aren't wallpapers,<br />
are just plain stupid, or are illegal in most jurisdictions for wallpapers (e.g. gore, cp, bestiality).</p>

<h1 id="4scrape">What happened to 4scrape?</h1>
<p>See <a href="http://blog.desudesudesu.org/?p=1525" target="_blank">http://blog.desudesudesu.org/?p=1525</a> for the core of the matter.<br />
I chose not to use his code for the reasons he's mentioned as well.<br />
For anyone who has viewed it,<br />
they would also agree that it’s poorly documented so it's hard for other programmers to pick up and correct.</p>

<h1 id="WhyAds">Why are there ads everywhere?</h1>
<p>A valid question.<br />
The ads are there to help pay for the server costs (<a href="<?php echo $pagesrc; ?>donate.php">donating</a> helps more though).</p>
</div>
</div>
</body>
</html>
