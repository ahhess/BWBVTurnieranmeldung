<?php
session_start();
include("config.inc.php");
include("funktionen.inc.php");

if ($_POST["admin"])
	check_admin_login();
else
	check_login();

include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$systemmeldung="";
	
if ($_POST["doInsertSubmit"])
{
	if (!trim($_POST["nachname"]) && !trim($_POST["vorname"]) )
		$fehlermeldung="Vorname und Nachname eingeben!";
	else
	{
		$sql ='INSERT INTO tas_spieler (vorname,nachname,geschlecht,geburtstag,id_vereine) ';
		$sql.='VALUES ("'.trim($_POST["vorname"]).'","'.trim($_POST["nachname"]).'","'.trim($_POST["geschlecht"]).'","'.trim($_POST["jahr"]).'-'.trim($_POST["monat"]).'-'.trim($_POST["tag"]).'","'.$_POST["id"].'")';
		$rs = &$conn->Execute($sql);
		if ($rs) 
			$systemmeldung="Spieler wurde hinzugefügt.";
		else 
			$fehlermeldung="Fehler beim Hinzufügen des Spielers";
	}
}
elseif ($_POST["doSpielerAktualisieren"])
{
	$updatemessage=0;
	//print "<pre>";print_r($_POST);	
	foreach ($_POST["nachname"] as $id=>$nachname)
	{
		$nachname=trim($nachname);
		$vorname=trim($_POST["vorname"][$id]);
		$geschlecht=$_POST["geschlecht"][$id];
		$geburtstag=trim($_POST["geburtstag"][$id]);
        preg_match('/^[\d]{4}-[\d]{1,2}-[\d]{1,2}$/i',$geburtstag)?$geburtstag=$geburtstag:$geburtstag="'";
		$passnummer=trim($_POST["passnummer"][$id]);
		
		if ($nachname!="") 
			$sql="UPDATE tas_spieler SET nachname='".$nachname."', vorname='".$vorname."', geburtstag='".$geburtstag."', passnummer='".$passnummer."', geschlecht='".$geschlecht."' WHERE id=".$id;
		else 
			$sql="DELETE FROM tas_spieler WHERE id=".$id;

		//print $sql."<br>";
		$rs = &$conn->Execute($sql);

		if ($nachname!="")
		{
			if ($rs)
				$updatemessage=1;
			else
				$fehlermeldung.="Fehler! <b>".$nachname.", ".$vorname."</b> wurde nicht aktualisiert! <!-- ".$sql." --><br>";
		}
		else
		{
			if ($rs) 
				$systemmeldung.="Spieler wurde gelöscht<br>";
			else 
				$fehlermeldung="Fehler bei Löschung des Spielers! <!-- ".$sql." --><br>";
		}
	}
	if ($updatemessage==1)
		$systemmeldung="&Auml;nderungen wurden gespeichert.<br>";
}

unset($recordSet);

if ($_POST["id"])
{
	$sql="select * from tas_vereine where id=".$_POST["id"];
	$recordSet = &$conn->Execute($sql);
	if (!$recordSet)
		print $conn->ErrorMsg();
	else
		$verein=$recordSet->GetArray();
		$verein=$verein[0];
}
else 
	$verein = $_SESSION["verein"];

$sql='select * FROM tas_spieler WHERE id_vereine='.$verein["id"].' ORDER BY nachname,vorname';
$recordSet = &$conn->Execute($sql);

if (!$recordSet)
	print $conn->ErrorMsg();
else
	$s=$recordSet->GetArray();

$recordSet->Close(); # optional
$conn->Close(); # optional

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('fehlermeldung',$fehlermeldung);
$smarty->assign('systemmeldung',$systemmeldung);
$smarty->assign('verein',$verein);
$smarty->assign('spieler',$s);
$smarty->assign('menuakt','editieren.php');
$smarty->assign('admin',$_SESSION["admin"]);

$smarty->display('editieren2.tpl.htm');
?>
