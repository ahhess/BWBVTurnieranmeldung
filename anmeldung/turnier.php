<?php
session_start();

include("config.inc.php");
include("funktionen.inc.php");
include("../adodb/adodb.inc.php");

check_admin_login();

$conn = &ADONewConnection('mysql');	
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

if ($_GET["id"]){
	$sql="SELECT * FROM tas_turnier where id=".$_GET["id"];
	$recordSet = &$conn->Execute($sql);
	$liste = $recordSet->getArray();
	$rec = $liste[0];
}
$sql='SELECT * FROM tas_turnierbeauftragter';
$recordSet = &$conn->Execute($sql);
$liste = $recordSet->getArray();

$conn->Close();

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('turnier',$rec);
$smarty->assign('turnierbeauftragter',$liste);
$smarty->assign('menuakt','turnier.php');
$smarty->assign('admin',$_SESSION["admin"]);
$smarty->display('turnier.tpl.htm');
?>
