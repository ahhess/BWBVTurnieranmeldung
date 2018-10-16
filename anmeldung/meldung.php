<?php
session_start();

include("config.inc.php");
include("funktionen.inc.php");

check_login();
$tid=$_POST['tid'];
$vid=$_SESSION['verein']['id'];
$debug=0;

include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');
if($debug) $conn->debug=true;
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	
if ($_POST["doMeldungSubmit"]) {
	//Meldung speichern
	$rs = &$conn->Execute("delete from tas_vereinsmeldung where verein_id=$vid AND turnier_id=$tid");
	$rs = &$conn->Execute("delete from tas_meldung where verein_id=$vid AND turnier_id=$tid");
	if (count ($_POST['meldung']) )	{
		$sql='insert into tas_meldung (turnier_id,spieler_id,verein_id,ak,partner,partner2,bemerkung) VALUES ';
		for ($i=0;$i<count($_POST['meldung']);$i++) {
			$spid=$_POST['meldung'][$i];
			$sql.='('.$tid.','.$spid.','.$vid.',"'.$_POST['spk'][$spid].'","'
				.$_POST['partner'][$spid].'","'.$_POST['partner2'][$spid].'","'.$_POST['bemerkung'][$spid].'"),';
		}
		$sql=substr($sql,0,strlen($sql)-1);
		$rs = &$conn->Execute($sql);
	}
	if ($_POST['anmerkung']) {
		$sql="insert into tas_vereinsmeldung (turnier_id,verein_id,anmerkung) VALUES ($tid,$vid,'".$_POST['anmerkung']."')";
		$rs = &$conn->Execute($sql);
	}
	$systemmeldung="Meldung wurde aktualisiert.";
}

// turnierdaten holen
$sql='select tas_turnier.*,tas_turnierbeauftragter.vorname as ba_vorname, tas_turnierbeauftragter.nachname as ba_nachname, 
	tas_turnierbeauftragter.strasse as ba_strasse, tas_turnierbeauftragter.plz as ba_plz, tas_turnierbeauftragter.ort as ba_ort, 
	tas_turnierbeauftragter.telefon_priv as ba_telefon_priv, tas_turnierbeauftragter.telefon_gesch as ba_telefon_gesch, 
	tas_turnierbeauftragter.fax as ba_fax, tas_turnierbeauftragter.email as ba_email, tas_turnierbeauftragter.mobil as ba_mobil 
	FROM tas_turnier,tas_turnierbeauftragter 
	WHERE tas_turnier.turnierbeauftragter_id=tas_turnierbeauftragter.id 
	AND tas_turnier.id='.$tid;
	
$recordSet = &$conn->Execute($sql);
$turnier=$recordSet->getArray();
$turnier=$turnier[0];
if($debug) print_r($turnier."<br>");

// turnieranmerkung des vereins holen
$anmerkung="";
$sql='select * FROM tas_vereinsmeldung WHERE verein_id='.$vid.' AND turnier_id='.$tid;
$recordSet = &$conn->Execute($sql);
if ($recordSet) {
	$vm=$recordSet->GetArray();
	$vm=$vm[0];
	$anmerkung=$vm['anmerkung'];
}

// turnieranmeldungen mit spielerdaten  holen
$sql='select tas_spieler.*,tas_meldung.ak,tas_meldung.turnier_id,tas_meldung.partner,tas_meldung.partner2,tas_meldung.bemerkung
	FROM tas_spieler 
	LEFT OUTER JOIN tas_meldung 
		ON tas_spieler.id=tas_meldung.spieler_id 
		AND tas_spieler.id_vereine=tas_meldung.verein_id 
		AND tas_meldung.turnier_id='.$tid.' 
	WHERE id_vereine='.$vid.' 
	ORDER BY nachname,vorname';
$recordSet = &$conn->Execute($sql);
$s=$recordSet->GetArray();
//print_r($s);

for ($i=0;$i<count($s);$i++) {
	$s[$i]['spielklasse']=spielklasse_berechnen($s[$i]['geburtstag']);
}

