<?php /* Smarty version 2.5.0, created on 2012-01-13 23:13:31
         compiled from auswahl.tpl.htm */ ?>
<?php $this->_load_plugins(array(
array('function', 'cycle', 'auswahl.tpl.htm', 119, false),)); ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Turnieranmeldesystem Badminton NB - Meldung</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="780" border="0" align="center" cellpadding=10px style="border-color:#666666;border-width:1px;border-style:solid">
  <tr>
<td>

<?php if (isset($this->_sections["\"fehlerbox\";"])) unset($this->_sections["\"fehlerbox\";"]);
$this->_sections["\"fehlerbox\";"]['name'] = "\"fehlerbox\";";
$this->_sections["\"fehlerbox\";"]['show'] = (bool)$this->_tpl_vars['fehlermeldung'];
$this->_sections["\"fehlerbox\";"]['loop'] = 1;
$this->_sections["\"fehlerbox\";"]['max'] = $this->_sections["\"fehlerbox\";"]['loop'];
$this->_sections["\"fehlerbox\";"]['step'] = 1;
$this->_sections["\"fehlerbox\";"]['start'] = $this->_sections["\"fehlerbox\";"]['step'] > 0 ? 0 : $this->_sections["\"fehlerbox\";"]['loop']-1;
if ($this->_sections["\"fehlerbox\";"]['show']) {
    $this->_sections["\"fehlerbox\";"]['total'] = $this->_sections["\"fehlerbox\";"]['loop'];
    if ($this->_sections["\"fehlerbox\";"]['total'] == 0)
        $this->_sections["\"fehlerbox\";"]['show'] = false;
} else
    $this->_sections["\"fehlerbox\";"]['total'] = 0;
if ($this->_sections["\"fehlerbox\";"]['show']):

            for ($this->_sections["\"fehlerbox\";"]['index'] = $this->_sections["\"fehlerbox\";"]['start'], $this->_sections["\"fehlerbox\";"]['iteration'] = 1;
                 $this->_sections["\"fehlerbox\";"]['iteration'] <= $this->_sections["\"fehlerbox\";"]['total'];
                 $this->_sections["\"fehlerbox\";"]['index'] += $this->_sections["\"fehlerbox\";"]['step'], $this->_sections["\"fehlerbox\";"]['iteration']++):
$this->_sections["\"fehlerbox\";"]['rownum'] = $this->_sections["\"fehlerbox\";"]['iteration'];
$this->_sections["\"fehlerbox\";"]['index_prev'] = $this->_sections["\"fehlerbox\";"]['index'] - $this->_sections["\"fehlerbox\";"]['step'];
$this->_sections["\"fehlerbox\";"]['index_next'] = $this->_sections["\"fehlerbox\";"]['index'] + $this->_sections["\"fehlerbox\";"]['step'];
$this->_sections["\"fehlerbox\";"]['first']      = ($this->_sections["\"fehlerbox\";"]['iteration'] == 1);
$this->_sections["\"fehlerbox\";"]['last']       = ($this->_sections["\"fehlerbox\";"]['iteration'] == $this->_sections["\"fehlerbox\";"]['total']);
?></p>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#FF0000"><?php echo $this->_tpl_vars['fehlermeldung']; ?>
</td>
  </tr>
</table>
<p><?php endfor; endif; ?><?php if (isset($this->_sections['systembox'])) unset($this->_sections['systembox']);
$this->_sections['systembox']['name'] = 'systembox';
$this->_sections['systembox']['show'] = (bool)$this->_tpl_vars['systemmeldung'];
$this->_sections['systembox']['loop'] = 1;
$this->_sections['systembox']['max'] = $this->_sections['systembox']['loop'];
$this->_sections['systembox']['step'] = 1;
$this->_sections['systembox']['start'] = $this->_sections['systembox']['step'] > 0 ? 0 : $this->_sections['systembox']['loop']-1;
if ($this->_sections['systembox']['show']) {
    $this->_sections['systembox']['total'] = $this->_sections['systembox']['loop'];
    if ($this->_sections['systembox']['total'] == 0)
        $this->_sections['systembox']['show'] = false;
} else
    $this->_sections['systembox']['total'] = 0;
