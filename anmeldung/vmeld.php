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

$vnr = $_GET["id"];

//vereinsdaten holen
$sql="select * from tas_vereine where id=$vnr";
$recordSet = &$conn->Execute($sql);
$vereine=$recordSet->GetArray();
$verein=$vereine[0];

//meldungen holen
$sql="select tas_meldung.partner, tas_meldung.partner2, tas_meldung.bemerkung, tas_meldung.ak as ak,
    tas_spieler.*, tas_turnier.name_lang, tas_turnier.name_kurz, tas_turnier.ort, tas_turnier.id as turnier_id, tas_turnier.datum as turnier_datum
    from tas_meldung
    join tas_spieler on tas_meldung.spieler_id=tas_spieler.id
    join tas_turnier on tas_turnier.id = tas_meldung.turnier_id 
    where tas_meldung.verein_id=$vnr
	order by tas_turnier.datum desc, tas_spieler.nachname, tas_spieler.vorname";
$recordSet = &$conn->Execute($sql);
$meldungen = $recordSet->GetArray();

$conn->Close();

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();

$smarty->assign('menuakt','vereine.php');
$smarty->assign('admin',$_SESSION["admin"]);
$smarty->assign('verein',$verein);
$smarty->assign('meldungen',$meldungen);

$smarty->display('vmeld.tpl.htm');
?>
