<?php
session_start();
include("config.inc.php");
include("funktionen.inc.php");
include("../adodb/adodb.inc.php");
check_admin_login();

$conn = &ADONewConnection('mysql');	
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$region = "NW";
if ($_SESSION["region"])
	$region = $_SESSION["region"];
if ($_POST["region"]){
	$region = $_POST["region"];
	$_SESSION["region"] = $region;
}

if ($_SESSION["vq"])
	$q = $_SESSION["vq"];
if ($_POST["q"]){
	$q = $_POST["q"];
	$_SESSION["vq"] = $q;
}

if ($_POST["suchen"] && $_POST["q"] != "") {
	$q = $_POST["q"];
	$sql="SELECT DISTINCT tas_vereine.* FROM tas_vereine
		LEFT OUTER JOIN tas_spieler ON tas_vereine.id = tas_spieler.id_vereine
		WHERE tas_vereine.region = '$region'
		AND (tas_vereine.name like '%$q%'
		OR tas_spieler.vorname like '%$q%'
		OR tas_spieler.nachname like '%$q%')
		ORDER BY region, name, davor";
} else {
	$sql="SELECT * FROM tas_vereine WHERE tas_vereine.region = '$region' ORDER BY region, name, davor";
}
//print_r("<pre>$sql</pre>");
$recordSet = &$conn->Execute($sql);
$liste = $recordSet->getArray();
$conn->Close();

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('liste',$liste);
$smarty->assign('menuakt','vereine.php');
$smarty->assign('admin',$_SESSION["admin"]);
$smarty->assign('pwdis',$_GET["pwdis"]);
$smarty->assign('q',$_POST["q"]);
$smarty->assign('region',$region);
$smarty->assign('regionen',$regionen);
$smarty->display('vereine.tpl.htm');
?>
