<?php
session_start();

include("config.inc.php");
include("funktionen.inc.php");
include("../adodb/adodb.inc.php");

check_admin_login();

$conn = &ADONewConnection('mysql');	
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

if ($_POST["doSave"] == "doSave"){
	if ($_POST["id"] > 0){
		$sql="UPDATE tas_turnier SET 
			name_lang='".$_POST["name_lang"]."', 
			datum='".$_POST["datum"]."', 
			ort='".$_POST["ort"]."', 
			datum_anmelden_ab='".$_POST["datum_anmelden_ab"]."', 
			datum_anmelden_bis='".$_POST["datum_anmelden_bis"]."', 
			turnierbeauftragter_id=".$_POST["turnierbeauftragter_id"]."
			WHERE id=".$_POST["id"];
			//email_an='".$_POST["email_an"]."', 
		$id = $_POST["id"];
	} else {
		$sql="INSERT INTO tas_turnier (
			name_lang, datum, ort, datum_anmelden_ab, datum_anmelden_bis, turnierbeauftragter_id)
			VALUES (
			'".$_POST["name_lang"]."', 
			'".$_POST["datum"]."', 
			'".$_POST["ort"]."', 
			'".$_POST["datum_anmelden_ab"]."', 
			'".$_POST["datum_anmelden_bis"]."', 
			".$_POST["turnierbeauftragter_id"].")";
			//email_an
			//'".$_POST["email_an"]."', 
	}
	$rc = &$conn->Execute($sql) or die ("Fehler beim Speichern. Bitte Administrator benachrichtigen. / ".$sql);
	header("location:turniere.php");
	//$systemmeldung='Daten wurden gespeichert.';
} else 
if ($_POST["doDelete"] == "doDelete"){
	if ($_POST["id"] > 0){
		$sql="DELETE FROM tas_turnier WHERE id=".$_POST["id"];
		$rc = &$conn->Execute($sql) or die ("Fehler beim Loeschen. Bitte Administrator benachrichtigen. / ".$sql);
		header("location:turniere.php");
		//$systemmeldung='Daten wurden geloescht.';
		//$id = -1;
	}
} else {
	$id = $_GET["id"];
}

$sql="SELECT * FROM tas_turnier where id=".$id;
$recordSet = &$conn->Execute($sql);
if ($recordSet) {
	$liste = $recordSet->getArray();
	$rec = $liste[0];
	
	$sql="SELECT count(*) as cnt FROM tas_meldung where turnier_id=".$id;
	$recordSet = &$conn->Execute($sql);
	$cnt = $recordSet->getArray();
	$cnt = $cnt[0];
	$cnt = $cnt["cnt"];
}

$sql='SELECT * FROM tas_turnierbeauftragter';
$recordSet = &$conn->Execute($sql);
$liste = $recordSet->getArray();

$conn->Close();

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('turnier',$rec);
$smarty->assign('turnierbeauftragter',$liste);
$smarty->assign('cnt',$cnt);
$smarty->assign('menuakt','turnier.php');
$smarty->assign('admin',$_SESSION["admin"]);
//$smarty->assign('systemmeldung',$systemmeldung);
$smarty->display('turnier.tpl.htm');
?>
