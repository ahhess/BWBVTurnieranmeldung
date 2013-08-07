<?php
session_start();
unset($_SESSION["tid"]);
include("config.inc.php");
include("funktionen.inc.php");

// tas_vereine holen
include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');	# create a connection
//$conn->debug=true;
$conn->PConnect($host,$user,$password,$database);   # connect to MS-Access, northwind dsn
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

require('../smarty/libs/Smarty.class.php');
$smarty = new Smarty;

$smarty->template_dir = '';
$smarty->compile_dir = '../smarty/templates_c/';
$smarty->config_dir = '../smarty/configs/';
$smarty->cache_dir = '../smarty/cache/';


// aktuelle ausschreibungen holen - für login- und übersichtsseite

$sql='select tas_turnier.*,tas_turnierbeauftragter.vorname as ba_vorname, tas_turnierbeauftragter.nachname as ba_nachname, tas_turnierbeauftragter.strasse as ba_strasse, tas_turnierbeauftragter.plz as ba_plz, tas_turnierbeauftragter.ort as ba_ort, tas_turnierbeauftragter.telefon_priv as ba_telefon_priv, tas_turnierbeauftragter.telefon_gesch as ba_telefon_gesch, tas_turnierbeauftragter.fax as ba_fax, tas_turnierbeauftragter.email as ba_email, tas_turnierbeauftragter.mobil as ba_mobil FROM tas_turnier,tas_turnierbeauftragter WHERE tas_turnier.turnierbeauftragter_id=tas_turnierbeauftragter.id AND datum_anmelden_ab<NOW() AND datum_anmelden_bis>=NOW() ORDER BY datum';

//$sql ='SELECT * FROM tas_turnier WHERE datum_anmelden_ab<NOW() AND datum_anmelden_bis>NOW()';
$rs = &$conn->Execute($sql);
if ($rs)
{
	$turniere=$rs->getArray();
	$button_meldebildschirm="Spieler anmelden / \nMeldung bearbeiten";

	if (is_array($_SESSION["verein"]))    // nicht bei Login!
	{
		for ($i=0;$i<count($turniere);$i++)
		{
			unset($sql2);
			unset($rs2);
			$sql2='SELECT tas_spieler.nachname,tas_spieler.vorname,tas_spieler.geschlecht,tas_meldung.ak FROM tas_spieler,tas_meldung WHERE tas_spieler.id_vereine='.$_SESSION["verein"]["id"].' AND tas_spieler.id=tas_meldung.spieler_id AND tas_meldung.turnier_id='.$turniere[$i]["id"].' ORDER BY tas_meldung.ak,tas_spieler.nachname,tas_spieler.vorname';
			$rs2=&$conn->Execute($sql2);
			$angemeldet=$rs2->getArray();
			$turniere[$i]["anzahl_anmeldungen"]=count($angemeldet);
			$turniere[$i]["infobox"]="";
			for ($j=0;$j<count($angemeldet);$j++)
			{
				$turniere[$i]["infobox"].=$angemeldet[$j]["nachname"].', '.$angemeldet[$j]["vorname"].' ('.$angemeldet[$j]["ak"].")<br>";
			}
		}
	}
}
else
{
	$fehlermeldung="Derzeit keine Turniere ausgeschrieben.";
}


// alte ausschreibungen holen

$sql_abgelaufen='select tas_turnier.*,tas_turnierbeauftragter.vorname as ba_vorname, tas_turnierbeauftragter.nachname as ba_nachname, tas_turnierbeauftragter.strasse as ba_strasse, tas_turnierbeauftragter.plz as ba_plz, tas_turnierbeauftragter.ort as ba_ort, tas_turnierbeauftragter.telefon_priv as ba_telefon_priv, tas_turnierbeauftragter.telefon_gesch as ba_telefon_gesch, tas_turnierbeauftragter.fax as ba_fax, tas_turnierbeauftragter.email as ba_email, tas_turnierbeauftragter.mobil as ba_mobil FROM tas_turnier,tas_turnierbeauftragter WHERE tas_turnier.turnierbeauftragter_id=tas_turnierbeauftragter.id AND datum>=NOW() AND datum_anmelden_bis<NOW() ORDER BY datum';
//$sql_abgelaufen='select tas_turnier.*,tas_turnierbeauftragter.vorname as ba_vorname, tas_turnierbeauftragter.nachname as ba_nachname, tas_turnierbeauftragter.strasse as ba_strasse, tas_turnierbeauftragter.plz as ba_plz, tas_turnierbeauftragter.ort as ba_ort, tas_turnierbeauftragter.telefon_priv as ba_telefon_priv, tas_turnierbeauftragter.telefon_gesch as ba_telefon_gesch, tas_turnierbeauftragter.fax as ba_fax, tas_turnierbeauftragter.email as ba_email, tas_turnierbeauftragter.mobil as ba_mobil FROM tas_turnier,tas_turnierbeauftragter WHERE tas_turnier.turnierbeauftragter_id=tas_turnierbeauftragter.id AND datum_anmelden_ab<NOW() AND datum_anmelden_bis>NOW() ORDER BY datum';

