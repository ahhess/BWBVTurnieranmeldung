<?php
session_start();
include("config.inc.php");
include("funktionen.inc.php");
check_login();

unset($systemmeldung);
//$systemmeldung=$_SESSION["verein"]["id"]."-".$_SESSION["verein"]["davor"]."-".$_SESSION["verein"]["name"];

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
		WHERE id=".$_POST["id"];

	$rs = &$conn->Execute($sql) or die ("Fehler beim Speichern. Bitte Administrator benachrichtigen.");
	$systemmeldung='Daten wurden gespeichert.';

	$sql='select * from tas_vereine where id='.$_POST["id"];
	$rs = &$conn->Execute($sql);
	$v=$rs->GetArray();
	$v=$v[0];
	$_SESSION["verein"]=$v;
	$conn->Close();
}

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('menuakt','vereinskontakt.php');
$smarty->assign('verein',$_SESSION["verein"]);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->display('vereinskontakt.tpl.htm');
?>
