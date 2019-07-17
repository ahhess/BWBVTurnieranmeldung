<?php
// Aufbereitung der Kontaktdaten fuer ein bestimmtes Turnier
session_start();
include("config.inc.php");
include("../adodb/adodb.inc.php");

$debug = false;
if($_GET["debug"] == "true") $debug = true;

$conn = &ADONewConnection('mysql');
$conn->PConnect($host,$user,$password,$database); 
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
if ($debug) $conn->debug=true;

// turnierinfo holen
$sql='Select * FROM tas_turnier WHERE id='.$_GET["id"];
$recordSetTurnier = &$conn->Execute($sql);
$turnier=$recordSetTurnier->GetArray();
if (count($turnier)==0) die("TURNIER EXISTIERT NICHT!");
$turnier=$turnier[0];

// vereinskontaktdaten holen
$sql='select * from tas_vereine where id in (
    SELECT distinct verein_id FROM tas_meldung WHERE turnier_id = '.$_GET["id"].')';
	
$recordSetVereine = &$conn->Execute($sql) or die("SQL Error");
$vereine=$recordSetVereine->GetArray();

$header1=$turnier["name_lang"]." am ".$turnier["name_kurz"];
$header2="Kontaktdaten Stand ".date("d.m.Y - H:i");

if ($debug) {
	echo("<h1>".$header1."</h1>");
	echo("<h2>".$header2."</h2>");
	echo("<table border='1'><tr><th>Nr</th><th>Verein</th><th>Region</th><th>Kontakt</th><th>Email</th><th>Tel.</th><th>Mobil</th><th>Stasse</th><th>Ort</th><th>Bemerkung</th></tr>");
} else {
	// Creating a workbook
	require_once 'Spreadsheet/Excel/Writer.php';
	
	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->setVersion(8);
	$fett=& $workbook->addFormat();
	$fett->setBold();

	// sending HTTP headers: filename
	$workbook->send('bwbv_turnierkontakte_'.$turnier["id"].'_'.$turnier["datum"].'.xls');

	// Creating a worksheet Kontaktuebersicht
	$worksheet =& $workbook->addWorksheet('Kontaktuebersicht');
	$worksheet->setHeader($header2);
	$worksheet->setFooter($header1);

	// Kopfzeilen
	$r=0;
	$worksheet->write($r++, 0, $header1, $fett);
	$worksheet->write($r++, 0, $header2, $fett);

	// Uberschrift
	$r++;
	$c=0;
	$worksheet->write($r, $c++, "Nr", $fett);
    $worksheet->write($r, $c++, "Verein", $fett);
    $worksheet->write($r, $c++, "Region", $fett);
	$worksheet->write($r, $c++, "Ansprechpartner", $fett);    
	$worksheet->write($r, $c++, "Email", $fett);
	$worksheet->write($r, $c++, "Telefon", $fett);
	$worksheet->write($r, $c++, "Mobil", $fett);
	$worksheet->write($r, $c++, "Strasse", $fett);
	$worksheet->write($r, $c++, "PLZ Ort", $fett);
	$worksheet->write($r, $c++, "Bemerkung", $fett);
}

for ($i=0;$i<count($vereine);$i++) {
	$r++;
	$c=0;
	if ($debug) {
		echo("<tr><td>".$vereine[$i]["vereinsnr"]);
		echo("<td>".$vereine[$i]["davor"]." ".$vereine[$i]["name"]);
        echo("<td>".$vereine[$i]["region"]);
        echo("<td>".$vereine[$i]["ansprechpartner_name"]);
        echo("<td>".$vereine[$i]["ansprechpartner_email"]);
        echo("<td>".$vereine[$i]["ansprechpartner_telefon"]);
        echo("<td>".$vereine[$i]["ansprechpartner_mobil"]);
        echo("<td>".$vereine[$i]["ansprechpartner_strasse"]);
        echo("<td>".$vereine[$i]["ansprechpartner_plz_ort"]);
        echo("<td>".$vereine[$i]["Bemerkung"]);
	} else {
		$worksheet->write($r, $c++, $vereine[$i]["vereinsnr"]);
		$worksheet->write($r, $c++, $vereine[$i]["davor"]." ".$vereine[$i]["name"]);
		$worksheet->write($r, $c++, $vereine[$i]["region"]);
		$worksheet->write($r, $c++, $vereine[$i]["ansprechpartner_name"]);
		$worksheet->write($r, $c++, $vereine[$i]["ansprechpartner_email"]);
		$worksheet->write($r, $c++, $vereine[$i]["ansprechpartner_telefon"]);
		$worksheet->write($r, $c++, $vereine[$i]["ansprechpartner_mobil"]);
		$worksheet->write($r, $c++, $vereine[$i]["ansprechpartner_strasse"]);
		$worksheet->write($r, $c++, $vereine[$i]["ansprechpartner_plz_ort"]);
		$worksheet->write($r, $c++, $vereine[$i]["Bemerkung"]);
	}
}
	
if ($debug) {
	echo("</table>");
} else {	
	$workbook->close();
}
?>
