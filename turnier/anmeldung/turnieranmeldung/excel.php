<?php

// Anzeige der Spieleranmeldungen für ein bestimmtes Turnier



session_start();

include("config.inc.php");



function spielklasse_berechnen($mysql_date)

{

	$year=substr($mysql_date,0,4);

	$d=(date("Y")-$year+2);

	if (ceil($d/2) == $d/2) $d++;

	return "U".$d;

}



$spielklasse["U9"]="U9";

$spielklasse["U11"]="U11";

$spielklasse["U13"]="U13";

$spielklasse["U15"]="U15";

$spielklasse["U17"]="U17";

$spielklasse["U19"]="U19";

$spielklasse["ERW"]="ERW";





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

$smarty->caching = false;


$sql='select tas_spieler.*, tas_vereine.davor, tas_vereine.name as verein, tas_meldung.ak as ak, tas_turnier.name_lang as turnier, tas_meldung.anmerkung as anmerkung from tas_meldung,tas_spieler,tas_vereine,tas_turnier where tas_meldung.spieler_id=tas_spieler.id and ';

$sql.='tas_meldung.turnier_id='.$_GET["id"].' and tas_meldung.verein_id=tas_vereine.id and tas_turnier.id=tas_meldung.turnier_id order by tas_spieler.geschlecht asc, tas_meldung.ak asc, tas_spieler.nachname';

$recordSetSpieler = &$conn->Execute($sql);



$meldungen=$recordSetSpieler->GetArray();

$turniername=$meldungen[0]["turnier"];

//vereine holen

$sqlV='select DISTINCT tas_vereine.davor, tas_vereine.name from tas_meldung,tas_spieler,tas_vereine where tas_meldung.spieler_id=tas_spieler.id and ';

$sqlV.='tas_meldung.turnier_id='.$_GET["id"].' and tas_meldung.verein_id=tas_vereine.id';

$recordSetVereine = &$conn->Execute($sqlV);



$vereine=$recordSetVereine->GetArray();



// turnierinfo holen

$sqlT='Select * FROM tas_turnier WHERE id='.$_GET["id"];

$recordSetTurnier = &$conn->Execute($sqlT);

$t=$recordSetTurnier->GetArray();

if (count($t)==0) die("TURNIER EXISTIERT NICHT!");

$t=$t[0];

//print_r($t);exit;



//print "<pre>";print_r($meldungen);

$smarty->assign('meldungen',$meldungen);

$smarty->assign('countMeldungen',count($meldungen));

$smarty->assign('vereine',$vereine);

$smarty->assign('countVereine',count($vereine));

$smarty->assign('turniername',$turniername);



$smarty->assign('datum',date('d.m.Y'));

$smarty->assign('zeit',date('G:i'));





//$smarty->display('anzeige.tpl.htm');

//print_r($meldungen);



$conn->Close(); # optional





$j=0;

$index2verein=array();

for ($i=0;$i<count($meldungen);$i++) {

	if (!in_array($meldungen[$i]["verein"],$index2verein)) {

		$index2verein[$j]=$meldungen[$i]["verein"];

		$verein2index[$meldungen[$i]["verein"]]=$j;

		$j++;

	}

	$spieler[$verein2index[$meldungen[$i]["verein"]]][]=$i;

}

//print "<pre>";

//print_r($index2verein);

//print_r($spieler);



require_once 'Spreadsheet/Excel/Writer.php';



// Creating a workbook

$workbook = new Spreadsheet_Excel_Writer();

$workbook->setVersion(8);



$fett=& $workbook->addFormat();

$fett->setBold();



// sending HTTP headers

$workbook->send('turniermeldung_nb_'.$t["datum"].'.xls');



// Creating a worksheet

$worksheet =& $workbook->addWorksheet('Teilnehmerübersicht');

$worksheet->setHeader("Teilnehmerübersicht\nwww.esentri.de/turnieranmeldung");

