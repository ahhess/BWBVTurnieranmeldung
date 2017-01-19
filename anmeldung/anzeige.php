<?php
	// Anzeige der Spieleranmeldungen für ein bestimmtes Turnier
	session_start();
	include("funktionen.inc.php");
	check_login();


	//turnier holen
	$sql="select * from tas_turnier where id=".$_GET["id"];
	$recordSet = &$conn->Execute($sql);
	$turniere=$recordSet->GetArray();
	$turnier=$turniere[0];

	//meldungen holen
	$sql='select tas_spieler.*, tas_vereine.davor, tas_vereine.name as verein, tas_meldung.partner as partner, tas_meldung.ak as ak 
		from tas_meldung,tas_spieler,tas_vereine
		where tas_meldung.spieler_id=tas_spieler.id 
		and tas_meldung.turnier_id='.$_GET["id"].' 
		and tas_meldung.verein_id=tas_vereine.id
		order by tas_meldung.ak asc, tas_spieler.geschlecht asc, tas_vereine.name, tas_vereine.davor, tas_meldung.partner, tas_spieler.nachname';
	$recordSetSpieler = &$conn->Execute($sql);
	$meldungen=$recordSetSpieler->GetArray();

	//vereine holen
	$sqlV='SELECT tas_vereine.name, tas_vereine.davor, COUNT( * ) AS vmeldcount
		FROM tas_meldung, tas_spieler, tas_vereine
		WHERE tas_meldung.turnier_id='.$_GET["id"].'
		AND tas_meldung.spieler_id = tas_spieler.id
		AND tas_meldung.verein_id = tas_vereine.id
		GROUP BY tas_vereine.name, tas_vereine.davor
		ORDER BY tas_vereine.name, tas_vereine.davor';
	$recordSetVereine = &$conn->Execute($sqlV);
	$vereine=$recordSetVereine->GetArray();


	printHeader();
?>		
    <section id="turniere" class="container content-section text-center ">
        <div class="row">
            <div>
				<h2>Meldungen <?php echo $turnier['name_lang']; ?></h2>
				
				<p>am <?php echo $turnier['name_kurz']; ?> in <?php echo $turnier['ort']; ?></p>
				<p>Hinweis: Nach Ende der Meldefrist kann diese Liste unter Umst&auml;nden nicht mehr aktuell sein. 
				Kontaktieren Sie in diesem Fall ggf. den Turnierbeauftragten.</p>
				<p>( Stand: <?php echo date('d.m.Y')." ".date('G:i'); ?>  Uhr )</p>

				<h4>Bisher online gemeldete Vereine ( <?php echo count($vereine); ?>):</h4>
				<table class="table table-hover table-condensed">
					<tbody><?php 
					for ($i = 0; $i < count($vereine); $i++) { ?>
						<tr>
							<td><?php echo $vereine[$i]['davor']." ".$vereine[$i]['name'];?></td>
							<td><?php echo $vereine[$i]['vmeldcount']; ?></td>
						</tr><?php
					} ?> 
					</tbody> 
				</table>

				<h4>Bisher gemeldete Spieler/innen ( <?php echo count($meldungen); ?>):</h4>
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Nachname</th>
							<th>Vorname</th>
							<th>Verein</th>
							<th>Passnr.</th>
							<th>Jahrgang</th>
							<th>Altersklasse</th>
							<th>Geschlecht</th>
							<th>Partner</th>
						</tr>
					</thead>
					<tbody><?php 
					for ($s = 0; $s < count($meldungen); $s++) { 
						if ($s > 0) {
							$s1 = $s-1;
							if ($meldungen[$s1]['ak'] != $meldungen[$s]['ak']) { ?>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>---</td>
								<td>---</td>
								<td></td>
							</tr><?php 
							} else if ($meldungen[$s1]['geschlecht'] != $meldungen[$s]['geschlecht']) { ?>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>---</td>
								<td></td>
							</tr><?php 
							}
						} ?>
						<tr>
							<td><?php echo $meldungen[$s]['nachname']; ?></td>
							<td><?php echo $meldungen[$s]['vorname']; ?></td>
							<td><?php echo $meldungen[$s]['davor']." ".$meldungen[$s]['verein']; ?></td>
							<td><?php echo $meldungen[$s]['passnummer']; ?></td>
							<td><?php echo $meldungen[$s]['geburtstag|date_format:"%Y"']; ?></td>
							<td><?php echo $meldungen[$s]['ak']; ?></td>
							<td><?php echo $meldungen[$s]['geschlecht']; ?></td>
							<td><?php echo $meldungen[$s]['partner']; ?></td>
						</tr><?php 
					} ?>
				  </tbody>
				</table>
            </div>
        </div>
    </section>
