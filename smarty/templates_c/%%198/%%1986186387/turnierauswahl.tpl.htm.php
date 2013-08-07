<?php /* Smarty version 2.5.0, created on 2012-01-13 22:50:47
         compiled from turnierauswahl.tpl.htm */ ?>
<?php $this->_load_plugins(array(
array('function', 'popup_init', 'turnierauswahl.tpl.htm', 10, false),
array('function', 'popup', 'turnierauswahl.tpl.htm', 60, false),)); ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Turnieranmeldesystem Badminton NB</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">



<?php echo $this->_plugins['function']['popup_init'][0](array('src' => "js/overlib.js"), $this) ; ?>
 </head> <body marginheight="20px" marginwidth="20px">
<table width="650" border="0" cellpadding="0" cellspacing="10" style="border-style:dashed;border-width:2px;border-color:#ffcc00">
  <tr>
    <td align="center"><span class="gross"> Badminton Turnieranmeldung &Uuml;bersicht</span><br>
      <span class="klein">Derzeit ausgeschriebene Turniere</span></td>
  </tr>
</table>
<p>
<div class="klein"><font color=green>Zum ersten mal hier? Andere Probleme mit der Plattform? Die <a href="faq.html">ersten Schritte im System und weitere Fragen</a> werden in den <a href="faq.html">FAQ</a> erläutert.<p></font color></div>
<p>
<table width="400" border="0" cellpadding="2" cellspacing="0" bgcolor="#ECFFEC">
  <tr>
    <td><span class="mittel">Aktuell f&uuml;r eine <strong>Meldung</strong> zur Verf&uuml;gung
    stehende Turniere: </span></td>
  </tr>
</table>
<p class="mittel"><?php if (isset($this->_sections['t'])) unset($this->_sections['t']);
$this->_sections['t']['name'] = 't';
$this->_sections['t']['loop'] = is_array($this->_tpl_vars['turniere']) ? count($this->_tpl_vars['turniere']) : max(0, (int)$this->_tpl_vars['turniere']);
$this->_sections['t']['show'] = true;
$this->_sections['t']['max'] = $this->_sections['t']['loop'];
$this->_sections['t']['step'] = 1;
$this->_sections['t']['start'] = $this->_sections['t']['step'] > 0 ? 0 : $this->_sections['t']['loop']-1;
if ($this->_sections['t']['show']) {
    $this->_sections['t']['total'] = $this->_sections['t']['loop'];
    if ($this->_sections['t']['total'] == 0)
        $this->_sections['t']['show'] = false;
} else
    $this->_sections['t']['total'] = 0;
if ($this->_sections['t']['show']):

            for ($this->_sections['t']['index'] = $this->_sections['t']['start'], $this->_sections['t']['iteration'] = 1;
                 $this->_sections['t']['iteration'] <= $this->_sections['t']['total'];
                 $this->_sections['t']['index'] += $this->_sections['t']['step'], $this->_sections['t']['iteration']++):
$this->_sections['t']['rownum'] = $this->_sections['t']['iteration'];
$this->_sections['t']['index_prev'] = $this->_sections['t']['index'] - $this->_sections['t']['step'];
$this->_sections['t']['index_next'] = $this->_sections['t']['index'] + $this->_sections['t']['step'];
$this->_sections['t']['first']      = ($this->_sections['t']['iteration'] == 1);
$this->_sections['t']['last']       = ($this->_sections['t']['iteration'] == $this->_sections['t']['total']);
?> </p>
<form action="meldung.php" method="post" name="f" id="f">
  <table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100" class="mittel">Turnier:</td>
      <td width="400" class="mittel"><strong><?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['name_lang']; ?>
 </strong></td>
      <td width="10"> </td>
      <td width="140" rowspan="3" valign="top"> <input name="doSubmitMeldebildschirm" type="submit" class="mittel" id="doSubmitMeldebildschirm" value="<?php echo $this->_tpl_vars['button_meldebildschirm']; ?>
" style="height:50px"></td>
    </tr>
    <tr>
      <td width="100" class="klein">Beauftragter:</td>
      <td width="400" class="klein"><?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['ba_vorname']; ?>
 <?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['ba_nachname']; ?>