$worksheet->setFooter($t["name_lang"].", ".$t["datum"]."\nStand ".date("d.m.Y - H:i")." Uhr");



// The actual data

for ($i=0;$i<count($meldungen);$i++) {

	$worksheet->write($i, 0, $meldungen[$i]["nachname"]);

	$worksheet->write($i, 1, $meldungen[$i]["vorname"]);

	$worksheet->write($i, 2, $meldungen[$i]["davor"]);

	$worksheet->write($i, 3, $meldungen[$i]["verein"]);

	$worksheet->write($i, 4, $meldungen[$i]["ak"]);

	$worksheet->write($i, 5, $meldungen[$i]["passnummer"]);

	$worksheet->write($i, 6, $meldungen[$i]["geburtstag"]);

	$worksheet->write($i, 7, $meldungen[$i]["geschlecht"]);

/*	$worksheet->write(3, 0, 'Juan Herrera');

	$worksheet->write(3, 1, 32);

*/

}

for ($i=0;$i<count($index2verein);$i++) {

	$worksheet_v[$i] =& $workbook->addWorksheet($index2verein[$i]);



	$worksheet_v[$i]->setHeader("Teilnehmerübersicht und Startgeldaufstellung für ".$index2verein[$i]."\nwww.esentri.de/turnieranmeldung");

	$worksheet_v[$i]->setFooter($t["name_lang"].", ".$t["datum"]."\nStand ".date("d.m.Y - H:i")." Uhr");


	$worksheet_v[$i]->hideGridlines();

	//$worksheet_v[$i]->insertBitmap(0,3,"img/logo_bwbv.bmp",40,0,0.8);

//	$worksheet_v[$i]->write(0, 0, "Startgelder "." *",$fett);
	$worksheet_v[$i]->write(0, 0, "Startgelder ".$index2verein[$i]." *",$fett);



	$versatz1=1;

	$worksheet_v[$i]->write(1+$versatz1, 0, "Nachname");

	$worksheet_v[$i]->write(1+$versatz1, 1, "Vorname");

	$worksheet_v[$i]->write(1+$versatz1, 2, "AK");

	$worksheet_v[$i]->write(1+$versatz1, 3, "Geburtstag");

	$worksheet_v[$i]->write(1+$versatz1, 4, "Geschlecht");



	$versatz2=2;

	for ($j=0;$j<count($spieler[$i]);$j++) {

		$worksheet_v[$i]->write($j+$versatz2, 0, $meldungen[$spieler[$i][$j]]["nachname"]);

		$worksheet_v[$i]->write($j+$versatz2, 1, $meldungen[$spieler[$i][$j]]["vorname"]);

		$worksheet_v[$i]->write($j+$versatz2, 2, $meldungen[$spieler[$i][$j]]["ak"]);

		$worksheet_v[$i]->write($j+$versatz2, 3, $meldungen[$spieler[$i][$j]]["geburtstag"]);

		$worksheet_v[$i]->write($j+$versatz2, 4, $meldungen[$spieler[$i][$j]]["geschlecht"]);
		
		$aktuelle_anmerkung=$meldungen[$spieler[$i][$j]]["anmerkung"];	//not used yet
	
	}



	$summe= "Summe = ".count($spieler[$i])." x 5 EURO = ".(count($spieler[$i])*5)." EURO";

	$zeile_summe=count($spieler[$i])+$versatz2+1;

	$worksheet_v[$i]->write($zeile_summe-1, 0,"-------------------------------");

	$worksheet_v[$i]->write($zeile_summe, 0,$summe);

	$worksheet_v[$i]->write($zeile_summe+2, 0,"* Voraussichtlich zu entrichten. Startgelder können je nach Meldestand zum Termin variieren.");

	//$worksheet_v[$i]->write($zeile_summe+4, 0,$aktuelle_anmerkung); 
	$aktuelle_anmerkung="";

}



// Let's send the file

$workbook->close();



?>