if ($this->_sections['systembox']['show']):

            for ($this->_sections['systembox']['index'] = $this->_sections['systembox']['start'], $this->_sections['systembox']['iteration'] = 1;
                 $this->_sections['systembox']['iteration'] <= $this->_sections['systembox']['total'];
                 $this->_sections['systembox']['index'] += $this->_sections['systembox']['step'], $this->_sections['systembox']['iteration']++):
$this->_sections['systembox']['rownum'] = $this->_sections['systembox']['iteration'];
$this->_sections['systembox']['index_prev'] = $this->_sections['systembox']['index'] - $this->_sections['systembox']['step'];
$this->_sections['systembox']['index_next'] = $this->_sections['systembox']['index'] + $this->_sections['systembox']['step'];
$this->_sections['systembox']['first']      = ($this->_sections['systembox']['iteration'] == 1);
$this->_sections['systembox']['last']       = ($this->_sections['systembox']['iteration'] == $this->_sections['systembox']['total']);
?></p>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#00FF00"><?php echo $this->_tpl_vars['systemmeldung']; ?>
</td>
  </tr>
</table>
<p><?php endfor; endif; ?></p>
<form action="" method="post" name="hinzu" id="hinzu">
<table width="750" border="0">
  <tr>
    <td width="300"><img src="img/logo_bwbv.gif" width="245" height="83"></td>
    <td rowspan="3" valign="top"><ul>
      <li><strong class="mittel">Verein</strong><br>
        <span class="mittel"><?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['davor']; ?>
 <?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['name']; ?>
</span> <br>
        <br>
</li>
      <li><strong class="mittel">Turnier</strong><br>
        <span class="mittel"><?php echo $this->_tpl_vars['turnier']['name_lang']; ?>
 </span><br>
        <br>
</li>
      <li class="mittel"><strong>Absender/Ansprechpartner f&uuml;r R&uuml;ckfragen <br>
        <br>
        </strong>
        <table width="300" border="0" cellpadding="1" cellspacing="0" class="mittel">
          <tr>
            <td>Name:</td>
            <td><strong><?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_name']; ?>
 </strong></td>
          </tr>
          <tr>
            <td>Strasse:</td>
            <td><?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_strasse']; ?>
</td>
          </tr>
          <tr>
            <td>Plz/Ort:</td>
            <td><?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_plz_ort']; ?>
 </td>
          </tr>
          <tr>
            <td>Telefon:</td>
            <td><?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_telefon']; ?>
</td>
          </tr>
          <tr>
            <td>Mobil:</td>
            <td><?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_mobil']; ?>
</td>
          </tr>
          <tr>
            <td>E-Mail:</td>
            <td><?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_email']; ?>
