<?php
/*
#####################################################
Utility functions

FileName:   gallery_utils.php
Author:		Scott Upton, UPTONIC
Version:    2010.01.24
#####################################################
*/

// This function retrieves variable from URL
function getRequestField($field, $default = NULL) {
	return (isset($_REQUEST[$field] )) ? $_REQUEST[$field] : $default;
}

// RETURNS time left from supplied date ex. '3 days ago' etc. Basic function
function _ago($tm,$rcs = 0) {
    $cur_tm = time(); $dif = $cur_tm-$tm;
    $pds = array('second','minute','hour','day','week','month','year','decade');
    $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
    for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
   
    $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ago",$no,$pds[$v]);
    if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
    return $x;
}

// Order fields DESC
function orderDesc($array, $field) {
	$cmp = "return strcmp(\$b['$field'], \$a['$field']);";
	usort($array, create_function('$a,$b', $cmp));
	return $array;
}

// Order fields ASC
function orderAsc($array, $field) {
	$cmp = "return strcmp(\$a['$field'], \$b['$field']);";
	usort($array, create_function('$a,$b', $cmp));
	return $array;
}

// Order by date, then by filename usort($data, 'orderDateName');
function orderDateName($a, $b) {
	$retval = strnatcmp($b['path'], $a['path']);
	if(!$retval) return strnatcmp($a['file'], $b['file']);
	return $retval;
}

// Clean up the filname to get a nice title
function getImageTitle($image) {
	$aRead = explode(".", $image);
	$sFile = $aRead[0];
	$aTitle = explode("-", $sFile);
	
	$sTitle = $aTitle[1];					
	$sTitle = ucwords(preg_replace('/_|-/', ' ', $sTitle));
	
	return $sTitle;
}

// Clean up album, category names
function cleanName($name){
	$name = preg_replace('/_|-/', ' ', $name);
	return $name;
}
?>