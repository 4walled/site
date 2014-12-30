<?php

include('connect.php');

/****************************
 *
 * GLOBAL SETTINGS GO HERE!
 *
****************************/

// Text used to describe how much trouble you could get in for looking at an
// image in a work environment.
$sfwText = array('Safe For Work', 'Borderline', 'NSFW');

// Settings handy for my test server (jonstew1983) and also allows offloading
// database work with having to copy all the image data as well (if thats
// something that ever happens)
// These must end with a "/"

// Base URL for all image data
$imgsrc = "http://4walled.cc/src/";
$thumbsrc = "http://4walled.cc/thumb/";
$linksrc = "http://4walled.cc/show-";

// Base URL for all page links
$pagesrc = "http://4walled.cc/";

/* END OF GLOBAL SETTINGS */

/*
 * Validate input
 */

// check that a variable is set and has one of a list of expected values
function check_var($varname, $expected_values) {
    if (!isset($_GET[$varname])) {
        return NULL;
    } elseif (in_array($_GET[$varname], $expected_values)) {
        return $_GET[$varname];
    } else {
        die("$varname not set to an expected value!'" . print_r($_GET[$varname], TRUE) ."'");
    }
}

// check that a variable is set and is a number
function check_var_numeric($varname) {
    if ((!isset($_GET[$varname])) or $_GET[$varname] == "") {
        return NULL;
    } elseif (is_numeric($_GET[$varname])) {
        return $_GET[$varname];
    } else {
        die("$varname not set to an expected value!'" . print_r($_GET, TRUE) ."'");
    }
}

function get_offset() {
    return check_var_numeric('offset');
}

function get_mode() {
    return check_var('search', array("random", "search"));
}

function get_search_parameters() {
    $board = check_var_numeric('board');
    $valid_resolutions = array("",
        "1024x133", "1152x150", "1280x177", "1280x166", "1280x160", "1280x150",
        "1280x133", "1280x125", "1366x177", "1400x133", "1440x160", "1440x150",
        "1680x160", "1600x133", "3840x355", "1920x177", "1920x160", "2560x178",
        "2560x160", "2560x125", "2048x266", "2560x266", "2560x250", "3360x320",
        "3150x188");
        
    $width_aspect = check_var('width_aspect', $valid_resolutions);

    $width = split("x", $width_aspect);
    $width = intval($width[0]);
    $aspect = split("x", $width_aspect);
    $aspect = intval($aspect[1]);
    $searchstyle = check_var('searchstyle', array('exact', 'larger', 'aspect'));
    $sfw = check_var_numeric('sfw');
    
    
    if (isset($_GET['tags']) and $_GET['tags'] != "") {
        $tags = $_GET['tags'];
    } else {
        $tags = NULL;
    }
    
    $ip = getenv("REMOTE_ADDR");
    
    return array("tags" => $tags,
                "board" => $board,
                "width" => $width,
                "aspect" => $aspect,
                "searchstyle" => $searchstyle,
                "res" => $res,
                "sfw" => $sfw);

}

function get_row_count($condition = NULL) {
    $select = "select COUNT(*) from Image ";
    if ($condition <> NULL) {
        $select .= $condition;
    }

    $row = mysql_fetch_row(mysql_query($select));
    return $row[0];
}


