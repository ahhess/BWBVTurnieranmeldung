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
if ($_GET["region"]) {
	$region = $_GET["region"];
	$_SESSION["region"] = $region;
}

unset($recordSet);
$sql="SELECT tas_turnier.id, tas_turnier.name_lang, tas_turnier.name_kurz, tas_turnier.datum_anmelden_ab, tas_turnier.datum_anmelden_bis,
		tas_turnier.datum, tas_turnier.ort, tas_turnier.email_an, tas_turnier.turnierbeauftragter_id, tas_turnier.region, tas_turnier.meldeliste, 
		tas_turnierbeauftragter.nachname, tas_turnierbeauftragter.vorname, 
	Count(tas_meldung.spieler_id) as meldungen
	FROM tas_turnier
	LEFT OUTER JOIN tas_turnierbeauftragter 
		ON tas_turnier.turnierbeauftragter_id = tas_turnierbeauftragter.id 
	LEFT OUTER JOIN tas_meldung 
		ON tas_turnier.id = tas_meldung.turnier_id 
	WHERE tas_turnier.region = '$region'
	Group by tas_turnier.id, tas_turnier.name_lang, tas_turnier.name_kurz, tas_turnier.datum_anmelden_ab, tas_turnier.datum_anmelden_bis,
		tas_turnier.datum, tas_turnier.ort, tas_turnier.email_an, tas_turnier.turnierbeauftragter_id, tas_turnier.region, tas_turnier.meldeliste, 
		tas_turnierbeauftragter.nachname, tas_turnierbeauftragter.vorname
	ORDER BY datum desc, name_lang";
$recordSet = &$conn->Execute($sql);
$liste = $recordSet->getArray();
$conn->Close();

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('liste',$liste);
$smarty->assign('menuakt','turniere.php');
$smarty->assign('admin',$_SESSION["admin"]);
$smarty->assign('region',$region);
$smarty->assign('regionen',$regionen);

$smarty->display('turniere.tpl.htm');
?>
