<?php
// Aufbereitung Excel-Datei mit den Spieleranmeldungen für ein bestimmtes Turnier
session_start();
include("config.inc.php");
include("../adodb/adodb.inc.php");

$debug = false;
if($_GET["debug"] == "true")
	$debug = true;

$conn = &ADONewConnection('mysql');
if ($debug) 
	$conn->debug=true;
$conn->PConnect($host,$user,$password,$database);   # connect to MS-Access, northwind dsn
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

// turnierinfo holen
$sqlT='Select * FROM tas_turnier WHERE id='.$_GET["id"];
$recordSetTurnier = &$conn->Execute($sqlT);
$turnier=$recordSetTurnier->GetArray();
if (count($turnier)==0) die("TURNIER EXISTIERT NICHT!");
$turnier=$turnier[0];

// spielermeldungen holen
$sql='select tas_spieler.*, tas_vereine.davor, tas_vereine.name as verein, 
	tas_meldung.verein_id, tas_meldung.ak as ak, tas_meldung.partner as partner 
	from tas_meldung, tas_spieler, tas_vereine
	where tas_meldung.turnier_id='.$_GET["id"].' 
	and tas_meldung.spieler_id=tas_spieler.id 
	and tas_meldung.verein_id=tas_vereine.id 
	order by tas_meldung.ak, tas_spieler.geschlecht, tas_vereine.name, tas_vereine.davor, tas_meldung.partner, tas_spieler.nachname';
	
$recordSetSpieler = &$conn->Execute($sql) or die("SQL Error");
$meldungen=$recordSetSpieler->GetArray();

// vereinsmeldungen (anmerkungen) holen
$vereinsmeldungen = array();
$sql='select * from tas_vereinsmeldung where turnier_id='.$_GET["id"];
$rs = &$conn->Execute($sql) or die("SQL Error");
if ($rs) {
	$vereinsmeldungen = $rs->GetArray();
}

$j=0;
$vereinsnamen=array();

for ($i=0;$i<count($meldungen);$i++) {
	$vn=$meldungen[$i]["davor"].' '.$meldungen[$i]["verein"];
	if (!in_array($vn,$vereinsnamen)) {
		$vereinsnamen[$j]=$vn;
		$verein2index[$vn]=$j;
		$verein_id[$vn]=$meldungen[$i]["verein_id"];
		$j++;
	}
	$spieler[$verein2index[$vn]][]=$i;
}

function getBoeDatum($geb) {
	return substr($geb,8,2).'.'.substr($geb,5,2).'.'.substr($geb,2,2);
}

$header1=$turnier["name_lang"]." am ".$turnier["name_kurz"];
$header2="Teilnehmerübersicht Stand ".date("d.m.Y - H:i");

if ($debug) {
	echo("<h1>".$header1."</h1>");
	echo("<h2>".$header2."</h2>");
	echo("<table border='1'><tr><td>Spieler-ID<td>Nachname<td>Vorname<td>Verein<td>Geburtstag<td>AK<td>Geschlecht<td>Partner");
} else {
	// Creating a workbook
	require_once 'Spreadsheet/Excel/Writer.php';
	
	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->setVersion(8);
	$fett=& $workbook->addFormat();
	$fett->setBold();

	// sending HTTP headers: filename
	$workbook->send('bwbv_turniermeldung_'.$turnier["id"].'_'.$turnier["datum"].'.xls');

	// Creating a worksheet Teilnehmeruebersicht
	$worksheet =& $workbook->addWorksheet('Teilnehmerübersicht');
	$worksheet->setHeader($header2);
	$worksheet->setFooter($header1);

	// Kopfzeilen
	$r=0;
	$worksheet->write($r++, 0, $header1, $fett);
	$worksheet->write($r++, 0, $header2, $fett);

	// Uberschrift Spielerdaten
	$r++;
	$c=0;
	$worksheet->write($r, $c++, "Spieler-ID", $fett);
	$worksheet->write($r, $c++, "Nachname", $fett);
	$worksheet->write($r, $c++, "Vorname", $fett);
	$worksheet->write($r, $c++, "Verein", $fett);
	$worksheet->write($r, $c++, "Geburtstag", $fett);
	$worksheet->write($r, $c++, "AK", $fett);
	$worksheet->write($r, $c++, "Geschlecht", $fett);
	$worksheet->write($r, $c++, "Partner", $fett);
}

// Spielerdaten
for ($i=0;$i<count($meldungen);$i++) {
	$r++;
	$c=0;
	if ($debug) {
		echo("<tr><td>".$meldungen[$i]["passnummer"]);
		echo("<td>".$meldungen[$i]["nachname"]);
		echo("<td>".$meldungen[$i]["vorname"]);
		echo("<td>".$meldungen[$i]["davor"]." ".$meldungen[$i]["verein"]);
		echo("<td>".getBoeDatum($meldungen[$i]["geburtstag"]));
		echo("<td>".$meldungen[$i]["ak"]);
		echo("<td>".$meldungen[$i]["geschlecht"]);
		echo("<td>".$meldungen[$i]["partner"]);
	} else {
		$worksheet->write($r, $c++, $meldungen[$i]["passnummer"]);
		$worksheet->write($r, $c++, $meldungen[$i]["nachname"]);
		$worksheet->write($r, $c++, $meldungen[$i]["vorname"]);
		$worksheet->write($r, $c++, $meldungen[$i]["davor"]." ".$meldungen[$i]["verein"]);
		$worksheet->write($r, $c++, getBoeDatum($meldungen[$i]["geburtstag"]));
		$worksheet->write($r, $c++, $meldungen[$i]["ak"]);
		$worksheet->write($r, $c++, $meldungen[$i]["geschlecht"]);
		$worksheet->write($r, $c++, $meldungen[$i]["partner"]);
	}
}
	