if ($_POST['doMeldungSubmit'] && $sendmail == 1) {

	function domail($to, $subj, $txt, $from) {
		//echo "
		mail($to, $subj, $txt, $from); // ";
	}
	
	//gemeldete spieler nach id indizieren
	for ($i=0;$i<count($s);$i++) {
		$spieler[$s[$i]['id']]=$s[$i];
	}

	// email aufbereiten
	$absender='From: BWBV Turnieranmeldung <no-reply@bwbv.de>';
	$ueberschrift="Anmeldung: ".$turnier['name_lang']." am ".$turnier['name_kurz']." (".$_SESSION['verein']['davor']." ".$_SESSION['verein']['name'].")";
	$text="Hallo ".$turnier['ba_vorname']." ".$turnier['ba_nachname'].", \n\n"
		."der Verein ".$_SESSION['verein']['davor']."  ".$_SESSION['verein']['name']." hat soeben gemeldet:\n\n";

	for ($i=0;$i<count($_POST['meldung']);$i++) {
		$spielklasseVeraendert="";
		if (spielklasse_berechnen($spieler[$_POST['meldung'][$i]]['geburtstag']) != $_POST['spk'][$_POST['meldung'][$i]]) 
			$spielklasseVeraendert="*";
		$text.=$spieler[$_POST['meldung'][$i]]['nachname'].", ".$spieler[$_POST['meldung'][$i]]['vorname']." - ".$_POST['spk'][$_POST['meldung'][$i]].$spielklasseVeraendert
			." - ".substr($spieler[$_POST['meldung'][$i]]['geburtstag'],0,4);
		if ($spieler[$_POST['meldung'][$i]]['partner'])
			$text.=" - Doppelpartner: ".$spieler[$_POST['meldung'][$i]]['partner'];
		if ($spieler[$_POST['meldung'][$i]]['partner2'])
			$text.=" - Mixedpartner: ".$spieler[$_POST['meldung'][$i]]['partner2'];
		if ($spieler[$_POST['meldung'][$i]]['bemerkung'])
			$text.=" - Bemerkung: ".$spieler[$_POST['meldung'][$i]]['bemerkung'];
		$text.="\n";
	}
	$text.="\n\n* = Die Spielklasse wurde vom Eintragenden manuell ver�ndert.\n\n";
	$text.="Anmerkung zu der Meldung:\n";
	$text.=$_POST['anmerkung']?$_POST['anmerkung']:"- keine Anmerkung gemacht -";
	$text.="\n\nTurnierbeauftragter:\n"
		.$turnier['ba_vorname']." ".$turnier['ba_nachname']."\n"
		.$turnier['ba_telefon_priv']."\n"
		.$turnier['ba_email']."\n\n";
	$text.=$turnier['ausrichterinfos'] ? "Ausrichterinfos: ".$turnier['ausrichterinfos']."\n\n" : "";
	$text.="Meldender Verein:\n"
		.$_SESSION['verein']['ansprechpartner_name']."\n"
		.$_SESSION['verein']['ansprechpartner_telefon']."\n"
		.$_SESSION['verein']['ansprechpartner_email']."\n\n";
	$text.="Dies ist eine automatisch generierte Infomail. Es gelten die im Onlinemeldesystem aktuell erfassten Meldungen. Bitte nicht an den Absender antworten.\n";
	$text.="http://www.bwbv.de/turnier/anmeldung\n";
	
	// email an den turnierbeauftragten
	if ($turnier['ba_email']) {
		domail($turnier['ba_email'],$ueberschrift,$text,$absender);
	} else { 
		domail("turnieradmin@bwbv.de",
			$turnier['name_lang']." am ".$turnier['name_kurz']." hat keine Email des Beauftragten!!!",
			"Bitte Korrigieren!",$absender);
	}
	// email an den verein
	if ($_SESSION['verein']['ansprechpartner_email']) {
		$email = explode(";", $_SESSION['verein']['ansprechpartner_email']);
		for ($i=0;$i<count($email);$i++) {
			if($email[$i] <> "") {
				domail($email[$i],"Kopie: ".$ueberschrift,$text,$absender);
			}
		}
	} else {
		die("Noch keine Email zur Benachrichtigung eingetragen. Schnell in die <a href='vereinskontakt.php'>Vereinskontaktdaten </a>, Emailadresse eintragen und Meldung noch einmal t�tigen!!!");
	}
	// email an die zusatzperson aus tas_turnier.email_an
	if ($turnier['email_an']) {
		domail($turnier['email_an'],"Kopie: ".$ueberschrift,$text,$absender);
	}
}

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('fehlermeldung',$fehlermeldung);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('verein',$_SESSION['verein']);
$smarty->assign('spieler',$s);
$smarty->assign('anmerkung',$anmerkung);
$smarty->assign('turnier',$turnier);
$smarty->display('meldung.tpl.htm');
?>