</td>
          </tr>
          <?php if ($GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_bemerkung'] != ""): ?><tr>
            <td>Bemerkung:</td>
            <td><?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['ansprechpartner_bemerkung']; ?>
</td>
          </tr>
		  <?php endif; ?>
        </table>
        <br>
      </li>
      <li class="mittel"><strong>Anmerkungen zur Meldung / ggf. Doppelpaarungen</strong><br>
        <br>
        <textarea name="anmerkung" cols="40" rows="4" id="anmerkung"><?php echo $this->_tpl_vars['anmerkung']; ?>
</textarea>
          </li>
    </ul></td>
  </tr>
  <tr>
    <td width="300">An:<br>
      <table width="300" height="150" border="0" cellpadding="0" cellspacing="2" bordercolor="#666666" style="border-style:dashed;border-width:2px;border-color:#ffcc00">
        <tr>
          <td align="left" valign="top"><p class="mittel"><strong><?php echo $this->_tpl_vars['turnier']['ba_vorname']; ?>

            <?php echo $this->_tpl_vars['turnier']['ba_nachname']; ?>
 </strong><br>
            <?php echo $this->_tpl_vars['turnier']['ba_strasse']; ?>
 <br>
            <?php echo $this->_tpl_vars['turnier']['ba_plz']; ?>
 <?php echo $this->_tpl_vars['turnier']['ba_ort']; ?>
</p>
            <p class="mittel"> Tel (p): <?php echo $this->_tpl_vars['turnier']['ba_telefon_priv']; ?>
<br>
              Fax: <?php echo $this->_tpl_vars['turnier']['ba_fax']; ?>
<br>
          Email: <a href="mailto:%7B$turnier.ba_email%7D"><?php echo $this->_tpl_vars['turnier']['ba_email']; ?>
</a> </p></td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td width="300"><p class="klein">Hiermit werden nachfolgende Spieler(innen) zum o.g. Turnier verbindlich
        angemeldet. Verpflichtungen, die aus dieser Meldung resultieren, regelt
    die SpO. </p></td>
  </tr>
</table>
<p class="mittel"><a href="logoff.php"><strong>Ausloggen</strong></a> | <a href="index.php">
  Zur&uuml;ck zur <strong>&Uuml;bersicht</strong></a></p>
<p><a href="index.php"><br>
  </a> </p>
  <table width="750" border="0" cellpadding="4" cellspacing="1" bgcolor="#0033FF">
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td class="mittel">Nachname</td>
      <td class="mittel">Vorname</td>
      <td class="mittel">Geburtsdatum (J-M-T)</td>
      <td class="mittel">Passnummer</td>
      <td class="mittel">Spielklasse</td>
    </tr>
    <?php if (isset($this->_sections['zeile'])) unset($this->_sections['zeile']);
$this->_sections['zeile']['name'] = 'zeile';
$this->_sections['zeile']['loop'] = is_array($this->_tpl_vars['spieler']) ? count($this->_tpl_vars['spieler']) : max(0, (int)$this->_tpl_vars['spieler']);
$this->_sections['zeile']['show'] = true;
$this->_sections['zeile']['max'] = $this->_sections['zeile']['loop'];
$this->_sections['zeile']['step'] = 1;
$this->_sections['zeile']['start'] = $this->_sections['zeile']['step'] > 0 ? 0 : $this->_sections['zeile']['loop']-1;
if ($this->_sections['zeile']['show']) {
    $this->_sections['zeile']['total'] = $this->_sections['zeile']['loop'];
    if ($this->_sections['zeile']['total'] == 0)
        $this->_sections['zeile']['show'] = false;
} else
    $this->_sections['zeile']['total'] = 0;
if ($this->_sections['zeile']['show']):

            for ($this->_sections['zeile']['index'] = $this->_sections['zeile']['start'], $this->_sections['zeile']['iteration'] = 1;
                 $this->_sections['zeile']['iteration'] <= $this->_sections['zeile']['total'];
                 $this->_sections['zeile']['index'] += $this->_sections['zeile']['step'], $this->_sections['zeile']['iteration']++):
$this->_sections['zeile']['rownum'] = $this->_sections['zeile']['iteration'];
$this->_sections['zeile']['index_prev'] = $this->_sections['zeile']['index'] - $this->_sections['zeile']['step'];
$this->_sections['zeile']['index_next'] = $this->_sections['zeile']['index'] + $this->_sections['zeile']['step'];
$this->_sections['zeile']['first']      = ($this->_sections['zeile']['iteration'] == 1);
$this->_sections['zeile']['last']       = ($this->_sections['zeile']['iteration'] == $this->_sections['zeile']['total']);
?>
    <tr bgcolor="<?php echo $this->_plugins['function']['cycle'][0](array('values' => "#eeeeee,#d0d0d0"), $this) ; ?>
">
      <td> <input name="meldung[]" type="checkbox" class="mittel" id="meldung[]" value="<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['turnier_id'] == $GLOBALS['HTTP_SESSION_VARS']['tid']): ?>CHECKED<?php endif; ?>></td>
      <td class="mittel"><?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['nachname']; ?>
</td>
      <td class="mittel"><?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['vorname']; ?>
</td>
      <td class="mittel"><?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geburtstag']; ?>
</td>
      <td class="mittel"><?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['passnummer'] != ""): ?><?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['passnummer']; ?>
