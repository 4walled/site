<?php
include("./donatepage/cache.php");
$cachetime = 60 * 60;
// Serve from the cache if it is younger than $cachetime
if (file_exists('./donatepage/_cache_don4t3') && time() - $cachetime < filemtime('./donatepage/_cache_don4t3')) {
    include('./donatepage/_cache_don4t3');
//    echo "<!-- Cached copy, generated ".date('H:i', filemtime('./donatepage/_cache_don4t3'))." -->\n";
    exit;
}
ob_start(); // Start the output buffer

$arr = array("January","Febuary","March","April","May","June","July","August","September","October","November","December");

include('./donatepage/connect.php');

/*
$result = mysql_query("SELECT * FROM admin_test");
$row = mysql_fetch_assoc($result);
// Insert the money values here.
*/

include('./donatepage/values.php');
mysql_close();
?>

<html>
<head>
<?php include_once('header.php');?>
</head>
<body>
<center>
This is the part where you get to show that you love the work we put into this.<br>
We'll gladly accept any donations you send our way.
<br>

<?php /* Donations to Jonathan
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="8APXX7Y8JJNZQ">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form> */ ?>
<br />
<img src="./donate-bitches.png" />
<br />


<?php /* Donations to Joey (ThermalSloth) */ ?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="10980562">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

<?php /*
The values are automatically calculated to USD, GBP and EUR.
*/ ?>

<table>
<tr><td>Donations this month	</td><td>:</td><td>$<?php echo $value_donate; ?> </td><td>USD ~</td><td>€<?php echo $x->convert( $value_donate, 'USD', 'EUR' ); ?> </td><td>EUR</td></tr>
<tr><td>Ad revenue		</td><td>:</td><td>$<?php echo $x->convert( $value_ads, 'EUR', 'USD' ); ?> </td><td>USD ~</td><td>€<?php echo $value_ads; ?> </td><td>EUR</td></tr>
<tr><td>Total			</td><td>:</td><td>$<?php echo number_format($value_total,2, '.', ''); ?> </td><td>USD ~</td><td>€<?php echo $x->convert( $value_total, 'USD', 'EUR' ); ?> </td><td>EUR</td></tr>
<tr><td>Server costs		</td><td>:</td><td>$<?php echo $x->convert($value_costs, 'EUR', 'USD' ); ?> </td><td>USD ~</td><td>€<strong><?php echo $value_costs; ?></strong></td><td>EUR</td></tr>
<tr><td>Donations this month	</td><td>:</td><td><strong><?php echo $times_donated; ?></strong></td></tr>
<tr><td>Total donations received</td><td>:</td><td><strong><?php echo $total_times_donated; ?></strong></td></tr>
</table>

<table>
<?php
for ($i=0;$i<=11;$i++)
{	
	if ($value_month == $i+1)
	{
		printf("<tr><td>$arr[$i]</td><td>:</td><td><font color=\"#FF0000\"><blink>Next Payment</blink></font></td></tr>\n",$i+1,$arr[$i]);
	}
	elseif ($i+1 > $value_month)
	{
		printf("",$i+1,$arr[$i]);
	}
	else
	{
		printf("<tr><td>$arr[$i]</td><td>:</td><td><font color=\"#008000\">PAID</font></td></tr>\n",$i+1,$arr[$i]);
	}
}
?>
</table>

<br>All of the donations are greatly appreciated!
</form>
</center>
</body>
</html>

<?php
// Cache the output to a file
$fp = fopen('./donatepage/_cache_don4t3', 'w');
fwrite($fp, ob_get_contents());
fclose($fp);
ob_end_flush(); // Send the output to the browser
?>