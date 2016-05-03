<?php
	session_start();
	include("funktionen.inc.php");
	check_login();
	printHeader();
?>
		
    <section id="turniere" class="container content-section text-center ">
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
	$turniere = getTurniere($conn);
	if ($turniere){
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
									<a class="btn" href="#" onclick="document.meldungform.tid.value='<?php echo $turniere[$i]['id']; ?>';document.meldungform.submit();">Anmeldung</a>
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

		<form name="meldungform" method="post" action="meldung.php">
			<input type="hidden" name="tid" value="<?php echo $turniere[$i]['id']; ?>">
			<!--input type="submit" class="btn" value="Anmeldung"-->
		</form>
	</section>
<?php
	printFooter();
?>
