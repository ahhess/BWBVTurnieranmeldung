<?php
session_start();
include("config.inc.php");
include("funktionen.inc.php");
include("../adodb/adodb.inc.php");

$conn = &ADONewConnection('mysql');
//$conn->debug=true;
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

// LOGIN Check
//echo "doLoginSubmit=".$_POST["doLoginSubmit"].",benutzer=".$_POST["benutzer"].",passwort=".$_POST["passwort"];
if ($_POST["doLoginSubmit"]){
	if ( $_POST["benutzer"] <> "" and $_POST["passwort"] <> "" ) {
		$sql='select * from tas_vereine where kurz="'.substr($_POST["benutzer"],0,10).'" AND passwort="'.$_POST["passwort"].'"';
		$rs = &$conn->Execute($sql);
		$v=$rs->GetArray();
		if (count($v)){
			$_SESSION["verein"]=$v[0];
			header("location:main.php");   //alles klar, session da. hautpseite aufrufen!
			exit;
		}
	}
}
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
                <a class="navbar-brand page-scroll" href="#page-top">
                    <i class="fa fa-play-circle"></i>  <span class="light"> Start </span> BWBV Turnier-Anmeldung
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#turniere">Turniere</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#login">Anmelden</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading">BWBV Turnier-Anmeldung</h1>
                        <a href="#turniere" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="turniere" class="container content-section text-center">
        <div class="row">
            <div> <!--class="col-lg-10 col-lg-offset-1"-->
<?php
// aktuelle ausschreibungen holen - für login- und übersichtsseite
$sql="select tas_turnier.*,tas_turnierbeauftragter.vorname as ba_vorname, tas_turnierbeauftragter.nachname as ba_nachname, tas_turnierbeauftragter.strasse as ba_strasse, tas_turnierbeauftragter.plz as ba_plz, tas_turnierbeauftragter.ort as ba_ort, tas_turnierbeauftragter.telefon_priv as ba_telefon_priv, tas_turnierbeauftragter.telefon_gesch as ba_telefon_gesch, tas_turnierbeauftragter.fax as ba_fax, tas_turnierbeauftragter.email as ba_email, tas_turnierbeauftragter.mobil as ba_mobil 
	FROM tas_turnier
	JOIN tas_turnierbeauftragter ON tas_turnier.turnierbeauftragter_id=tas_turnierbeauftragter.id 
	WHERE ( datum >= CURDATE() AND datum_anmelden_ab <= CURDATE() )
	ORDER BY datum, tas_turnier.region, name_lang ";
$rs = &$conn->Execute($sql);
if ($rs){
	$turniere=$rs->getArray();
?>
                <h2>&Uuml;bersicht aktuelle Turniere</h2>
				<table class="table">
					<thead>
						<tr>
						  <th>Datum</td>
						  <th>Region</td>
						  <th>Turnier</td>
						  <th>Ort</td>
						  <th>Meldezeitraum</td>
						</tr>
					</thead>
					<tbody>
<?php
	for ($i=0;$i<count($turniere);$i++)	{
?>
						<tr>
						  <td><?php echo $turniere[$i]['name_kurz']; ?></td>
						  <td><?php echo $turniere[$i]['region']; ?></td>
						  <td><?php echo $turniere[$i]['name_lang']; ?></td>
						  <td><?php echo $turniere[$i]['ort']; ?></td>
						  <td><?php if ($turniere[t]['datum_anmelden_ab'] != "0000-00-00") echo date_mysql2german($turniere[$i]['datum_anmelden_ab']); ?>
							bis <?php echo date_mysql2german($turniere[$i]['datum_anmelden_bis']); ?>
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
			<a href="#login" class="btn btn-circle page-scroll">
				<i class="fa fa-angle-double-down animated"></i>
			</a>
    </section>

    <section id="login" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
				<h2 class="form-signin-heading">Anmelden</h2>
				<form class="form-signin" method="post">
					<label for="benutzer" class="sr-only">Benutzer</label>
					<input type="text" name="benutzer" class="form-control" placeholder="Benutzer" required autofocus>
					<label for="passwort" class="sr-only">Password</label>
					<input type="password" name="passwort" class="form-control" placeholder="Passwort" required>
					<input type="hidden" name="doLoginSubmit" value="doLoginSubmit">
					<button class="btn btn-lg btn-primary btn-block" type="submit">OK</button>
				</form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; 2015 <a href="http://www.bwbv.de">www.bwbv.de</a></p>
			<p><a href="mailto:turnieradmin@bwbv.de">Q&A: turnieradmin@bwbv.de</a></p>
        </div>
    </footer>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/grayscale.js"></script>
</body>

</html>
