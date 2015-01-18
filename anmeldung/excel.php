<?php
// Aufbereitung Excel-Datei mit den Spieleranmeldungen für ein bestimmtes Turnier

session_start();
include("config.inc.php");
include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');	# create a connection
//$conn->debug=true;
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

require_once 'Spreadsheet/Excel/Writer.php';

// Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();
$workbook->setVersion(8);
$fett=& $workbook->addFormat();
$fett->setBold();

// sending HTTP headers: filename
$workbook->send('bwbv_turniermeldung_'.$turnier["id"].'_'.$turnier["datum"].'.xls');

$header1=$turnier["name_lang"]." am ".$turnier["name_kurz"];
$header2="Teilnehmerübersicht Stand ".date("d.m.Y - H:i");

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
$worksheet->write($r, $c++, "Nachname", $fett);
$worksheet->write($r, $c++, "Vorname", $fett);
$worksheet->write($r, $c++, "Kuerzel", $fett);
$worksheet->write($r, $c++, "Verein", $fett);
$worksheet->write($r, $c++, "Passnummer", $fett);
$worksheet->write($r, $c++, "Geburtstag", $fett);
$worksheet->write($r, $c++, "AK", $fett);
$worksheet->write($r, $c++, "Geschlecht", $fett);
$worksheet->write($r, $c++, "Partner", $fett);

// Spielerdaten
for ($i=0;$i<count($meldungen);$i++) {
	$r++;
	$c=0;
	$worksheet->write($r, $c++, $meldungen[$i]["nachname"]);
	$worksheet->write($r, $c++, $meldungen[$i]["vorname"]);
	$worksheet->write($r, $c++, $meldungen[$i]["davor"]);
	$worksheet->write($r, $c++, $meldungen[$i]["verein"]);
	$worksheet->write($r, $c++, $meldungen[$i]["passnummer"]);
	$worksheet->write($r, $c++, getBoeDatum($meldungen[$i]["geburtstag"]));
	$worksheet->write($r, $c++, $meldungen[$i]["ak"]);
	$worksheet->write($r, $c++, $meldungen[$i]["geschlecht"]);
	$worksheet->write($r, $c++, $meldungen[$i]["partner"]);
}

// Worksheet je Verein fuer Startgelder
for ($i=0;$i<count($vereinsnamen);$i++) {
	$header2="Teilnehmerübersicht und Startgeldaufstellung für ".$vereinsnamen[$i]." (Stand ".date("d.m.Y - H:i").")";

	$worksheet_v[$i] =& $workbook->addWorksheet(str_replace("/", "-", $vereinsnamen[$i]));
	$worksheet_v[$i]->setHeader($header2);
	$worksheet_v[$i]->setFooter($header1);
	$worksheet_v[$i]->hideGridlines();

	//$worksheet_v[$i]->insertBitmap(0,3,"img/logo_bwbv.bmp",40,0,0.8);

	$r=0;
	$worksheet_v[$i]->write($r++, 0, $header1, $fett);
	$worksheet_v[$i]->write($r++, 0, $header2, $fett);
	//$worksheet_v[$i]->write(0, 0, "Startgelder:",$fett);
	//$worksheet_v[$i]->write(0, 1, $vereinsnamen[$i],$fett);

	$r++;
	$r++;
	$c=0;
	$worksheet_v[$i]->write($r, $c++, "Nachname", $fett);
	$worksheet_v[$i]->write($r, $c++, "Vorname", $fett);
	$worksheet_v[$i]->write($r, $c++, "Passnummer", $fett);
	$worksheet_v[$i]->write($r, $c++, "Geburtstag", $fett);
	$worksheet_v[$i]->write($r, $c++, "AK", $fett);
	$worksheet_v[$i]->write($r, $c++, "Geschlecht", $fett);
	$worksheet_v[$i]->write($r, $c++, "Partner", $fett);

	for ($j=0;$j<count($spieler[$i]);$j++) {
		$r++;
		$c=0;
		$worksheet_v[$i]->write($r, $c++, $meldungen[$spieler[$i][$j]]["nachname"]);
		$worksheet_v[$i]->write($r, $c++, $meldungen[$spieler[$i][$j]]["vorname"]);
		$worksheet_v[$i]->write($r, $c++, $meldungen[$spieler[$i][$j]]["passnummer"]);
		$worksheet_v[$i]->write($r, $c++, getBoeDatum($meldungen[$spieler[$i][$j]]["geburtstag"]));
		$worksheet_v[$i]->write($r, $c++, $meldungen[$spieler[$i][$j]]["ak"]);
		$worksheet_v[$i]->write($r, $c++, $meldungen[$spieler[$i][$j]]["geschlecht"]);
		$worksheet_v[$i]->write($r, $c++, $meldungen[$spieler[$i][$j]]["partner"]);
	}
	$r++;
	$startgebuehr=7;
	$summe= "Summe = ".count($spieler[$i])." x ".$startgebuehr." EURO = ".(count($spieler[$i]) * $startgebuehr)." EURO";
	$worksheet_v[$i]->write($r++, 0,"-------------------------------");
	$worksheet_v[$i]->write($r++, 0,$summe, $fett);

	//anmerkungen ausgeben
	for ($j=0;$j<count($vereinsmeldungen);$j++) {
		if ($vereinsmeldungen[$j]["verein_id"] == $verein_id[$vereinsnamen[$i]]) {
			if ($vereinsmeldungen[$j]["anmerkung"]) {
				$r++;
				$worksheet_v[$i]->write($r++, 0, "Anmerkungen des Vereins:");
				$worksheet_v[$i]->write($r++, 0, preg_replace("/[\\n\\r]+/", " ", $vereinsmeldungen[$j]["anmerkung"]));
			}
			break;
		}
	}
}
$workbook->close();
?>
