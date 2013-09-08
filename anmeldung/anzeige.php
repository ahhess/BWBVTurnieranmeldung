<?php
// Anzeige der Spieleranmeldungen für ein bestimmtes Turnier
session_start();
if (!session_is_registered("verein")) header("location: index.php");

include("config.inc.php");
include("funktionen.inc.php");

function spieler_markiert($id)
{
	print $id;
	if (in_array($id,$_POST["meldung"])) return true;
	else return false;
}

// tas_vereine holen
include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');	# create a connection
//$conn->debug=true;
$conn->PConnect($host,$user,$password,$database);   # connect to MS-Access, northwind dsn
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$sql='select tas_spieler.*, tas_vereine.davor, tas_vereine.name as verein, tas_meldung.ak as ak, tas_turnier.name_lang as turnier 
	from tas_meldung,tas_spieler,tas_vereine,tas_turnier 
	where tas_meldung.spieler_id=tas_spieler.id 
	and tas_meldung.turnier_id='.$_GET["id"].' 
	and tas_meldung.verein_id=tas_vereine.id 
	and tas_turnier.id=tas_meldung.turnier_id 
	order by tas_meldung.ak asc, tas_spieler.geschlecht asc, tas_spieler.nachname';
$recordSetSpieler = &$conn->Execute($sql);
$meldungen=$recordSetSpieler->GetArray();
$turniername=$meldungen[0]["turnier"];

//vereine holen
$sqlV='select DISTINCT tas_vereine.davor, tas_vereine.name 
	from tas_meldung,tas_spieler,tas_vereine 
	where tas_meldung.spieler_id=tas_spieler.id 
	and tas_meldung.turnier_id='.$_GET["id"].' 
	and tas_meldung.verein_id=tas_vereine.id';
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
$smarty->assign('turniername',$turniername);
$smarty->assign('datum',date('d.m.Y'));
$smarty->assign('zeit',date('G:i'));

if ($_GET["format"] == "csv")
	$smarty->display('csv.tpl.htm');
else
	$smarty->display('anzeige2.tpl.htm');
//print_r($meldungen);

$conn->Close(); # optional
?>
