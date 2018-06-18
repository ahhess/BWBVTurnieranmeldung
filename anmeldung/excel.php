<?php
// Aufbereitung Excel-Datei mit den Spieleranmeldungen f�r ein bestimmtes Turnier
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
	tas_meldung.verein_id, tas_meldung.ak, tas_meldung.partner, tas_meldung.partner2, tas_meldung.bemerkung 
	from tas_meldung, tas_spieler, tas_vereine
	where tas_meldung.turnier_id='.$_GET["id"].' 
	and tas_meldung.spieler_id=tas_spieler.id 
	and tas_meldung.verein_id=tas_vereine.id 
	order by tas_meldung.ak, tas_spieler.geschlecht, tas_vereine.name, tas_vereine.davor, tas_spieler.nachname, tas_spieler.vorname';
	
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
$header2="Teilnehmer�bersicht Stand ".date("d.m.Y - H:i");

if ($debug) {
	echo("<h1>".$header1."</h1>");
	echo("<h2>".$header2."</h2>");
	echo("<table border='1'><tr><td>Spieler-ID<td>Nachname<td>Vorname<td>Verein<td>Geburtstag<td>AK<td>Geschlecht<td>Doppelpartner<td>Mixedpartner<td>Bemerkung");
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
	$worksheet =& $workbook->addWorksheet('Teilnehmer�bersicht');
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
	$worksheet->write($r, $c++, "Doppelpartner", $fett);
	$worksheet->write($r, $c++, "Mixedpartner", $fett);
	$worksheet->write($r, $c++, "Bemerkung", $fett);
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
		echo("<td>".$meldungen[$i]["partner2"]);
		echo("<td>".$meldungen[$i]["bemerkung"]);
	} else {
		$worksheet->write($r, $c++, $meldungen[$i]["passnummer"]);
		$worksheet->write($r, $c++, $meldungen[$i]["nachname"]);
		$worksheet->write($r, $c++, $meldungen[$i]["vorname"]);
		$worksheet->write($r, $c++, $meldungen[$i]["davor"]." ".$meldungen[$i]["verein"]);
		$worksheet->write($r, $c++, getBoeDatum($meldungen[$i]["geburtstag"]));
		$worksheet->write($r, $c++, $meldungen[$i]["ak"]);
		$worksheet->write($r, $c++, $meldungen[$i]["geschlecht"]);
		$worksheet->write($r, $c++, $meldungen[$i]["partner"]);
		$worksheet->write($r, $c++, $meldungen[$i]["partner2"]);
		$worksheet->write($r, $c++, $meldungen[$i]["bemerkung"]);
	}
}
	
if ($debug) {
	echo("</table>");
}	

// Worksheet fuer Startgelder je Verein
$sheetname="Startgelder";
$header2="Startgelder (Stand ".date("d.m.Y - H:i").")";
$startgebuehr=7;	

if ($debug) {
	echo("<h2>".$header2."</h2>");
	echo("<table border='1'><tr><td>Verein<td>Anzahl Teilnehmer<td>x ".$startgebuehr." EURO<td>Anmerkungen des Vereins");
} else {
	$worksheet =& $workbook->addWorksheet($sheetname);
	$worksheet->setHeader($header2);
	$worksheet->setFooter($header1);
	$worksheet->hideGridlines();
	$r=0;
	$worksheet->write($r++, 0, $header1, $fett);
	$worksheet->write($r++, 0, $header2, $fett);

	$r++;
	$c=0;
	$worksheet->write($r, $c++, "Verein", $fett);
	$worksheet->write($r, $c++, "Anzahl Teilnehmer", $fett);
	$worksheet->write($r, $c++, "x ".$startgebuehr." EURO", $fett);
	$worksheet->write($r, $c++, "Anmerkungen des Vereins", $fett);
}
for ($i=0;$i<count($vereinsnamen);$i++) {
	$summe=count($spieler[$i]) * $startgebuehr;
	$r++;
	$c=0;
	if ($debug) {
		echo("<tr><td>".$vereinsnamen[$i]);
		echo("<td>".count($spieler[$i]));
		echo("<td>".$summe);
		echo("<td>");
	} else {
		$worksheet->write($r, $c++, $vereinsnamen[$i]);
		$worksheet->write($r, $c++, count($spieler[$i]));
		$worksheet->write($r, $c++, $summe);
	}

	//anmerkungen ausgeben
	for ($j=0;$j<count($vereinsmeldungen);$j++) {
		if ($vereinsmeldungen[$j]["verein_id"] == $verein_id[$vereinsnamen[$i]]) {
			if ($vereinsmeldungen[$j]["anmerkung"]) {
				$anm = preg_replace("/[\\n\\r]+/", " ", $vereinsmeldungen[$j]["anmerkung"]);
				if ($debug) {
					echo($anm);
				} else {
					$worksheet->write($r, $c++, $anm);
				}
			}
			break;
		}
	}
}
if ($debug) {
	echo("</table>");
} else {	
	$workbook->close();
}
?>
