<?php
function spielklasse_berechnen($mysql_date)
{
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

function get_new_smarty() {
	$smarty = new Smarty;
	$smarty->template_dir = '';
	$smarty->compile_dir = '../smarty/templates_c/';
	$smarty->config_dir = '../smarty/configs/';
	$smarty->cache_dir = '../smarty/cache/';
	return $smarty;
}

// für smarty
$spielklasse["U9"]="U9";
$spielklasse["U11"]="U11";
$spielklasse["U13"]="U13";
$spielklasse["U15"]="U15";
$spielklasse["U17"]="U17";
$spielklasse["U19"]="U19";
$spielklasse["ERW"]="ERW";

?>
