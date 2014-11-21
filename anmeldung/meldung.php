<?php
session_start();

include("config.inc.php");
include("funktionen.inc.php");

check_login();
$tid=$_POST["tid"];

include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');
//$conn->debug=true;
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

// turnierdaten holen
unset($recordSet);
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

if ($_POST["doMeldungSubmit"])
{
	$rs = &$conn->Execute("delete from tas_meldung where verein_id=".$_SESSION["verein"]["id"].' AND turnier_id='.$tid);
	if (count ($_POST["meldung"]) )
	{
		$sql='insert into tas_meldung (turnier_id,spieler_id,verein_id,ak,partnernr,anmerkung) VALUES ';
		for ($i=0;$i<count($_POST["meldung"]);$i++) {
			$spid=$_POST["meldung"][$i];
			$sql.='('.$tid.','.$spid.','.$_SESSION["verein"]["id"].',"'.$_POST["spk"][$spid].'","'.$_POST["partnernr"][$spid].'","'.$_POST["anmerkung"].'"),';
		}
		$sql=substr($sql,0,strlen($sql)-1);
		$rs = &$conn->Execute($sql);
	}
	$systemmeldung="Meldung wurde aktualisiert.";
}

// spielerdaten mit turnieranmeldung holen
$sql='select tas_spieler.*,tas_meldung.ak,tas_meldung.anmerkung,tas_meldung.turnier_id,tas_meldung.partnernr
	FROM tas_spieler 
	LEFT OUTER JOIN tas_meldung 
		ON tas_spieler.id=tas_meldung.spieler_id 
		AND tas_spieler.id_vereine=tas_meldung.verein_id 
		AND tas_meldung.turnier_id='.$tid.' 
	WHERE id_vereine='.$_SESSION["verein"]["id"].' 
	ORDER BY nachname,vorname';
//print $sql;
//print_r($_SESSION);
$recordSet = &$conn->Execute($sql);
$s=$recordSet->GetArray();

$anmerkung="";
for ($i=0;$i<count($s);$i++) {
	if ($s[$i]["anmerkung"])
		$anmerkung=$s[$i]["anmerkung"];
}

$recordSet->Close(); # optional
$conn->Close(); # optional

for ($i=0;$i<count($s);$i++) 
	$s[$i]["spielklasse"]=spielklasse_berechnen($s[$i]["geburtstag"]);

if ($_POST["doMeldungSubmit"])
{
	// email aufbereiten
	for ($i=0;$i<count($s);$i++) 
		$spieler[$s[$i]["id"]]=$s[$i];
	$adresse_turnierbeauftragter=$turnier["ba_vorname"]." ".$turnier["ba_nachname"]."\n".$turnier["ba_telefon_priv"]."\n".$turnier["ba_email"]."\n";
	$adresse_rueckfrage_an_verein=$_SESSION["verein"]["ansprechpartner_name"]."\n".$_SESSION["verein"]["ansprechpartner_telefon"]."\n".$_SESSION["verein"]["ansprechpartner_email"]."\n";

	$ueberschrift="Anmeldung: ".$turnier["name_kurz"]." (".$_SESSION["verein"]["davor"]." ".$_SESSION["verein"]["name"].")";
	$text=$_SESSION["verein"]["name"]." hat soeben gemeldet:\n\n";
	for ($i=0;$i<count($_POST["meldung"]);$i++)
	{
		$spielklasseVeraendert="";
		if (spielklasse_berechnen($spieler[$_POST["meldung"][$i]]["geburtstag"]) != $_POST["spk"][$_POST["meldung"][$i]]) $spielklasseVeraendert="*";
		$text.=$spieler[$_POST["meldung"][$i]]["nachname"].", ".$spieler[$_POST["meldung"][$i]]["vorname"]." - ".$_POST["spk"][$_POST["meldung"][$i]].$spielklasseVeraendert." - ".$spieler[$_POST["meldung"][$i]]["geburtstag"]."\n";
	}
	$text.="\n\n* = Die Spielklasse wurde vom Eintragenden manuell verändert.\n\nAnmerkung zu der Meldung: \n";
	$text.=$_POST["anmerkung"]?$_POST["anmerkung"]:"- keine Anmerkung gemacht -";
	$text.="\n\nAnsprechpartner zu dieser Meldung sind:\n\n";
	$text.="Turnierbeauftragter:\n".$adresse_turnierbeauftragter."\n";
	$text.="Meldender Verein:\n".$adresse_rueckfrage_an_verein."\n\n";
	$text.="Dies ist eine automatisch generierte Infomail. Es gelten die im Onlinemeldesystem aktuell erfassten Meldungen. Bitte nicht an den Absender antworten.\n";
	$text.="http://www.bwbv.de/turnier/anmeldung\n";
	//echo $text;

	// email an den turnierbeauftragten
	//if ($turnier["ba_email"]) 
	//	mail($turnier["ba_email"],$ueberschrift,$text,"FROM: BWBV Turnieranmeldung <no-reply@bwbv.de>");
	//else 
	//	mail("turnieradmin@bwbv.de",$turnier["name_lang"]." hat keine Email des Beauftragten!!!","Bitte Korrigieren!","FROM: BWBV Turnieranmeldung <no-reply@bwbv.de>");

	// email an den verein
	if ($_SESSION["verein"]["ansprechpartner_email"]) {
		$email = explode(";", $_SESSION["verein"]["ansprechpartner_email"]);
		for ($i=0;$i<count($email);$i++) {
			if($email[$i] <> "") {
				mail($email[$i],$ueberschrift,$text,"FROM: BWBV Turnieranmeldung <no-reply@bwbv.de>");
			}
		}
	}
	else die("Noch keine Email zur Benachrichtigung eingetragen. Schnell in die <a href='vereinskontakt.php'>Vereinskontaktdaten </a>, Emailadresse eintragen und Meldung noch einmal tätigen!!!");

	// email an die zusatzperson aus tas_turnier.email_an
	if ($turnier["email_an"]) {
		mail($turnier["email_an"],"(Kopie) ".$ueberschrift,"Guten Tag. Sie wurden als Empfänger einer Kopie dieser Mail eingetragen!\n---\n\n".$text,"FROM: BWBV Turnieranmeldung <no-reply@bwbv.de>");
	}
}

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();

$smarty->assign('fehlermeldung',$fehlermeldung);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('meldung',$meldung);
$smarty->assign('verein',$_SESSION["verein"]);
$smarty->assign('spieler',$s);
$smarty->assign('anmerkung',$anmerkung);
$smarty->assign('turnier',$turnier);
$smarty->assign('spielklasse',$spielklasse);
$smarty->display('meldung.tpl.htm');

//print_r($_SESSION);
//print "<pre>";
//print_r($_POST);
//print_r($s);
?>
