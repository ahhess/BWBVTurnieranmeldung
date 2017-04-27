<?php
// Anzeige der Spieleranmeldungen für ein bestimmtes Turnier
session_start();
include("config.inc.php");
include("funktionen.inc.php");

if ($_POST["admin"])
	check_admin_login();
else
	check_login();

function spieler_markiert($id)
{
	print $id;
	if (in_array($id,$_POST["meldung"])) return true;
	else return false;
}

include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');	# create a connection
//$conn->debug=true;
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

//turnier holen
$sql='select tas_turnier.*,tas_turnierbeauftragter.vorname as ba_vorname, tas_turnierbeauftragter.nachname as ba_nachname, 
	tas_turnierbeauftragter.strasse as ba_strasse, tas_turnierbeauftragter.plz as ba_plz, tas_turnierbeauftragter.ort as ba_ort, 
	tas_turnierbeauftragter.telefon_priv as ba_telefon_priv, tas_turnierbeauftragter.telefon_gesch as ba_telefon_gesch, 
	tas_turnierbeauftragter.fax as ba_fax, tas_turnierbeauftragter.email as ba_email, tas_turnierbeauftragter.mobil as ba_mobil 
	FROM tas_turnier,tas_turnierbeauftragter 
	WHERE tas_turnier.turnierbeauftragter_id=tas_turnierbeauftragter.id 
	AND tas_turnier.id='.$_GET["id"];
$recordSet = &$conn->Execute($sql);
$turniere=$recordSet->GetArray();
$turnier=$turniere[0];

//meldungen holen
$sql='select tas_spieler.*, tas_vereine.davor, tas_vereine.name as verein, tas_meldung.partner as partner, tas_meldung.ak as ak 
	from tas_meldung,tas_spieler,tas_vereine
	where tas_meldung.spieler_id=tas_spieler.id 
	and tas_meldung.turnier_id='.$_GET["id"].' 
	and tas_meldung.verein_id=tas_vereine.id
	order by tas_meldung.ak asc, tas_spieler.geschlecht asc, tas_vereine.name, tas_vereine.davor, tas_meldung.partner, tas_spieler.nachname';
$recordSetSpieler = &$conn->Execute($sql);
$meldungen=$recordSetSpieler->GetArray();

//vereine holen
$sqlV='SELECT tas_vereine.name, tas_vereine.davor, COUNT( * ) AS vmeldcount
	FROM tas_meldung, tas_spieler, tas_vereine
	WHERE tas_meldung.turnier_id='.$_GET["id"].'
	AND tas_meldung.spieler_id = tas_spieler.id
	AND tas_meldung.verein_id = tas_vereine.id
	GROUP BY tas_vereine.name, tas_vereine.davor
	ORDER BY tas_vereine.name, tas_vereine.davor';
$recordSetVereine = &$conn->Execute($sqlV);
$vereine=$recordSetVereine->GetArray();
//print "<pre>";print_r($meldungen);

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->caching = false;
$smarty->assign('meldungen',$meldungen);
$smarty->assign('countMeldungen',count($meldungen));
$smarty->assign('vereine',$vereine);
$smarty->assign('countVereine',count($vereine));
$smarty->assign('turnier',$turnier);
$smarty->assign('datum',date('d.m.Y'));
$smarty->assign('zeit',date('G:i'));
$smarty->assign('admin',$_SESSION["admin"]);

if ($_GET["format"] == "csv")
	$smarty->display('csv.tpl.htm');
else
	$smarty->display('anzeige2.tpl.htm');
//print_r($meldungen);

$conn->Close(); # optional
?>
