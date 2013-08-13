<?php
// Aufbereitung Excel-Datei mit den Spieleranmeldungen f�r ein bestimmtes Turnier

session_start();
include("config.inc.php");
include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');	# create a connection
//$conn->debug=true;
$conn->PConnect($host,$user,$password,$database);   # connect to MS-Access, northwind dsn
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

// tas_vereine holen
$sql='select tas_spieler.*, tas_vereine.davor, tas_vereine.name as verein, tas_meldung.ak as ak, tas_turnier.name_lang as turnier, tas_meldung.anmerkung as anmerkung from tas_meldung,tas_spieler,tas_vereine,tas_turnier where tas_meldung.spieler_id=tas_spieler.id and ';
$sql.='tas_meldung.turnier_id='.$_GET["id"].' and tas_meldung.verein_id=tas_vereine.id and tas_turnier.id=tas_meldung.turnier_id order by tas_spieler.geschlecht asc, tas_meldung.ak asc, tas_spieler.nachname';
$recordSetSpieler = &$conn->Execute($sql);
$meldungen=$recordSetSpieler->GetArray();

// turnierinfo holen
$sqlT='Select * FROM tas_turnier WHERE id='.$_GET["id"];
$recordSetTurnier = &$conn->Execute($sqlT);
$turnier=$recordSetTurnier->GetArray();
if (count($turnier)==0) die("TURNIER EXISTIERT NICHT!");
$turnier=$turnier[0];

//print_r($turnier);exit;
//print_r($meldungen);

$conn->Close(); # optional


$j=0;
$index2verein=array();

for ($i=0;$i<count($meldungen);$i++) {
	if (!in_array($meldungen[$i]["verein"],$index2verein)) {
		//$index2verein[$j]=$meldungen[$i]["davor"].' '.$meldungen[$i]["verein"];
		$index2verein[$j]=$meldungen[$i]["verein"];
		$verein2index[$meldungen[$i]["verein"]]=$j;
		$j++;
	}
	$spieler[$verein2index[$meldungen[$i]["verein"]]][]=$i;
}

require_once 'Spreadsheet/Excel/Writer.php';

// Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();
$workbook->setVersion(8);
$fett=& $workbook->addFormat();
$fett->setBold();

// sending HTTP headers
$workbook->send('turniermeldung_nb_'.$turnier["datum"].'.xls');

// Creating a worksheet Teilnehmeruebersicht
$worksheet =& $workbook->addWorksheet('Teilnehmer�bersicht');
$worksheet->setHeader("BWBV Turnieranmeldung Teilnehmer�bersicht");
$worksheet->setFooter($turnier["name_lang"].", ".$turnier["datum"]."\nStand ".date("d.m.Y - H:i")." Uhr");

// Uberschrift Spielerdaten
$worksheet->write(0, 0, "Nachname");
$worksheet->write(0, 1, "Vorname");
$worksheet->write(0, 2, "Kuerzel");
$worksheet->write(0, 3, "Verein");
$worksheet->write(0, 4, "AK");
$worksheet->write(0, 5, "Passnummer");
$worksheet->write(0, 6, "Geburtstag");
$worksheet->write(0, 7, "Geschlecht");

// Spielerdaten
for ($i=0;$i<count($meldungen);$i++) {
	$worksheet->write($i+2, 0, $meldungen[$i]["nachname"]);
	$worksheet->write($i+2, 1, $meldungen[$i]["vorname"]);
	$worksheet->write($i+2, 2, $meldungen[$i]["davor"]);
	$worksheet->write($i+2, 3, $meldungen[$i]["verein"]);
	$worksheet->write($i+2, 4, $meldungen[$i]["ak"]);
	$worksheet->write($i+2, 5, $meldungen[$i]["passnummer"]);
	$worksheet->write($i+2, 6, $meldungen[$i]["geburtstag"]);
	$worksheet->write($i+2, 7, $meldungen[$i]["geschlecht"]);
}

// Worksheet je Verein fuer Startgelder
for ($i=0;$i<count($index2verein);$i++) {

	$worksheet_v[$i] =& $workbook->addWorksheet($index2verein[$i]);
	$worksheet_v[$i]->setHeader("Teilnehmer�bersicht und Startgeldaufstellung f�r ".$index2verein[$i]);
	$worksheet_v[$i]->setFooter($turnier["name_lang"].", ".$turnier["datum"]."\nStand ".date("d.m.Y - H:i")." Uhr");
	$worksheet_v[$i]->hideGridlines();

	//$worksheet_v[$i]->insertBitmap(0,3,"img/logo_bwbv.bmp",40,0,0.8);

	$worksheet_v[$i]->write(0, 0, "Startgelder ".$index2verein[$i]." *",$fett);

	$worksheet_v[$i]->write(2, 0, "Nachname");
	$worksheet_v[$i]->write(2, 1, "Vorname");
	$worksheet_v[$i]->write(2, 2, "AK");
	$worksheet_v[$i]->write(2, 3, "Passnummer");
	$worksheet_v[$i]->write(2, 4, "Geburtstag");
	$worksheet_v[$i]->write(2, 5, "Geschlecht");

	for ($j=0;$j<count($spieler[$i]);$j++) {
		$worksheet_v[$i]->write($j+3, 0, $meldungen[$spieler[$i][$j]]["nachname"]);
		$worksheet_v[$i]->write($j+3, 1, $meldungen[$spieler[$i][$j]]["vorname"]);
		$worksheet_v[$i]->write($j+3, 2, $meldungen[$spieler[$i][$j]]["ak"]);
		$worksheet_v[$i]->write($j+3, 3, $meldungen[$spieler[$i][$j]]["passnummer"]);
		$worksheet_v[$i]->write($j+3, 4, $meldungen[$spieler[$i][$j]]["geburtstag"]);
		$worksheet_v[$i]->write($j+3, 5, $meldungen[$spieler[$i][$j]]["geschlecht"]);
		//$aktuelle_anmerkung=$meldungen[$spieler[$i][$j]]["anmerkung"];	//not used yet	
	}

	//$summe= "Summe = ".count($spieler[$i])." x 5 EURO = ".(count($spieler[$i])*5)." EURO";
	//$zeile_summe=count($spieler[$i])+$versatz2+1;
	//$worksheet_v[$i]->write($zeile_summe-1, 0,"-------------------------------");
	//$worksheet_v[$i]->write($zeile_summe, 0,$summe);
	//$worksheet_v[$i]->write($zeile_summe+2, 0,"* Voraussichtlich zu entrichten. Startgelder k�nnen je nach Meldestand zum Termin variieren.");
	//$worksheet_v[$i]->write($zeile_summe+4, 0,$aktuelle_anmerkung); 
	//$aktuelle_anmerkung="";

}

$workbook->close();
?>

