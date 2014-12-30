<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);

// Pretty print some JSON
function json_format($json)
{
    $tab = "  ";
    $new_json = "";
    $indent_level = 0;
    $in_string = false;

    $json_obj = json_decode($json);

    if($json_obj === false)
        return false;

    $json = json_encode($json_obj);
    $len = strlen($json);

    for($c = 0; $c < $len; $c++)
    {
        $char = $json[$c];
        switch($char)
        {
            case '{':
            case '[':
                if(!$in_string)
                {
                    $new_json .= $char . "\n" . str_repeat($tab, $indent_level+1);
                    $indent_level++;
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case '}':
            case ']':
                if(!$in_string)
                {
                    $indent_level--;
                    $new_json .= "\n" . str_repeat($tab, $indent_level) . $char;
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case ',':
                if(!$in_string)
                {
                    $new_json .= ",\n" . str_repeat($tab, $indent_level);
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case ':':
                if(!$in_string)
                {
                    $new_json .= ":";
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case '"':
                if($c > 0 && $json[$c-1] != '\\')
                {
                    $in_string = !$in_string;
                }
            default:
                $new_json .= $char;
                break;
        }
    }

    return $new_json;
}

function format_number($number)
{
	return number_format($number, 0, ',', ' ');
}

function getSymbolByQuantity($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}

include('../connect.php');

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

// Get number of images from /hr/
$query = "SELECT count(id) FROM Image WHERE source_id = '4';";
$result = mysql_query($query) or die(mysql_error());
$hrCount = mysql_result($result, 0, 0);

$date = date('Y-m-d');
$query = "SELECT count(*) FROM Image where date_added > '" . $date . "';";
$result = mysql_query($query) or die(mysql_error());
$added = mysql_fetch_array($result);
$added = $added[0];
$hourly = round($added/(date("H")+1), 3);

// Get number of reported images
$query = "SELECT count(*) FROM Tag_Image WHERE tag_id = 176122";
$result = mysql_query($query) or die(mysql_error());
$reportCount = mysql_result($result, 0, 0);


// Return JSON data
$arr = array(
    'total count' => format_number($imageCount),
    'w count' => format_number($wCount),
    'wg count' => format_number($wgCount),
    'hr count' => format_number($hrCount),
    '7chan count' => format_number($wpCount),
    'report count' => format_number($reportCount),
    'added today' => format_number($added),
    'hourly' => format_number($hourly),
    'remaining disk space' => getSymbolByQuantity(disk_free_space("/home/nginx/site/4walled.cc/public_html"))
    );
header('Content-type: application/json');

echo json_format(json_encode($arr));
?>