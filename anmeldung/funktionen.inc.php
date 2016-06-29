<?php

function spielklasse_berechnen($mysql_date) {
	$year=substr($mysql_date,0,4);
//
	if (date("m")>7) $ak_correct=date("Y")-$year+2;
	else $ak_correct=date("Y")-$year+1;
	if (ceil($ak_correct/2) == $ak_correct/2) $ak_correct+=1;
	//DEBUG echo "$mysql_date, U".$ak_correct."<br>";
	if ($ak_correct<9) return "";
	if ($ak_correct>19) return "ERW";
	return "U".$ak_correct;
}

function check_login() {
	if (!session_is_registered("verein") && !session_is_registered("admin")) 
		header("location: index.php");
}

function check_admin_login() {
	if (!session_is_registered("admin")) 
		header("location: admin.php");
}

function get_new_smarty() {
	$smarty = new Smarty;
	$smarty->template_dir = '';
	$smarty->compile_dir = '../smarty/templates_c/';
	$smarty->config_dir = '../smarty/configs/';
	$smarty->cache_dir = '../smarty/cache/';
	return $smarty;
}

/**
* date_mysql2german
* wandelt ein MySQL-DATE (ISO-Date)
* in ein traditionelles deutsches Datum um.
*/
function date_mysql2german($datum) {
	list($jahr, $monat, $tag) = explode("-", $datum);
	return sprintf("%02d.%02d.%04d", $tag, $monat, $jahr);
}

/**
* date_german2mysql
* wandelt ein traditionelles deutsches Datum
* nach MySQL (ISO-Date), in '' eingebettet.
* Wenn Eingabe leer, dann return null;
*/
function date_german2mysql($datum) {
	if($datum==""){
		return "null";
	} else {
		list($tag, $monat, $jahr) = explode(".", $datum);
		return sprintf("'%04d-%02d-%02d'", $jahr, $monat, $tag);
	}	
}

// für smarty
$spielklasse["U9"]="U9";
$spielklasse["U11"]="U11";
$spielklasse["U13"]="U13";
$spielklasse["U15"]="U15";
$spielklasse["U17"]="U17";
$spielklasse["U19"]="U19";
$spielklasse["ERW"]="ERW";

$regionen[0]="SO";
$regionen[1]="BW";
$regionen[2]="NB";
$regionen[3]="SB";
$regionen[4]="NW";
$regionen[5]="SW";
$regionen[6]="BBV";
$regionen[7]="BVS";
?>