function make_search($table, $columns, $keywords, $offset = -1){
    $select = "SELECT DISTINCT ";
    $counter = 0;
    $first = TRUE;

    if (count($columns) == 0) {
        die("Invalid parameter passed to make_query()");
    } else {
        // count($columns) - 1 to special case last item without comma
        for ($counter = 0; $counter < (count($columns) - 1); $counter++){
            $select .= $columns[$counter] . ', ';
        }
        $select .= $columns[$counter];
    }


    $tags = array();
    if (isset($keywords["tags"]) and $keywords["tags"] != "") {
        $tag_clause = " AND Tag.id = Tag_Image.tag_id
                        AND Image.id = Tag_Image.image_id
                        AND Match(Tag.name) AGAINST ('";
        foreach (explode(",", $keywords["tags"]) as $tag) {
            $tag = trim($tag);
            if ($tag != "") {
                $tags[] = mysql_real_escape_string($tag);
            }
        }
        $tag_clause .= implode(" ", $tags) . "') ";
        $select .= " FROM " . $table . " WHERE ";
    } else {
        $select .= " FROM Image WHERE ";
    }



    //$select .= " FROM " . $table . " WHERE ";
    $params = array();
    $board = $keywords["board"];
    if ($board <> "") {
        $params[] = array("AND", "source_id", $board);
    }

    if (isset($keywords["width"]) and $keywords["width"] != "") {
        $params[] = array("BETWEEN", "Image.aspect_ratio", $keywords["aspect"] - 9, $keywords["aspect"] + 9);            
        
        if ($keywords['searchstyle'] == 'exact') {
            $params[] = array("BETWEEN", "Image.width", $keywords["width"] * .95, $keywords["width"] * 1.05);
        
        } else if ($keywords['searchstyle'] == 'larger') {
            $params[] = array(">", "Image.width", $keywords["width"] * .95);
        }
        // else already checking aspect...
    }

    $sfw = $keywords["sfw"];
    if ($sfw <> "") {
        if ($sfw == -1) {
            $params[] = array("NULL", "rating");
        } else {
            $params[] = array("AND", "rating", $sfw);
        }
    }

    if ($offset == -1) {
        $query_offset = rand(1, get_row_count());
        $params[] = array("<", "Image.id", $query_offset);
        $select .= make_where_clause($params);
        $select .= $tag_clause;
        $select .= " ORDER BY Image.id DESC LIMIT 30;";
    } else {
        $params[] = array(">", "Image.id", 0);
        //print_r($params);
        //print make_where_clause($params);
        //print "<br />";
        $select .= make_where_clause($params);
        // Queries get slower as $offset gets larger, however unless someone
        // intentionally send a huge offset this number is limited by the maximum
        // amount someone scrolls a page and should not become large enough
        // to be an issue.
        $select .= $tag_clause;
        $select .= " ORDER BY Image.id DESC LIMIT 30 OFFSET " . $offset;
    }

    //print_r($select);
    return $select;

}

function escape_clause($op, $param1, $param2) {

    return " " . $param1 . " " . $op . " '" . mysql_real_escape_string($param2) . "' ";
}

function make_where_clause($where_params) {

    $first = "";
    $where = "";

    if (count($where_params) > 0) {
        foreach ($where_params as $param) {
            if ($param[0] == "AND") {
                $where .= $first . escape_clause("=", $param[1], $param[2]);
                $first = " AND ";
            } elseif ($param[0] == "OR") {
                $orfirst = "";
                $where .= $first . " (";
                for ($counter = 0; $counter < count($param[2]); $counter++){
                    $where .= $orfirst . escape_clause("=", $param[1], $param[2][$counter]);
                    $orfirst = " OR ";
                }
                $where .= ") ";
                $first = " AND ";
            } elseif ($param[0] == "NULL") {
                $where .= $first . mysql_escape_string($param[1]) . " IS NULL ";
                $first = " AND ";
            } elseif ($param[0] == "NOT") {
                $where .= $first . escape_clause("!=", $param[1], $param[2]);
                $first = " AND ";
            } elseif ($param[0] == ">") {
                //print_r($param);
                $where .= $first . escape_clause(">", $param[1], $param[2]);
                $first = " AND ";
            } elseif ($param[0] == "<") {
                $where .= $first . escape_clause("<", $param[1], $param[2]);
                $first = " AND ";
            } elseif ($param[0] == "LIKE") {
                $where .= $first . escape_clause("LIKE", $param[1], "%" . $param[2] . "%");
                $first = " AND ";
            } elseif ($param[0] == "BETWEEN") {
                $where .= $first . " " . $param[1] . " BETWEEN " . $param[2] . " AND " . $param[3] . " ";
                $first = " AND ";
            }
        }
    }
    return $where;
}