//$sql ='SELECT * FROM tas_turnier WHERE datum_anmelden_ab<NOW() AND datum_anmelden_bis>NOW()';
$rs = &$conn->Execute($sql_abgelaufen);

//print "<pre>";print_r($rs);
if ($rs)
{
	$turniere_abgelaufen=$rs->getArray();
	if (is_array($_SESSION["verein"])) // nicht bei LOGIN!
	{
		for ($i=0;$i<count($turniere_abgelaufen);$i++)
		{
			unset($sql2);
			unset($rs2);
			unset($angemeldet);
			$sql2='SELECT tas_spieler.nachname,tas_spieler.vorname,tas_spieler.geschlecht,tas_meldung.ak FROM tas_spieler,tas_meldung WHERE tas_spieler.id_vereine='.$_SESSION["verein"]["id"].' AND tas_spieler.id=tas_meldung.spieler_id AND tas_meldung.turnier_id='.$turniere_abgelaufen[$i]["id"].' ORDER BY tas_meldung.ak,tas_spieler.nachname,tas_spieler.vorname';
			$rs2=&$conn->Execute($sql2);
			$angemeldet=$rs2->getArray();
			$turniere_abgelaufen[$i]["anzahl_anmeldungen"]=count($angemeldet);
			$turniere_abgelaufen[$i]["infobox"]="";
			for ($j=0;$j<count($angemeldet);$j++)
			{
				$turniere_abgelaufen[$i]["infobox"].=$angemeldet[$j]["nachname"].', '.$angemeldet[$j]["vorname"].' ('.$angemeldet[$j]["ak"].")<br>";
			}
		}
	}
}
else
{
	$fehlermeldung_abgelaufen="Derzeit keine Turniere mit abgelaufener Meldefrist verfügbar.";
}

// LOGIN Check
if (!session_is_registered("verein")) // keine session, d.h. noch nicht angemeldet
{
	$smarty->assign('turniere',$turniere);
	$smarty->assign('turniere_abgelaufen',$turniere_abgelaufen);

	if ($_POST["doLoginSubmit"])
	{
		unset($rs);
		if ( $_POST["benutzer"] <> "" and $_POST["passwort"] <> "" ) {
		$sql='select * from tas_vereine where name="'.$_POST["benutzer"].'" AND passwort="'.$_POST["passwort"].'"';
		$rs = &$conn->Execute($sql);
		$v=$rs->GetArray();
}
		if (count($v))
		{
			$_SESSION["verein"]=$v[0];
			$_SESSION["meldung[0]"]=158;
			header("location:index.php");   //alles klar. session da. index neu aufrufen!
		}
		// keine übereinstimmung user/pw
		$smarty->assign('fehlermeldung_zugang',"Ihre Zugangsdaten scheinen leider nicht korrekt zu sein. Bitte versuchen Sie es ggf. erneut.");
	}
	$smarty->display('login.tpl.htm');
	exit;
}

elseif ($_POST["doSubmitEmail"])
{
	$sql="UPDATE tas_vereine SET ansprechpartner_name='".$_POST["ansprechpartner_name"]."', ansprechpartner_strasse='".$_POST["ansprechpartner_strasse"]."', ansprechpartner_plz_ort='".$_POST["ansprechpartner_plz_ort"]."', ansprechpartner_telefon='".$_POST["ansprechpartner_telefon"]."', ansprechpartner_mobil='".$_POST["ansprechpartner_mobil"]."', ansprechpartner_email='".$_POST["ansprechpartner_email"]."', ansprechpartner_bemerkung='".$_POST["ansprechpartner_bemerkung"]."' WHERE id=".$_SESSION["verein"]["id"];
	$rs = &$conn->Execute($sql) or die ("Fehler beim Aktualisieren der Email-Adresse. Bitte Administrator benachrichtigen.");

	unset($rs);                                                                 // vereinsdaten neu laden für session
	$sql='select * from tas_vereine where name="'.$_SESSION["verein"]["name"].'"';
	$rs = &$conn->Execute($sql);
	$v=$rs->GetArray();
	$_SESSION["verein"]=$v[0];
}


//smarty

$smarty->assign('fehlermeldung',$fehlermeldung);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('meldung',$meldung);
$smarty->assign('button_meldebildschirm',$button_meldebildschirm);
$smarty->assign('turniere',$turniere);
$smarty->assign('turniere_abgelaufen',$turniere_abgelaufen);
$smarty->assign('infobox',$infobox);

$smarty->assign('gmxuser',0);
if (strstr("gmx.",$_SESSION["email"]) ) $smarty->assign('gmxuser',1);
//$smarty->assign('infobox',$infobox_abgelaufen);

//$smarty->assign('spieler',$s);
//$smarty->assign('spielklasse',$spielklasse);

$smarty->display('turnierauswahl.tpl.htm');

$conn->Close(); # optional

//print "<pre>";
//print_r($_POST);
//print_r($s);

?>
