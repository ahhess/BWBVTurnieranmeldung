<?php
session_start();

include("config.inc.php");
include("funktionen.inc.php");
include("../adodb/adodb.inc.php");

check_admin_login();

$conn = &ADONewConnection('mysql');	
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
//$conn->debug=true;

$id = $_GET["id"];

if ($_POST["doSave"] == "doSave"){
	$id = $_POST["id"];
	//check unique emailadresse
	$sql="SELECT count(*) as cnt FROM tas_turnierbeauftragter where email='".$_POST["email"]."'"; 	
	if ($id > 0){
		$sql=$sql." and id<>".$id;
	}
	$recordSet = &$conn->Execute($sql);
	$cnt = $recordSet->getArray();
	$cnt = $cnt[0];
	$cnt = $cnt["cnt"];
	if ($cnt > 0){
		$systemmeldung='Fehler: Email-Adresse schon vorhanden!';
	}
	else {
		if ($id > 0){
			$sql="UPDATE tas_turnierbeauftragter SET 
				nachname='".$_POST["nachname"]."', 
				vorname='".$_POST["vorname"]."', 
				strasse='".$_POST["strasse"]."', 
				plz='".$_POST["plz"]."', 
				ort='".$_POST["ort"]."', 
				telefon_priv='".$_POST["telefon_priv"]."', 
				telefon_gesch='".$_POST["telefon_gesch"]."',
				mobil='".$_POST["mobil"]."',
				fax='".$_POST["fax"]."',
				region='".$_POST["region"]."',
				email='".$_POST["email"]."'";
				if ($_POST["passwort"]) {
					$sql=$sql.",passwort='".$_POST["passwort"]."' ";
				}
				$sql=$sql." WHERE id=".$id;
		} else {
			$sql="INSERT INTO tas_turnierbeauftragter (
				nachname, vorname, strasse, plz, ort, telefon_priv, telefon_gesch, mobil, fax, region, email, passwort) 
				VALUES (
				'".$_POST["nachname"]."', 
				'".$_POST["vorname"]."', 
				'".$_POST["strasse"]."', 
				'".$_POST["plz"]."', 
				'".$_POST["ort"]."', 
				'".$_POST["telefon_priv"]."', 
				'".$_POST["telefon_gesch"]."', 
				'".$_POST["mobil"]."', 
				'".$_POST["fax"]."', 
				'".$_POST["region"]."', 
				'".$_POST["email"]."'"; 
				if ($_POST["passwort"]) {
					$sql=$sql.",'".$_POST["passwort"]."'";
				}
				$sql=$sql.")";
		}
		$rc = &$conn->Execute($sql) or die ("Fehler beim Speichern. Bitte Administrator benachrichtigen. / ".$sql);
		header("location:turnierbeauftragte.php");
		//$systemmeldung='Daten wurden gespeichert.';
	}
} else if ($_POST["doDelete"] == "doDelete"){
	if ($_POST["id"] > 0){
		$sql="DELETE FROM tas_turnierbeauftragter WHERE id=".$_POST["id"];
		$rc = &$conn->Execute($sql) or die ("Fehler beim Loeschen. Bitte Administrator benachrichtigen. / ".$sql);
		header("location:turnierbeauftragte.php");
	}
}

$sql="SELECT * FROM tas_turnierbeauftragter where id=".$id;
$recordSet = &$conn->Execute($sql);
if ($recordSet) {
	$liste = $recordSet->getArray();
	$rec = $liste[0];
	
	$sql="SELECT count(*) as cnt FROM tas_turnier where turnierbeauftragter_id=".$id;
	$recordSet = &$conn->Execute($sql);
	$cnt = $recordSet->getArray();
	$cnt = $cnt[0];
	$cnt = $cnt["cnt"];
}

$conn->Close();

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('turnierbeauftragter',$rec);
$smarty->assign('cnt',$cnt);
$smarty->assign('admin',$_SESSION["admin"]);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('regionen',$regionen);
$smarty->display('turnierbeauftragter.tpl.htm');
?>
