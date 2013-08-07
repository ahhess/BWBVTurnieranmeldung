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

// für smarty
$spielklasse["U9"]="U9";
$spielklasse["U11"]="U11";
$spielklasse["U13"]="U13";
$spielklasse["U15"]="U15";
$spielklasse["U17"]="U17";
$spielklasse["U19"]="U19";
$spielklasse["ERW"]="ERW";


/*
echo "86".spielklasse_berechnen("1986-12-12")."<p>";
echo "87".spielklasse_berechnen("1987-12-12")."<p>";
echo "88".spielklasse_berechnen("1988-12-12")."<p>";
echo "89".spielklasse_berechnen("1989-12-12")."<p>";
echo "90".spielklasse_berechnen("1990-12-12")."<p>";
echo "91".spielklasse_berechnen("1991-12-12")."<p>";
echo "92".spielklasse_berechnen("1992-12-12")."<p>";
echo "93".spielklasse_berechnen("1993-12-12")."<p>";
echo "94".spielklasse_berechnen("1994-12-12")."<p>";
echo "95".spielklasse_berechnen("1995-12-12")."<p>";
echo "96".spielklasse_berechnen("1996-12-12")."<p>";
echo "97".spielklasse_berechnen("1997-12-12")."<p>";
echo "98".spielklasse_berechnen("1998-12-12")."<p>";
echo "99".spielklasse_berechnen("1999-12-12")."<p>";
echo "2000".spielklasse_berechnen("2000-12-12")."<p>";
*/

//1994 u11
//1995 u11

?>
