<?php
session_start();
include("config.inc.php");
include("funktionen.inc.php");

check_login();

include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');
//$conn->debug=true;
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <!--meta charset="utf-8"-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BWBV Turnier-Anmeldung">
    <meta name="author" content="Andreas Hess">

    <title>BWBV Turnier-Anmeldung</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/grayscale.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
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

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li class="hidden"><a href="#page-top"></a></li>
                    <li><a class="page-scroll" href="vereinskontakt.php">Vereinskontakt</a></li>
                    <li><a class="page-scroll" href="editieren.php">Spielerdaten</a></li>
                    <li><a class="page-scroll" href="help.php">FAQ</a></li>
                    <li><a class="page-scroll" href="logoff.php">Abmelden</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <section id="turniere" class="container content-section text-center">
        <div class="row">
            <div> <!--class="col-lg-10 col-lg-offset-1"-->
                <h2>&Uuml;bersicht aktuelle Turniere</h2>
				<table class="table">
					<thead>
						<tr>
						  <th>Datum</td>
						  <th>Region</td>
						  <th>Turnier</td>
						  <th>Ort</td>
						  <th>Meldezeitraum</td>
						  <th>Meldungen Verein / Gesamt</th>
						  <th>Verantw.</th>
						  <th> </th>
						</tr>
					</thead>
					<tbody>
<?php
// aktuelle ausschreibungen holen - für login- und übersichtsseite
$region="%";
if($_GET['region']){
	$region=$_GET['region'];
} else {
	// Region des Vereins vorbelegen
	if (is_array($_SESSION["verein"])){
		$region=$_SESSION['verein']['region'];
	}
}
$sql="select tas_turnier.*
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
	for ($i=0;$i<count($turniere);$i++)	{
?>
						<tr>
						  <td><?php echo $turniere[$i]['name_kurz']; ?></td>
						  <td><?php echo $turniere[$i]['region']; ?></td>
						  <td><?php echo $turniere[$i]['name_lang']; ?></td>
						  <td><?php echo $turniere[$i]['ort']; ?></td>
						  <td><?php if ($turniere[t]['datum_anmelden_ab'] != "0000-00-00") echo $turniere[$i]['datum_anmelden_ab']; ?>
							bis <?php echo $turniere[$i]['datum_anmelden_bis']; ?>
						  </td>
						  <td><?php echo $turniere[$i]['anzahl_anmeldungen']." / ".$turniere[$i]['anmeldungen_gesamt']; ?></td>
						  <td><?php echo $turniere[$i]['ba_vorname']." ".$turniere[$i]['ba_nachname']; ?></td>
						  <td>
							<div class="btn-toolbar">
								<div class="btn-group">
									<a class="btn" href="anzeige.php?id=<?php echo $turniere[$i]['id']; ?>">Meldeliste</a>
									<form name="meldungform" method="post" action="meldung.php">
										<input type="hidden" name="tid" value="<?php echo $turniere[$i]['id']; ?>">
										<input type="submit" class="btn" value="Anmeldung">
										<!--a class="btn" href="#" onclick="document.meldungform.tid.value='<?php echo $turniere[$i]['id']; ?>';document.meldungform.submit()">Anmeldung</a-->
									</form>
								</div>
							</div>
						  </td>
						</tr>
<?php
	}
?>
					</tbody>
				</table>
<?php
}		
?>
			</div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; 2015 <a href="http://www.bwbv.de">BWBV</a></p>
			<p><a href="mailto:turnieradmin@bwbv.de">Q&A: turnieradmin@bwbv.de</a></p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/grayscale.js"></script>

</body>

</html>