<?php else: ?><a href="editieren.php">nachtragen</a><?php endif; ?></td>
      <td><select name=spk[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
] class="mittel" id="spk[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]">
        <option value="U9" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U9'): ?>style="background-color:#99FF66"<?php else: ?>style="background-color:#FFCC66"<?php endif; ?> <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == 'U9'): ?>SELECTED<?php elseif ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U9'): ?>SELECTED<?php endif; ?>> U&nbsp;9 <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geschlecht'] == 'm'): ?>JE<?php else: ?>ME<?php endif; ?></option>
        <option value="U11" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U11'): ?>style="background-color:#99FF66"<?php else: ?>style="background-color:#FFCC66"<?php endif; ?> <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == 'U11'): ?>SELECTED<?php elseif ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == "" && $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U11'): ?>SELECTED<?php endif; ?>> U11 <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geschlecht'] == 'm'): ?>JE<?php else: ?>ME<?php endif; ?></option>
        <option value="U13" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U13'): ?>style="background-color:#99FF66"<?php else: ?>style="background-color:#FFCC66"<?php endif; ?> <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == 'U13'): ?>SELECTED<?php elseif ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == "" && $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U13'): ?>SELECTED<?php endif; ?>> U13 <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geschlecht'] == 'm'): ?>JE<?php else: ?>ME<?php endif; ?></option>
        <option value="U15" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U15'): ?>style="background-color:#99FF66"<?php else: ?>style="background-color:#FFCC66"<?php endif; ?> <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == 'U15'): ?>SELECTED<?php elseif ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == "" && $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U15'): ?>SELECTED<?php endif; ?>> U15 <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geschlecht'] == 'm'): ?>JE<?php else: ?>ME<?php endif; ?></option>
        <option value="U17" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U17'): ?>style="background-color:#99FF66"<?php else: ?>style="background-color:#FFCC66"<?php endif; ?> <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == 'U17'): ?>SELECTED<?php elseif ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == "" && $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U17'): ?>SELECTED<?php endif; ?>> U17 <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geschlecht'] == 'm'): ?>JE<?php else: ?>ME<?php endif; ?></option>
        <option value="U19" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U19'): ?>style="background-color:#99FF66"<?php else: ?>style="background-color:#FFCC66"<?php endif; ?> <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == 'U19'): ?>SELECTED<?php elseif ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == "" && $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'U19'): ?>SELECTED<?php endif; ?>> U19 <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geschlecht'] == 'm'): ?>JE<?php else: ?>ME<?php endif; ?></option>
        <option value="ERW" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'ERW'): ?>style="background-color:#99FF66"<?php else: ?>style="background-color:#FFCC66"<?php endif; ?> <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == 'ERW'): ?>SELECTED<?php elseif ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['ak'] == "" && $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['spielklasse'] == 'ERW'): ?>SELECTED<?php endif; ?>> ERW <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geschlecht'] == 'm'): ?>HE<?php else: ?>DE<?php endif; ?></option>
    </select></td>
    </tr>
    <?php endfor; endif; ?>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td colspan="5" align="center"> <br>        <input name="doMeldungSubmit" type="submit" class="mittel" id="doMeldungSubmit" value="Meldung aktualisieren" style="height:50px;font-weight:bold">
        <br>
        <br>
      </td>
    </tr>
  </table>
  <div align="center"><br>
      <span class="klein">Bei technischen Problemen oder sonstigen Fragen wenden Sie sich bitte an <a href="mailto:dirk.morgenroth@gmx.net">Dirk
    Morgenroth</a> </span>
  </div>
</form>


</td>  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>