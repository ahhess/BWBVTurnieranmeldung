<?php
session_start();
include("config.inc.php");
include("funktionen.inc.php");
check_login();

if ($_POST["doSubmitEmail"])
{
	include("../adodb/adodb.inc.php");
	$conn = &ADONewConnection('mysql');	
	$conn->PConnect($host,$user,$password,$database);
	$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

	$sql="UPDATE tas_vereine SET 
		davor='".$_POST["davor"]."', 
		name='".$_POST["name"]."', 
		region='".$_POST["region"]."', 
		kurz='".$_POST["kurz"]."', 
		passwort='".$_POST["passwort"]."', 
		ansprechpartner_name='".$_POST["ansprechpartner_name"]."', 
		ansprechpartner_strasse='".$_POST["ansprechpartner_strasse"]."', 
		ansprechpartner_plz_ort='".$_POST["ansprechpartner_plz_ort"]."', 
		ansprechpartner_telefon='".$_POST["ansprechpartner_telefon"]."', 
		ansprechpartner_mobil='".$_POST["ansprechpartner_mobil"]."', 
		ansprechpartner_email='".$_POST["ansprechpartner_email"]."', 
		ansprechpartner_bemerkung='".$_POST["ansprechpartner_bemerkung"]."' 
		WHERE id=".$_SESSION["verein"]["id"];
	$rs = &$conn->Execute($sql) or die ("Fehler beim Speichern. Bitte Administrator benachrichtigen.");

	unset($rs);                                                                 // vereinsdaten neu laden für session
	$sql='select * from tas_vereine where id='.$_SESSION["verein"]["id"];
	$rs = &$conn->Execute($sql);
	$v=$rs->GetArray();
	$_SESSION["verein"]=$v[0];
	$conn->Close();
}

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('menuakt','vereinskontakt.php');
$smarty->display('vereinskontakt.tpl.htm');
?>
