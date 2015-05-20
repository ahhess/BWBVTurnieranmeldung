<?php
session_start();

include("config.inc.php");
include("funktionen.inc.php");

check_login();
$tid=$_POST["tid"];
$vid=$_SESSION["verein"]["id"];
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
	$meldung = $_POST["meldung"];
	if (count($meldung) )	{
		$sql='insert into tas_meldung (turnier_id,spieler_id,verein_id,ak,partner) VALUES ';
		for ($i=0;$i<count($meldung);$i++) {
			$spid=$meldung[$i];
			$ak=$_POST["spk"][$spid];
			$partner=$_POST["partner"][$spid];
			$sql.="($tid,$spid,$vid,'$ak','$partner'),";
		}
		$sql=substr($sql,0,strlen($sql)-1); //letztes komma weg
		$rs = &$conn->Execute($sql);
	}
	if ($_POST["anmerkung"]) {
		$sql="insert into tas_vereinsmeldung (turnier_id,verein_id,anmerkung) VALUES ($tid,$vid,'".$_POST["anmerkung"]."')";
		$rs = &$conn->Execute($sql);
	}
	$systemmeldung="Meldung wurde aktualisiert.";
}

// turnierdaten holen
$sql='select tas_turnier.*, ba.vorname as ba_vorname, ba.nachname as ba_nachname, 
	ba.strasse as ba_strasse, ba.plz as ba_plz, ba.ort as ba_ort, 
	ba.telefon_priv as ba_telefon_priv, ba.telefon_gesch as ba_telefon_gesch, 
	ba.fax as ba_fax, ba.email as ba_email, ba.mobil as ba_mobil 
	FROM tas_turnier, tas_turnierbeauftragter ba
	WHERE tas_turnier.turnierbeauftragter_id=ba.id 
	AND tas_turnier.id='.$tid;
$recordSet = &$conn->Execute($sql);
$turnier=$recordSet->getArray();
$turnier=$turnier[0];
if($debug) print_r($turnier."<br>");

// turnieranmerkung des vereins holen
$anmerkung="";
$sql='select * FROM tas_vereinsmeldung WHERE verein_id='.$vid.' AND turnier_id='.$tid;
$recordSet = &$conn->Execute($sql);
if ($recordSet)
{
	$vm=$recordSet->GetArray();
	$vm=$vm[0];
	$anmerkung=$vm["anmerkung"];
}

// turnieranmeldungen mit spielerdaten  holen
$sql='select tas_spieler.*,tas_meldung.ak,tas_meldung.turnier_id,tas_meldung.partner
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

for ($i=0;$i<count($s);$i++) 
	$s[$i]["spielklasse"]=spielklasse_berechnen($s[$i]["geburtstag"]);


if ($_POST["doMeldungSubmit"] && $sendmail == 1 ) {
	function domail($to, $subj, $txt, $from) {
		//echo "<pre>mail: to: $to, from: $from\nBetr.:$subj\n$txt</pre>"; 
		mail($to, $subj, $txt, $from);
	}
	//gemeldete spieler nach id indizieren
	for ($i=0;$i<count($s);$i++) {
		$spieler[$s[$i]["id"]]=$s[$i];
	}

	// email aufbereiten
	$absender="FROM: BWBV Turnieranmeldung <no-reply@bwbv.de>";
	$adresse_turnierbeauftragter=$turnier["ba_vorname"]." ".$turnier["ba_nachname"]."\n".$turnier["ba_telefon_priv"]."\n".$turnier["ba_email"]."\n";
	$adresse_rueckfrage_an_verein=$_SESSION["verein"]["ansprechpartner_name"]."\n".$_SESSION["verein"]["ansprechpartner_telefon"]."\n".$_SESSION["verein"]["ansprechpartner_email"]."\n";
	$ueberschrift="Anmeldung: ".$turnier["name_lang"]." am ".$turnier["name_kurz"]." (".$_SESSION["verein"]["davor"]." ".$_SESSION["verein"]["name"].")";
	$text=$_SESSION["verein"]["name"]." hat soeben gemeldet:\n\n";

	for ($i=0;$i<count($_POST["meldung"]);$i++) {
		$spielklasseVeraendert="";
		if (spielklasse_berechnen($spieler[$_POST["meldung"][$i]]["geburtstag"]) != $_POST["spk"][$_POST["meldung"][$i]]) 
			$spielklasseVeraendert="*";
		$text.=$spieler[$_POST["meldung"][$i]]["nachname"].", ".$spieler[$_POST["meldung"][$i]]["vorname"]." - ".$_POST["spk"][$_POST["meldung"][$i]].$spielklasseVeraendert." - ".$spieler[$_POST["meldung"][$i]]["geburtstag"];
		if ($spieler[$_POST["meldung"][$i]]["partner"])
			$text.=" - Partner: ".$spieler[$_POST["meldung"][$i]]["partner"];
		$text.="\n";
	}
	$text.="\n\n* = Die Spielklasse wurde vom Eintragenden manuell verändert.\n\nAnmerkung zu der Meldung: \n";
	$text.=$_POST["anmerkung"]?$_POST["anmerkung"]:"- keine Anmerkung gemacht -";
	$text.="\n\nAnsprechpartner zu dieser Meldung sind:\n\n";
	$text.="Turnierbeauftragter:\n".$adresse_turnierbeauftragter."\n";
	$text.="Meldender Verein:\n".$adresse_rueckfrage_an_verein."\n\n";
	$text.="Dies ist eine automatisch generierte Infomail. Es gelten die im Onlinemeldesystem aktuell erfassten Meldungen. Bitte nicht an den Absender antworten.\n";
	$text.="http://www.bwbv.de/turnier/anmeldung\n";
	
	// email an den turnierbeauftragten
	if ($turnier["ba_email"]) 
		domail($turnier["ba_email"],$ueberschrift,$text,$absender);
	else 
		domail("turnieradmin@bwbv.de",$turnier["name_lang"]." am ".$turnier["name_kurz"]." hat keine Email des Beauftragten!!!","Bitte Korrigieren!",$absender);

	// email an den verein
	if ($_SESSION["verein"]["ansprechpartner_email"]) {
		$email = explode(";", $_SESSION["verein"]["ansprechpartner_email"]);
		for ($i=0;$i<count($email);$i++) {
			if($email[$i] <> "") {
				domail($email[$i],$ueberschrift,$text,$absender);
			}
		}
	}
	else die("Noch keine Email zur Benachrichtigung eingetragen. Schnell in die <a href='vereinskontakt.php'>Vereinskontaktdaten </a>, Emailadresse eintragen und Meldung noch einmal tätigen!!!");

	// email an die zusatzperson aus tas_turnier.email_an
	if ($turnier["email_an"]) {
		domail($turnier["email_an"],"(Kopie) ".$ueberschrift,"Guten Tag. Sie wurden als Empfänger einer Kopie dieser Mail eingetragen!\n---\n\n".$text,$absender);
	}
}

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('fehlermeldung',$fehlermeldung);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('verein',$_SESSION["verein"]);
$smarty->assign('spieler',$s);
$smarty->assign('anmerkung',$anmerkung);
$smarty->assign('turnier',$turnier);
$smarty->display('meldung.tpl.htm');
?>