if ($debug) {
	echo("</table>");
}	

if($_GET["cnt"])
	$cnt=$_GET["cnt"];
else
	$cnt=65000;

// Worksheet je Verein fuer Startgelder
for ($i=0;$i<$cnt && $i<count($vereinsnamen);$i++) {
	$header2="Teilnehmerübersicht und Startgeldaufstellung für ".$vereinsnamen[$i]." (Stand ".date("d.m.Y - H:i").")";
	$sheetname=str_replace("/", "-", $vereinsnamen[$i]);
	if ($debug) {
		echo("<h2>".$header2."</h2>");
		echo("<h3>".$sheetname."</h3>");
		echo("<table border='1'><tr><td>Spieler-ID<td>Nachname<td>Vorname<td>Geburtstag<td>AK<td>Geschlecht<td>Partner");
	} else {
		$worksheet =& $workbook->addWorksheet($sheetname);
		$worksheet->setHeader($header2);
		$worksheet->setFooter($header1);
		$worksheet->hideGridlines();
		//$worksheet->insertBitmap(0,3,"img/logo_bwbv.bmp",40,0,0.8);
		$r=0;
		$worksheet->write($r++, 0, $header1, $fett);
		$worksheet->write($r++, 0, $header2, $fett);
		//$worksheet->write(0, 0, "Startgelder:",$fett);
		//$worksheet->write(0, 1, $vereinsnamen[$i],$fett);

		$r++;
		$r++;
		$c=0;
		$worksheet->write($r, $c++, "Spieler-ID", $fett);
		$worksheet->write($r, $c++, "Nachname", $fett);
		$worksheet->write($r, $c++, "Vorname", $fett);
		$worksheet->write($r, $c++, "Geburtstag", $fett);
		$worksheet->write($r, $c++, "AK", $fett);
		$worksheet->write($r, $c++, "Geschlecht", $fett);
		$worksheet->write($r, $c++, "Partner", $fett);
	}
	
	for ($j=0;$j<count($spieler[$i]);$j++) {
		$r++;
		$c=0;
		if ($debug) {
			echo("<tr><td>".$meldungen[$spieler[$i][$j]]["passnummer"]);
			echo("<td>".$meldungen[$spieler[$i][$j]]["nachname"]);
			echo("<td>".$meldungen[$spieler[$i][$j]]["vorname"]);
			echo("<td>".getBoeDatum($meldungen[$spieler[$i][$j]]["geburtstag"]));
			echo("<td>".$meldungen[$spieler[$i][$j]]["ak"]);
			echo("<td>".$meldungen[$spieler[$i][$j]]["geschlecht"]);
			echo("<td>".$meldungen[$spieler[$i][$j]]["partner"]);
		} else {
			$worksheet->write($r, $c++, $meldungen[$spieler[$i][$j]]["nachname"]);
			$worksheet->write($r, $c++, $meldungen[$spieler[$i][$j]]["vorname"]);
			$worksheet->write($r, $c++, getBoeDatum($meldungen[$spieler[$i][$j]]["geburtstag"]));
			$worksheet->write($r, $c++, $meldungen[$spieler[$i][$j]]["ak"]);
			$worksheet->write($r, $c++, $meldungen[$spieler[$i][$j]]["geschlecht"]);
			$worksheet->write($r, $c++, $meldungen[$spieler[$i][$j]]["partner"]);
		}
	}

	//startgebuehr
	$r++;
	$startgebuehr=7;
	$summe= "Summe = ".count($spieler[$i])." x ".$startgebuehr." EURO = ".(count($spieler[$i]) * $startgebuehr)." EURO";
	if ($debug) {
		echo("</table>");
		echo("<p>".$summe);
	} else {
		$worksheet->write($r++, 0,"-------------------------------");
		$worksheet->write($r++, 0,$summe, $fett);
	}

	//anmerkungen ausgeben
	for ($j=0;$j<count($vereinsmeldungen);$j++) {
		if ($vereinsmeldungen[$j]["verein_id"] == $verein_id[$vereinsnamen[$i]]) {
			if ($vereinsmeldungen[$j]["anmerkung"]) {
				$anm = preg_replace("/[\\n\\r]+/", " ", $vereinsmeldungen[$j]["anmerkung"]);
				if ($debug) {
					echo("<p>Anmerkungen: ".$anm);
				} else {
					$r++;
					$worksheet->write($r++, 0, "Anmerkungen des Vereins:");
					$worksheet->write($r++, 0, $anm);
				}
			}
			break;
		}
	}
}
if (!$debug) 
	$workbook->close();
?>
