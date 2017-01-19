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

$conn->debug=true;
//echo("id=".$_POST["id"]."\n");

if ($_POST["doSubmit"]) {
	if ($_POST["neu"]) {
		if ($_POST["id"] && $_POST["davor"] && $_POST["name"] && $_POST["kurz"]) {
			$sql="select * from tas_vereine where id=".$_POST["id"]." or (davor='".$_POST["davor"]."' and name='".$_POST["name"]."') or kurz='".$_POST["kurz"]."'";
			$rs = &$conn->Execute($sql) or die ("Fehler beim pruefen der id/name/benutzer. Bitte Administrator benachrichtigen.");
			if (isset($rs)) {
				$verein=$rs->GetArray();
				$verein=$verein[0];
				$_POST["id"] = $verein["id"];
				$systemmeldung='Vereinsnummer, Name oder Benutzer schon vorhanden!';
			} else {
				$sql="insert into tas_vereine (id, davor, name, region, kurz, ansprechpartner_strasse, 
					ansprechpartner_plz_ort, ansprechpartner_telefon, ansprechpartner_mobil, ansprechpartner_email, 
					ansprechpartner_name, ansprechpartner_bemerkung";
				// passwort nur, wenn gefuellt (wird in anzeige nicht vorbelegt)
				if ($_POST["passwort"]) {
					$sql=$sql.", passwort";
				}
				$sql=$sql.") values (".$_POST["id"].", 
					'".$_POST["davor"]."', 
					'".$_POST["name"]."', 
					'".$_POST["region"]."', 
					'".$_POST["kurz"]."',
					'".$_POST["ansprechpartner_strasse"]."', 
					'".$_POST["ansprechpartner_plz_ort"]."', 
					'".$_POST["ansprechpartner_telefon"]."', 
					'".$_POST["ansprechpartner_mobil"]."', 
					'".$_POST["ansprechpartner_email"]."', 
					'".$_POST["ansprechpartner_name"]."', 
					'".$_POST["ansprechpartner_bemerkung"]."'";
				if ($_POST["passwort"]) {
					$sql=$sql.", '".$_POST["passwort"]."'";
				}
				$sql=$sql.")";
				$rs = &$conn->Execute($sql) or die ("Fehler beim Angelegen. Bitte Administrator benachrichtigen.");
				$systemmeldung='Daten wurden angelegt.';
			}
		} else {
			$_POST["id"] = -1;
			$systemmeldung='Vereinsnr., Kuerzel, Name und Benutzer muessen eingegeben werden!';
		}
	} else {
		$sql="UPDATE tas_vereine SET 
			davor='".$_POST["davor"]."', 
			name='".$_POST["name"]."', 
			region='".$_POST["region"]."', 
			kurz='".$_POST["kurz"]."',
			ansprechpartner_strasse='".$_POST["ansprechpartner_strasse"]."', 
			ansprechpartner_plz_ort='".$_POST["ansprechpartner_plz_ort"]."', 
			ansprechpartner_telefon='".$_POST["ansprechpartner_telefon"]."', 
			ansprechpartner_mobil='".$_POST["ansprechpartner_mobil"]."', 
			ansprechpartner_email='".$_POST["ansprechpartner_email"]."', 
			ansprechpartner_name='".$_POST["ansprechpartner_name"]."', 
			ansprechpartner_bemerkung='".$_POST["ansprechpartner_bemerkung"]."' ";
		// passwort nur updaten, wenn gefuellt (wird in anzeige nicht vorbelegt)
		if ($_POST["passwort"]) {
			$sql=$sql.",passwort='".$_POST["passwort"]."' ";
		}
		$sql=$sql." WHERE id=".$_POST["id"];
		$rs = &$conn->Execute($sql) or die ("Fehler beim Speichern. Bitte Administrator benachrichtigen.");
		$systemmeldung='Daten wurden gespeichert.';
	}
}

if ($_POST["doDelete"]) {
	$sql="DELETE FROM tas_vereine WHERE id=".$_POST["id"];
	$rs = &$conn->Execute($sql) or die ("Fehler beim Loeschen. Bitte Administrator benachrichtigen.");
	header("location:vereine.php");
}

if ($_POST["id"]) 
	$id = $_POST["id"];
else
	$id = $_SESSION["verein"]["id"];

if ($id == -1) {
	$verein = array();
	$verein[id] = $id;
} else {	
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
}
if ($_SESSION["verein"]["id"] == $verein["id"])
	$_SESSION["verein"]=$verein;

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('menuakt','vereinskontakt.php');
$smarty->assign('verein',$verein);
$smarty->assign('anzahlspieler',$cnt);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('admin',$_SESSION["admin"]);
$smarty->display('vereinskontakt.tpl.htm');
?>
