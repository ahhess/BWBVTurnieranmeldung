<?php
// Allgemeine Anwendungsfunktionen
	
include("config.inc.php");
include("../adodb/adodb.inc.php");

function spielklasse_berechnen($mysql_date) {
	$year=substr($mysql_date,0,4);
//
	if (date("m")>7) $ak_correct=date("Y")-$year+2;
	else $ak_correct=date("Y")-$year+1;
	if (ceil($ak_correct/2) == $ak_correct/2) $ak_correct+=1;
	//DEBUG echo "$mysql_date, U".$ak_correct."<br>";
	if ($ak_correct<9) return "";
	if ($ak_correct>19) return "ERW";
	return "U".$ak_correct;
}

function check_login() {
	if (!session_is_registered("verein") && !session_is_registered("admin")) 
		header("location: index.php");
}

function check_admin_login() {
	if (!session_is_registered("admin")) 
		header("location: admin.php");
}

function get_new_smarty() {
	$smarty = new Smarty;
	$smarty->template_dir = '';
	$smarty->compile_dir = '../smarty/templates_c/';
	$smarty->config_dir = '../smarty/configs/';
	$smarty->cache_dir = '../smarty/cache/';
	return $smarty;
}

/**
* date_mysql2german
* wandelt ein MySQL-DATE (ISO-Date)
* in ein traditionelles deutsches Datum um.
*/
function date_mysql2german($datum) {
	list($jahr, $monat, $tag) = explode("-", $datum);
	return sprintf("%02d.%02d.%04d", $tag, $monat, $jahr);
}

/**
* date_german2mysql
* wandelt ein traditionelles deutsches Datum
* nach MySQL (ISO-Date), in '' eingebettet.
* Wenn Eingabe leer, dann return null;
*/
function date_german2mysql($datum) {
	if($datum==""){
		return "null";
	} else {
		list($tag, $monat, $jahr) = explode(".", $datum);
		return sprintf("'%04d-%02d-%02d'", $jahr, $monat, $tag);
	}	
}

// für smarty
$spielklasse["U9"]="U9";
$spielklasse["U11"]="U11";
$spielklasse["U13"]="U13";
$spielklasse["U15"]="U15";
$spielklasse["U17"]="U17";
$spielklasse["U19"]="U19";
$spielklasse["ERW"]="ERW";

function printHeader() {
	echo '<!DOCTYPE html>
		<html lang="de">
		<head>
			<!--meta charset="utf-8"-->
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="description" content="BWBV Turnier-Anmeldung">
			<meta name="author" content="Andreas Hess">

			<title>BWBV Turnier-Anmeldung</title>
			<link href="css/bootstrap.min.css" rel="stylesheet">
			<link href="css/grayscale.css" rel="stylesheet">
			<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
			<link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
			<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
			<!--[if lt IE 9]>
				<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
				<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
		</head>
		<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
			<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
							<i class="fa fa-bars"></i>
						</button>
						<a class="navbar-brand page-scroll" href="#turniere">
							<i class="fa fa-play-circle"></i> BWBV Turnier-Anmeldung
						</a>
					</div>
					<div class="collapse navbar-collapse navbar-right navbar-main-collapse">
						<ul class="nav navbar-nav">
							<li class="hidden"><a href="#page-top"></a></li>
							<li><a class="page-scroll" href="vereinskontakt.php">Vereinskontakt</a></li>
							<li><a class="page-scroll" href="editieren.php">Spielerdaten</a></li>
							<li><a class="page-scroll" href="help.php">FAQ</a></li>
							<li><a class="page-scroll" href="logoff.php">Abmelden</a></li>
						</ul>
					</div>
				<div class="main-section" />
			</nav>
		';
}

function printFooter() {
	echo '	<footer>
				<div class="container text-center">
					<p>Copyright &copy; 2015 <a href="http://www.bwbv.de">BWBV</a></p>
					<p><a href="mailto:turnieradmin@bwbv.de">Q&A: turnieradmin@bwbv.de</a></p>
				</div>
			</footer>

			<script src="js/jquery.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script src="js/jquery.easing.min.js"></script>
			<script src="js/grayscale.js"></script>
		</body>
		</html>
	';
}

function getTurniere($conn) {
	$region="%";
	if($_GET['region']){
		$region=$_GET['region'];
	} else {
		// Region des Vereins vorbelegen
		if (is_array($_SESSION["verein"])){
			$region=$_SESSION['verein']['region'];
		}
	}
	$sql = "select tas_turnier.*
		, tas_turnierbeauftragter.vorname as ba_vorname, tas_turnierbeauftragter.nachname as ba_nachname
		, (select count(*) from tas_meldung cv where tas_turnier.id=cv.turnier_id and cv.verein_id = 9) as anzahl_anmeldungen 
		, (select count(*) from tas_meldung ca where tas_turnier.id=ca.turnier_id) as anmeldungen_gesamt 
		FROM tas_turnier
		JOIN tas_turnierbeauftragter ON tas_turnier.turnierbeauftragter_id=tas_turnierbeauftragter.id 
		WHERE tas_turnier.region like '$region'
		AND ( datum >= CURDATE() AND datum_anmelden_ab <= CURDATE() )
		ORDER BY datum, tas_turnier.region, tas_turnier.name_lang";

	$rs = &$conn->Execute($sql);
	if ($rs){
		$turniere=$rs->getArray();
	}
	return $turniere;
}


$conn = &ADONewConnection('mysql');
//$conn->debug=true;
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

?>