</td>
      <td width="10">&nbsp;</td>
    </tr>
    <tr>
      <td width="100" class="klein">Datum:</td>
      <td width="400" class="klein"><strong><?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['datum']; ?>
 </strong></td>
      <td width="10"> </td>
    </tr>
    <tr>
      <td width="100" class="klein">Ort:</td>
      <td width="400" class="klein"><?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['ort']; ?>
 </td>
      <td width="10"> </td>
    </tr>
    <tr>
      <td width="100" class="klein">Meldezeitraum:&nbsp;&nbsp;</td>
      <td width="400" class="klein"><?php if ($this->_tpl_vars['turniere'][$this->_sections['t']['index']]['datum_anmelden_ab'] != 0000 -00 -00): ?>von <?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['datum_anmelden_ab']; ?>
<?php endif; ?>
        bis <?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['datum_anmelden_bis']; ?>
</td>
      <td width="10"> </td>
      <td width="140"><span class="klein">Bisherige
      Meldungen aller Vereine einsehen (<a href="anzeige.php?id=<?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['id']; ?>
" target="_blank">HTML</a>, <a href="excel.php?id=<?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['id']; ?>
">EXCEL</a>)</span></td>
    </tr>
    <tr>
      <td width="100" class="klein">&nbsp;</td>
      <td width="400" class="klein"><?php if ($this->_tpl_vars['turniere'][$this->_sections['t']['index']]['infobox']): ?>Sie haben derzeit <a href="#" <?php echo $this->_plugins['function']['popup'][0](array('text' => $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['infobox']), $this) ; ?>
><?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['anzahl_anmeldungen']; ?>

        Spieler</a> gemeldet<?php endif; ?></td>
      <td width="10">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="tid" value="<?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['id']; ?>
">
</form>
<p><?php endfor; else: ?><span class="klein">- Es stehen derzeit keine Turniere zur Meldung
    zur Verf&uuml;gung -</span><?php endif; ?> </p>
<p>&nbsp;</p>
<table width="400" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFF7F2">
  <tr>
    <td><span class="mittel">Anstehende Turniere, bei welchen die <strong>Online-Meldefrist
    abgelaufen </strong>ist:</span></td>
  </tr>
</table>
<p class="mittel"><font color="777777">Eine <em>Abmeldung</em> ist bei diesen
    Turnieren nur &uuml;ber den <em>Turnierverantwortlichen</em> m&ouml;glich
    !</font color> <br>
</p>
<p class="mittel"><?php if (isset($this->_sections['t'])) unset($this->_sections['t']);
$this->_sections['t']['name'] = 't';
$this->_sections['t']['loop'] = is_array($this->_tpl_vars['turniere_abgelaufen']) ? count($this->_tpl_vars['turniere_abgelaufen']) : max(0, (int)$this->_tpl_vars['turniere_abgelaufen']);
$this->_sections['t']['show'] = true;
$this->_sections['t']['max'] = $this->_sections['t']['loop'];
$this->_sections['t']['step'] = 1;
$this->_sections['t']['start'] = $this->_sections['t']['step'] > 0 ? 0 : $this->_sections['t']['loop']-1;
if ($this->_sections['t']['show']) {
    $this->_sections['t']['total'] = $this->_sections['t']['loop'];
    if ($this->_sections['t']['total'] == 0)
        $this->_sections['t']['show'] = false;
} else
    $this->_sections['t']['total'] = 0;
if ($this->_sections['t']['show']):

            for ($this->_sections['t']['index'] = $this->_sections['t']['start'], $this->_sections['t']['iteration'] = 1;
                 $this->_sections['t']['iteration'] <= $this->_sections['t']['total'];
                 $this->_sections['t']['index'] += $this->_sections['t']['step'], $this->_sections['t']['iteration']++):
$this->_sections['t']['rownum'] = $this->_sections['t']['iteration'];
$this->_sections['t']['index_prev'] = $this->_sections['t']['index'] - $this->_sections['t']['step'];
$this->_sections['t']['index_next'] = $this->_sections['t']['index'] + $this->_sections['t']['step'];
$this->_sections['t']['first']      = ($this->_sections['t']['iteration'] == 1);
$this->_sections['t']['last']       = ($this->_sections['t']['iteration'] == $this->_sections['t']['total']);
?> </p>
<form action="meldung.php" method="post" name="f" id="f">
  <table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100" class="mittel">Turnier:</td>
      <td width="400" class="mittel"><strong><font color=#777777><?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['name_lang']; ?>
 </strong></td>
      <td width="10">&nbsp;</td>
      <td width="140" rowspan="3" valign="top"><span class="klein">Meldungen aller Vereine einsehen (<a href="anzeige.php?id=<?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['id']; ?>
" target="_blank">HTML</a>, <a href="excel.php?id=<?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['id']; ?>
">EXCEL</a>) </span> </td>
    </tr>
    <tr>
      <td width="100" class="klein">Beauftragter:</td>
      <td width="400" class="klein"><a href="mailto:<?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['ba_email']; ?>
"><?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['ba_vorname']; ?>
 <?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['ba_nachname']; ?>
</a></td>
      <td width="10">&nbsp;</td>
    </tr>
    <tr>
      <td width="100" class="klein">Datum:</td>
      <td width="400" class="klein"><strong><font color=#777777><?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['datum']; ?>
 </strong></td>
      <td width="10">&nbsp;</td>
    </tr>
    <tr>
      <td width="100" class="klein">Ort:</td>
      <td width="400" class="klein"><?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['ort']; ?>
 </td>
      <td width="10">&nbsp;</td>
    </tr>
    <tr>
      <td width="100" class="klein">Meldezeitraum:&nbsp;&nbsp;</td>
      <td width="400" class="klein"><?php if ($this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['datum_anmelden_ab'] != 0000 -00 -00): ?>von
        <?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['datum_anmelden_ab']; ?>
<?php endif; ?> <strong>bis <?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['datum_anmelden_bis']; ?>
</strong></td>
      <td width="10">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
    <tr>
      <td width="100" class="klein">&nbsp;</td>
      <td width="400" class="klein"><?php if ($this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['infobox']): ?>Ihr letzter
        Meldestand: <a href="#" <?php echo $this->_plugins['function']['popup'][0](array('text' => $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['infobox']), $this) ; ?>
><?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['anzahl_anmeldungen']; ?>

          Spieler</a> gemeldet<?php endif; ?></td>
      <td width="10">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="tid2" value="<?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['id']; ?>
">
</form>
<p><?php endfor; else: ?><span class="klein">- Es stehen derzeit keine zuk&uuml;nftige Turniere
mit abgelaufener Meldefrist zur Verf&uuml;gung -</span><?php endif; ?> </p>
<p>&nbsp; </p>
<form name="form1" method="post" action="">
  <span class="mittel"><strong>WICHTIG! </strong>Ansprechpartner f&uuml;r R&uuml;ckfragen:  <br>
  <br>
  </span>
  <table border="0" class="mittel">
    <tr>
      <td valign="top">Name:</td>
      <td>        <input name="ansprechpartner_name" type="text" id="email27" value="<?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_name']; ?>
" size="30">      </td>
    </tr>
    <tr>
      <td valign="top">Strasse:</td>
      <td>        <input name="ansprechpartner_strasse" type="text" id="email222" value="<?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_strasse']; ?>
" size="30">      </td>
    </tr>
    <tr>
      <td valign="top">Plz/Ort:</td>
      <td>        <input name="ansprechpartner_plz_ort" type="text" id="email233" value="<?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_plz_ort']; ?>
" size="30">      </td>
    </tr>
    <tr>
      <td valign="top">Telefon:</td>
      <td>        <input name="ansprechpartner_telefon" type="text" id="email232" value="<?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_telefon']; ?>
" size="30">      </td>
    </tr>
    <tr>
      <td valign="top">Mobil:</td>
      <td>        <input name="ansprechpartner_mobil" type="text" id="email242" value="<?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_mobil']; ?>
" size="30">      </td>
    </tr>
    <tr>
      <td valign="top">Email:<br>
        (<font color="#FF0000">Wichtig!!</font>)</td>
      <td>        <input name="ansprechpartner_email" type="text" id="email5" value="<?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_email']; ?>
" size="30"><br><font color="#bbbbbb">Mehrere Email-Adressen sind durch Strichpunkt (;) trennen.</font color></td>
    </tr>
    <tr>
      <td valign="top">Bemerkung:</td>
      <td><textarea name="ansprechpartner_bemerkung" cols="30" rows="3" id="ansprechpartner_bemerkung"><?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_bemerkung']; ?>
</textarea></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td>        <input name="doSubmitEmail" type="submit" id="doSubmitEmail2" value="Ansprechpartnerdaten aktualisieren">      </td>
    </tr>
  </table>
  <span class="mittel"><br>
  <br>
  <br>
  <br>
  </span>
</form>
<p><a href="logoff.php" class="mittel"><strong>Ausloggen</strong></a> | <a href="editieren.php" class="mittel">Spielerdaten
des <?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['davor']; ?>
 <?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['name']; ?>
 <strong>editieren</strong></a> </p>
</body>
</html>