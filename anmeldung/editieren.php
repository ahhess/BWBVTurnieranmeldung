<?php
session_start();
if ($_POST["tid"]) $_SESSION["tid"]=$_POST["tid"];  //turnier id persistent

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

if (!session_is_registered("verein")) 
{
	die ('Sie sind nicht angemeldet. Bitte <a href=index.php>anmelden</a>');
}

elseif ($_POST["doInsertSubmit"])
{
	if (!trim($_POST["nachname"]) && !trim($_POST["vorname"]) )
	{
		$fehlermeldung="Vorname und Nachname eingeben!";
	}
	else
	{
		$sql ='INSERT INTO tas_spieler (vorname,nachname,geschlecht,geburtstag,passnummer,id_vereine) ';
		$sql.='VALUES ("'.trim($_POST["vorname"]).'","'.trim($_POST["nachname"]).'","'.trim($_POST["geschlecht"]).'","'.trim($_POST["jahr"]).'-'.trim($_POST["monat"]).'-'.trim($_POST["tag"]).'","'.trim($_POST["passnummer"]).'","'.$_SESSION["verein"]["id"].'")';
		$rs = &$conn->Execute($sql);
		if ($rs) $systemmeldung="Spieler wurde hinzugef�gt.";
		else $fehlermeldung="Fehler beim Hinzuf�gen des Spielers";
	}
}


elseif ($_POST["doSpielerAktualisieren"])
{
	//print "<pre>";print_r($_POST);
	
	foreach ($_POST["nachname"] as $id=>$nachname)
	{
		$nachname=trim($nachname);
		$vorname=trim($_POST["vorname"][$id]);
		$geschlecht=$_POST["geschlecht"][$id];
		$geburtstag=trim($_POST["geburtstag"][$id]);
        preg_match('/^[\d]{4}-[\d]{1,2}-[\d]{1,2}$/i',$geburtstag)?$geburtstag=$geburtstag:$geburtstag="'";
		$passnummer=trim($_POST["passnummer"][$id]);
		
		if ($nachname!="") $sql="UPDATE tas_spieler SET nachname='".$nachname."', vorname='".$vorname."', geburtstag='".$geburtstag."', passnummer='".$passnummer."', geschlecht='".$geschlecht."' WHERE id=".$id;
		else $sql="DELETE FROM tas_spieler WHERE id=".$id;
		//print $sql."<br>";
		$rs = &$conn->Execute($sql);
		if ($nachname!="")
		{
			if ($rs) $systemmeldung.="<b>".$nachname.", ".$vorname."</b> wurde aktualisiert<br>";
			else $fehlermeldung="Fehler! <b>".$nachname.", ".$vorname."</b> wurde nicht aktualisiert!";
		}
		else
		{
			if ($rs) $systemmeldung.="Spieler wurde gel�scht<br>";
			else $fehlermeldung="Fehler bei L�schung des Spielers!<br>";
		}
	}
}

unset($recordSet);
$sql='select * FROM tas_spieler WHERE id_vereine='.$_SESSION["verein"]["id"].' ORDER BY nachname,vorname';
//print $sql;
//print_r($_SESSION);
$recordSet = &$conn->Execute($sql);

$aVerein=array();
if (!$recordSet)
	print $conn->ErrorMsg();
else
	$s=$recordSet->GetArray();

$countS=count($s);

$recordSet->Close(); # optional

for ($i=0;$i<$countS;$i++) $s[$i]["spielklasse"]=spielklasse_berechnen($s[$i]["geburtstag"]);


$smarty->assign('fehlermeldung',$fehlermeldung);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('meldung',$meldung);
$smarty->assign('spieler',$s);
$smarty->assign('turnier',$turnier);
$smarty->assign('spielklasse',$spielklasse);

$smarty->display('editieren.tpl.htm');

$conn->Close(); # optional

//print "<pre>";
//print_r($_POST);
//print_r($s);


?>
