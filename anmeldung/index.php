<?php
session_start();
unset($_SESSION["tid"]);
include("config.inc.php");
include("funktionen.inc.php");

include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');
//$conn->debug=true;
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('menuakt','index.php');

$log=false;
$systemmeldung="";

function countMeldungen($conn, $turnierid, $vereinid) {
	$sql2='SELECT COUNT(*) as anzahl FROM tas_meldung WHERE turnier_id='.$turnierid;
	if ($vereinid != null) {
		$sql2=$sql2.' AND verein_id='.$vereinid;
	}
	$rs2=&$conn->Execute($sql2);
	$count=$rs2->getArray();
	$count=$count[0];
	if ($log) 
		$systemmeldung=$systemmeldung.$sql2." : ".$count["anzahl"]."<br>";
		//print_r("<pre>".$sql2." : ".$count["anzahl"]."</pre>");
	return $count["anzahl"];
}

// aktuelle ausschreibungen holen - f�r login- und �bersichtsseite
$region="%";
if($_GET['region']){
	$region=$_GET['region'];
} else {
	// Region des Vereins vorbelegen
	if (is_array($_SESSION["verein"])){
		$region=$_SESSION['verein']['region'];
	}
}
$_SESSION["region"] = $region;

$sql="select tas_turnier.*,tas_turnierbeauftragter.vorname as ba_vorname, tas_turnierbeauftragter.nachname as ba_nachname, tas_turnierbeauftragter.strasse as ba_strasse, tas_turnierbeauftragter.plz as ba_plz, tas_turnierbeauftragter.ort as ba_ort, tas_turnierbeauftragter.telefon_priv as ba_telefon_priv, tas_turnierbeauftragter.telefon_gesch as ba_telefon_gesch, tas_turnierbeauftragter.fax as ba_fax, tas_turnierbeauftragter.email as ba_email, tas_turnierbeauftragter.mobil as ba_mobil 
	FROM tas_turnier
	JOIN tas_turnierbeauftragter ON tas_turnier.turnierbeauftragter_id=tas_turnierbeauftragter.id 
	WHERE tas_turnier.region like '$region'
	AND datum_anmelden_ab <= CURDATE() 
	AND datum_anmelden_bis >= CURDATE() 
	ORDER BY datum";
if ($log) 
	$systemmeldung=$systemmeldung.$sql."<br>";
	//print_r("<pre>".$sql."</pre>");

$rs = &$conn->Execute($sql);
if ($rs){
	$turniere=$rs->getArray();
	if (is_array($_SESSION["verein"])){
		// wenn eingelogged anzahl meldungen zaehlen
		for ($i=0;$i<count($turniere);$i++)	{
			$turniere[$i]["anzahl_anmeldungen"]=countMeldungen($conn, $turniere[$i]["id"], $_SESSION["verein"]["id"]);
			$turniere[$i]["anmeldungen_gesamt"]=countMeldungen($conn, $turniere[$i]["id"], null);
		}
	}
}

// alte ausschreibungen holen
$sql_abgelaufen="select tas_turnier.*,tas_turnierbeauftragter.vorname as ba_vorname, tas_turnierbeauftragter.nachname as ba_nachname, tas_turnierbeauftragter.strasse as ba_strasse, tas_turnierbeauftragter.plz as ba_plz, tas_turnierbeauftragter.ort as ba_ort, tas_turnierbeauftragter.telefon_priv as ba_telefon_priv, tas_turnierbeauftragter.telefon_gesch as ba_telefon_gesch, tas_turnierbeauftragter.fax as ba_fax, tas_turnierbeauftragter.email as ba_email, tas_turnierbeauftragter.mobil as ba_mobil 
	FROM tas_turnier
	JOIN tas_turnierbeauftragter ON tas_turnier.turnierbeauftragter_id=tas_turnierbeauftragter.id 
	WHERE tas_turnier.region like '$region'
	AND datum >= CURDATE()  
	AND datum_anmelden_bis < CURDATE() 
	ORDER BY datum";

$rs = &$conn->Execute($sql_abgelaufen);
//print "<pre>";print_r($rs);
	
if ($rs){
	$turniere_abgelaufen=$rs->getArray();
	if (is_array($_SESSION["verein"])) {
		// wenn eingelogged anzahl meldungen zaehlen
		for ($i=0;$i<count($turniere_abgelaufen);$i++){
			$turniere_abgelaufen[$i]["anzahl_anmeldungen"]=countMeldungen($conn, $turniere_abgelaufen[$i]["id"], $_SESSION["verein"]["id"]);
			$turniere_abgelaufen[$i]["anmeldungen_gesamt"]=countMeldungen($conn, $turniere_abgelaufen[$i]["id"], null);
		}
	}
}

// LOGIN Check
if (!session_is_registered("verein")) // keine session, d.h. noch nicht angemeldet
{
	$smarty->assign('turniere',$turniere);
	$smarty->assign('turniere_abgelaufen',$turniere_abgelaufen);

	if ($_POST["doLoginSubmit"]){
		//$smarty->assign('fehlermeldung_zugang',"Die Anmeldung ist im Moment nicht moeglich.");
		/***/
		if ( $_POST["benutzer"] <> "" and $_POST["passwort"] <> "" ) {
			$sql='select * from tas_vereine where kurz="'.substr($_POST["benutzer"],0,10).'" AND passwort="'.$_POST["passwort"].'"';
			$rs = &$conn->Execute($sql);
			$v=$rs->GetArray();
			if (count($v)){
				$_SESSION["verein"]=$v[0];
				header("location:index.php");   //alles klar. session da. index neu aufrufen!
			}
		}
		// keine �bereinstimmung user/pw
		$smarty->assign('fehlermeldung_zugang',"Ihre Zugangsdaten scheinen leider nicht korrekt zu sein. Bitte versuchen Sie es ggf. erneut. ");
		/***/
	}
	$conn->Close();
	$smarty->display('login2.tpl.htm');
	exit;
}

// ermitteln der Regionen
$sql="select distinct region FROM tas_turnier 
	WHERE ( datum_anmelden_ab <= CURDATE() AND datum_anmelden_bis >= CURDATE() ) 
	OR ( datum >= CURDATE() AND datum_anmelden_bis < CURDATE() ) 
	ORDER BY region";
if ($log) 
	$systemmeldung=$systemmeldung.$sql."<br>";
$rs = &$conn->Execute($sql);
if($rs){
	$regionen=$rs->GetArray();
}

$conn->Close();

//smarty

$smarty->assign('fehlermeldung',$fehlermeldung);
$smarty->assign('turniere',$turniere);
$smarty->assign('turniere_abgelaufen',$turniere_abgelaufen);
$smarty->assign('region',$region);
$smarty->assign('regionen',$regionen);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('menuakt','index.php');

$smarty->display('index.tpl.htm');
?>
