<?php
session_start();
include("config.inc.php");
include("funktionen.inc.php");
check_login();

if ($_POST["tid"]) 
	$_SESSION["tid"]=$_POST["tid"];  //turnier id in session merken

include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

if ($_POST["doInsertSubmit"])
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
		if ($rs) $systemmeldung="Spieler wurde hinzugefügt.";
		else $fehlermeldung="Fehler beim Hinzufügen des Spielers";
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
			if ($rs) $systemmeldung.="Spieler wurde gelöscht<br>";
			else $fehlermeldung="Fehler bei Löschung des Spielers!<br>";
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
$conn->Close(); # optional

for ($i=0;$i<$countS;$i++) $s[$i]["spielklasse"]=spielklasse_berechnen($s[$i]["geburtstag"]);

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('fehlermeldung',$fehlermeldung);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('meldung',$meldung);
$smarty->assign('spieler',$s);
$smarty->assign('turnier',$turnier);
$smarty->assign('spielklasse',$spielklasse);
$smarty->assign('menuakt','editieren.php');

$smarty->display('editieren2.tpl.htm');

//print "<pre>";
//print_r($_POST);
//print_r($s);
?>
