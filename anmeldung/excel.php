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
	tas_meldung.verein_id, tas_meldung.ak as ak, tas_meldung.partner as partner, 
	tas_turnier.name_lang as turnier
	from tas_meldung,tas_spieler,tas_vereine,tas_turnier 
	where tas_meldung.spieler_id=tas_spieler.id 
	and tas_meldung.turnier_id='.$_GET["id"].' 
	and tas_meldung.verein_id=tas_vereine.id 
	and tas_turnier.id=tas_meldung.turnier_id 
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

// sending HTTP headers
$workbook->send('bwbv_turniermeldung_'.$turnier["id"].'_'.$turnier["datum"].'.xls');

// Creating a worksheet Teilnehmeruebersicht
$worksheet =& $workbook->addWorksheet('Teilnehmerübersicht');
$worksheet->setHeader("BWBV Turnieranmeldung Teilnehmerübersicht");
$worksheet->setFooter($turnier["name_lang"].", ".$turnier["datum"]."\nStand ".date("d.m.Y - H:i")." Uhr");

// Uberschrift Spielerdaten
$c=0;
$worksheet->write(0, $c++, "Nachname");
$worksheet->write(0, $c++, "Vorname");
$worksheet->write(0, $c++, "Kuerzel");
$worksheet->write(0, $c++, "Verein");
$worksheet->write(0, $c++, "Passnummer");
$worksheet->write(0, $c++, "Geburtstag");
$worksheet->write(0, $c++, "AK");
$worksheet->write(0, $c++, "Geschlecht");
$worksheet->write(0, $c++, "Partner");

// Spielerdaten
for ($i=0;$i<count($meldungen);$i++) {
	$c=0;
	$worksheet->write($i+2, $c++, $meldungen[$i]["nachname"]);
	$worksheet->write($i+2, $c++, $meldungen[$i]["vorname"]);
	$worksheet->write($i+2, $c++, $meldungen[$i]["davor"]);
	$worksheet->write($i+2, $c++, $meldungen[$i]["verein"]);
	$worksheet->write($i+2, $c++, $meldungen[$i]["passnummer"]);
	$worksheet->write($i+2, $c++, getBoeDatum($meldungen[$i]["geburtstag"]));
	$worksheet->write($i+2, $c++, $meldungen[$i]["ak"]);
	$worksheet->write($i+2, $c++, $meldungen[$i]["geschlecht"]);
	$worksheet->write($i+2, $c++, $meldungen[$i]["partner"]);
}

// Worksheet je Verein fuer Startgelder
for ($i=0;$i<count($vereinsnamen);$i++) {

	$worksheet_v[$i] =& $workbook->addWorksheet(str_replace("/", "-", $vereinsnamen[$i]));
	$worksheet_v[$i]->setHeader("Teilnehmerübersicht und Startgeldaufstellung für ".$vereinsnamen[$i]);
	$worksheet_v[$i]->setFooter($turnier["name_lang"].", ".$turnier["datum"]."\nStand ".date("d.m.Y - H:i")." Uhr");
	$worksheet_v[$i]->hideGridlines();

	//$worksheet_v[$i]->insertBitmap(0,3,"img/logo_bwbv.bmp",40,0,0.8);

	$worksheet_v[$i]->write(0, 0, "Startgelder:",$fett);
	$worksheet_v[$i]->write(0, 1, $vereinsnamen[$i],$fett);

	$c=0;
	$worksheet_v[$i]->write(2, $c++, "Nachname");
	$worksheet_v[$i]->write(2, $c++, "Vorname");
	$worksheet_v[$i]->write(2, $c++, "Passnummer");
	$worksheet_v[$i]->write(2, $c++, "Geburtstag");
	$worksheet_v[$i]->write(2, $c++, "AK");
	$worksheet_v[$i]->write(2, $c++, "Geschlecht");
	$worksheet_v[$i]->write(2, $c++, "Partner");

	$zeile = 3;
	for ($j=0;$j<count($spieler[$i]);$j++) {
		$c=0;
		$worksheet_v[$i]->write($zeile, $c++, $meldungen[$spieler[$i][$j]]["nachname"]);
		$worksheet_v[$i]->write($zeile, $c++, $meldungen[$spieler[$i][$j]]["vorname"]);
		$worksheet_v[$i]->write($zeile, $c++, $meldungen[$spieler[$i][$j]]["passnummer"]);
		$worksheet_v[$i]->write($zeile, $c++, getBoeDatum($meldungen[$spieler[$i][$j]]["geburtstag"]));
		$worksheet_v[$i]->write($zeile, $c++, $meldungen[$spieler[$i][$j]]["ak"]);
		$worksheet_v[$i]->write($zeile, $c++, $meldungen[$spieler[$i][$j]]["geschlecht"]);
		$worksheet_v[$i]->write($zeile, $c++, $meldungen[$spieler[$i][$j]]["partner"]);
		$zeile++;
	}
	$zeile++;
	$startgebuehr=7;
	$summe= "Summe = ".count($spieler[$i])." x ".$startgebuehr." EURO = ".(count($spieler[$i]) * $startgebuehr)." EURO";
	$worksheet_v[$i]->write($zeile++, 0,"-------------------------------");
	$worksheet_v[$i]->write($zeile++, 0,$summe);

	//anmerkungen ausgeben
	for ($j=0;$j<count($vereinsmeldungen);$j++) {
		if ($vereinsmeldungen[$j]["verein_id"] == $verein_id[$vereinsnamen[$i]]) {
			if ($vereinsmeldungen[$j]["anmerkung"]) {
				$zeile++;
				$worksheet_v[$i]->write($zeile++, 0, "Anmerkungen des Vereins:");
				$worksheet_v[$i]->write($zeile++, 0, preg_replace("/[\\n\\r]+/", " ", $vereinsmeldungen[$j]["anmerkung"]));
			}
			break;
		}
	}
}
$workbook->close();
?>
