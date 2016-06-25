<?php
	session_start();
	include("funktionen.inc.php");
	check_login();
	printHeader();
?>	
<section id="faq" class="container content-section text-center ">

	<div class="row">
        <div align="left" class="col-lg-10 col-lg-offset-1">

			<h2>FAQ zum Turnieranmeldesystem</h2>

			<dl>
				<dt>Ich habe meine Zugangsdaten gerade erhalten und mich zum ersten Mal eingeloggt. Was ist nun zu tun?</dt>
				<dd>Folgende zwei Schritte sind unbedingt durchzuf&uuml;hren:
					<ul>
						<li>Auf der Seite Vereinskontakt die Daten komplettieren/aktualisieren. 
						Insbesonders die <em>Email-Adresse</em> muss stets aktuell gehalten werden! &Uuml;ber sie werden 
						die Meldebest&auml;tigungen abgewickelt.
						<li>Auf der Seite Spielerdaten die Spieler des Vereins einpflegen.
					</ul>
					Danach k&ouml;nnen Meldungen durchgef&uuml;hrt werden.
					<br/>
					<br/>
				</dd>
				
				<dt>Ich erhalte keine Best&auml;tigungsmails. Woran kann das liegen??</dt>
				<dd>Dies kann hpts. zwei Gr&uuml;nde haben:
					<ul>
						<li>Die bei Ansprechpartner angegebene <em>Email ist nicht korrekt</em> (&uuml;berpr&uuml;fen!!)
						<li>Dein Email-Account besitzt einen <em>aktiviertem SPAM-Filter</em>? 
						In diesem Fall ist im Ordner "SPAM", "Junk-Mail"  o.&auml;. nachzusehen. 
						Sofern die Mail sich dort befindet, ist die Email als Nicht-SPAM zu kennzeichnen. 
						Alle folgenden Emails sollten Dich dann ohne Probleme erreichen! 
						Ansonsten bitte die Hilfe des Email Providers zu Rate ziehen.
						<br/>
						<br/>
					</ul>
				<dd>

				<dt>Ich m&ouml;chte <em>an mehrere Email-Adressen</em> Best&auml;tigungen erhalten.</dt>
				<dd>Auf der Seite <em>Vereinskontakt</em> k&ouml;nnen im E-Mail-Feld k&ouml;nnen mehrere Email-Adressen jeweils durch Strichpunkt/Semikolon (;) getrennt angegeben werden, z.B. <i>adresse1@email.de;adresse2@email.com;adresse3@email.biz</i>.
				<br/>
				<br/>
				</dd>
		
				<dt>Bei sonstigen Fragen und Problemen: an wen soll ich mich wenden?</dt>
				<dd>
					<ul>
						<li><em>Technische Fragen</em> werden von <a href="mailto:turnieradmin@bwbv.de">Andreas Hess, Sportwart NW</a> beantwortet.<li><em>Turnierbezogene Fragen</em> werden von dem jeweiligen ausrichtenden Verein bzw. dem Turnierverantwortlichen (Ranglistenbeauftragten etc.) beantwortet.
					</ul>
				<dd>
			</dl>
		</div>
	</div>
</section>
<?php
	printFooter();
?>
