<?php
session_start();
include("config.inc.php");
include("funktionen.inc.php");

include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('menuakt','admin.php');

// LOGIN Check
if (!session_is_registered("admin"))
{
	if ($_POST["doLoginSubmit"])
	{
		if ( $_POST["benutzer"] <> "" and $_POST["passwort"] <> "" ) {
			$sql='select * from tas_turnierbeauftragter where email="'.$_POST["benutzer"].'" AND passwort="'.$_POST["passwort"].'"';
			$rs = &$conn->Execute($sql);
			$v=$rs->GetArray();
			if (count($v)){
				$_SESSION["admin"]=$v[0];
				header("location:turniere.php");
			}
		} else {
			// keine übereinstimmung user/pw
			$smarty->assign('fehlermeldung_zugang',"Ihre Zugangsdaten scheinen leider nicht korrekt zu sein. Bitte versuchen Sie es ggf. erneut.");
		}
	}
	$conn->Close();
}

$smarty->assign('admin',$_SESSION["admin"]);
$smarty->display('admin.tpl.htm');
?>
