<?php
session_start();
include("config.inc.php");
include("funktionen.inc.php");
check_login();

unset($systemmeldung);
//$systemmeldung=$_SESSION["verein"]["id"]."-".$_SESSION["verein"]["davor"]."-".$_SESSION["verein"]["name"];

include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');	
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

if ($_POST["doSubmitEmail"])
{
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
}

if ($_POST["doDelete"])
{
	$sql="DELETE FROM tas_vereine WHERE id=".$_POST["id"];
	$rs = &$conn->Execute($sql) or die ("Fehler beim Speichern. Bitte Administrator benachrichtigen.");
	header("location:vereine.php");
}

if ($_POST["id"]) 
	$id = $_POST["id"];
else
	$id = $_SESSION["verein"]["id"];
	
$sql='select * from tas_vereine where id='.$id;
$rs = &$conn->Execute($sql);
$verein=$rs->GetArray();
$verein=$verein[0];

$sql="SELECT count(*) as cnt FROM tas_spieler WHERE id_vereine=".$id;
$rs = &$conn->Execute($sql);
$cnt = $rs->getArray();
$cnt = $cnt[0];
$cnt = $cnt["cnt"];

$conn->Close();

if ($_SESSION["verein"]["id"] == $verein["id"])
	$_SESSION["verein"]=$verein;

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('menuakt','vereinskontakt.php');
$smarty->assign('verein',$verein);
$smarty->assign('anzahlspieler',$cnt);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('admin',$_SESSION["admin"]);
//print('<pre>admin:'.$_SESSION["admin"]."</pre>");
$smarty->display('vereinskontakt.tpl.htm');
?>
