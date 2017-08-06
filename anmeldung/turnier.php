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
	$datum=date_german2mysql($_POST["datum"]);
	$datum_anmelden_ab=date_german2mysql($_POST["datum_anmelden_ab"]);
	$datum_anmelden_bis=date_german2mysql($_POST["datum_anmelden_bis"]);
	if ($_POST["id"] > 0){
		$sql="UPDATE tas_turnier SET 
			name_lang='".$_POST["name_lang"]."', 
			name_kurz='".$_POST["name_kurz"]."', 
			datum=".$datum.", 
			ort='".$_POST["ort"]."', 
			datum_anmelden_ab=".$datum_anmelden_ab.", 
			datum_anmelden_bis=".$datum_anmelden_bis.", 
			region='".$_POST["region"]."', 
			turnierbeauftragter_id=".$_POST["turnierbeauftragter_id"]."
			WHERE id=".$_POST["id"];
			//email_an='".$_POST["email_an"]."', 
		$id = $_POST["id"];
	} else {
		$sql="INSERT INTO tas_turnier (
			name_lang, name_kurz, datum, ort, region, datum_anmelden_ab, datum_anmelden_bis, turnierbeauftragter_id)
			VALUES (
			'".$_POST["name_lang"]."', 
			'".$_POST["name_kurz"]."', 
			".$datum.", 
			'".$_POST["ort"]."', 
			'".$_POST["region"]."', 
			".$datum_anmelden_ab.", 
			".$datum_anmelden_bis.", 
			".$_POST["turnierbeauftragter_id"].")";
			//email_an
			//'".$_POST["email_an"]."', 
	}
	//print_r("<pre>$sql</pre>");
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

$sql='SELECT * FROM tas_turnierbeauftragter order by nachname, vorname';
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
$smarty->assign('regionen',$regionen);

$smarty->display('turnier.tpl.htm');
?>
