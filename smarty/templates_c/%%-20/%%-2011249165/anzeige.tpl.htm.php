<?php /* Smarty version 2.5.0, created on 2012-01-13 22:50:52
         compiled from anzeige.tpl.htm */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Meldungen <?php echo $this->_tpl_vars['turniername']; ?>
 (Stand: <?php echo $this->_tpl_vars['datum']; ?>
)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<span class="mittel">&Uuml;bersicht der aktuellen Meldungen:<br>
</span><h2 class="gross"><?php echo $this->_tpl_vars['turniername']; ?>
</h2>
<p class="klein">Folgende Meldungen sind derzeit in dem Meldesystem hinterlegt.<br>
  Hinweis: Nach Ende der Meldefrist kann diese Liste unter Umst&auml;nden nicht mehr
    aktuell sein.<br>
    Kontaktieren Sie in diesem Fall ggf. den Turnierbeauftragten. </p>
<p class="mittel">( Stand:
    <?php echo $this->_tpl_vars['datum']; ?>
, <?php echo $this->_tpl_vars['zeit']; ?>
 Uhr ) </p>
<p class="mittel"><strong><br>
Bisher online gemeldete Vereine (<?php echo $this->_tpl_vars['countVereine']; ?>
):</strong></p>
<p class="klein"><?php if (isset($this->_sections['verein'])) unset($this->_sections['verein']);
$this->_sections['verein']['name'] = 'verein';
$this->_sections['verein']['loop'] = is_array($this->_tpl_vars['vereine']) ? count($this->_tpl_vars['vereine']) : max(0, (int)$this->_tpl_vars['vereine']);
$this->_sections['verein']['show'] = true;
$this->_sections['verein']['max'] = $this->_sections['verein']['loop'];
$this->_sections['verein']['step'] = 1;
$this->_sections['verein']['start'] = $this->_sections['verein']['step'] > 0 ? 0 : $this->_sections['verein']['loop']-1;
if ($this->_sections['verein']['show']) {
    $this->_sections['verein']['total'] = $this->_sections['verein']['loop'];
    if ($this->_sections['verein']['total'] == 0)
        $this->_sections['verein']['show'] = false;
} else
    $this->_sections['verein']['total'] = 0;
if ($this->_sections['verein']['show']):

            for ($this->_sections['verein']['index'] = $this->_sections['verein']['start'], $this->_sections['verein']['iteration'] = 1;
                 $this->_sections['verein']['iteration'] <= $this->_sections['verein']['total'];
                 $this->_sections['verein']['index'] += $this->_sections['verein']['step'], $this->_sections['verein']['iteration']++):
$this->_sections['verein']['rownum'] = $this->_sections['verein']['iteration'];
$this->_sections['verein']['index_prev'] = $this->_sections['verein']['index'] - $this->_sections['verein']['step'];
$this->_sections['verein']['index_next'] = $this->_sections['verein']['index'] + $this->_sections['verein']['step'];
$this->_sections['verein']['first']      = ($this->_sections['verein']['iteration'] == 1);
$this->_sections['verein']['last']       = ($this->_sections['verein']['iteration'] == $this->_sections['verein']['total']);
?>
    <?php echo $this->_tpl_vars['vereine'][$this->_sections['verein']['index']]['davor']; ?>
 <?php echo $this->_tpl_vars['vereine'][$this->_sections['verein']['index']]['name']; ?>
<br>
<?php endfor; endif; ?> </p>
<p class="mittel"><strong><br>
Bisher gemeldete Spieler/innen (<?php echo $this->_tpl_vars['countMeldungen']; ?>
): </strong></p>
<table border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
  <tr bgcolor="#CCCCCC" class="mittel">
    <td><strong>Nachname</strong></td>
    <td><strong>Vorname</strong></td>
    <td><strong>Verein</strong></td>
    <td><strong>Altersklasse</strong></td>
    <td><strong>Geburtstag</strong></td>
    <td><strong>Geschlecht</strong></td>
  </tr>
  <?php if (isset($this->_sections['spieler'])) unset($this->_sections['spieler']);
$this->_sections['spieler']['name'] = 'spieler';
$this->_sections['spieler']['loop'] = is_array($this->_tpl_vars['meldungen']) ? count($this->_tpl_vars['meldungen']) : max(0, (int)$this->_tpl_vars['meldungen']);
$this->_sections['spieler']['show'] = true;
$this->_sections['spieler']['max'] = $this->_sections['spieler']['loop'];
$this->_sections['spieler']['step'] = 1;
$this->_sections['spieler']['start'] = $this->_sections['spieler']['step'] > 0 ? 0 : $this->_sections['spieler']['loop']-1;
if ($this->_sections['spieler']['show']) {
    $this->_sections['spieler']['total'] = $this->_sections['spieler']['loop'];
    if ($this->_sections['spieler']['total'] == 0)
        $this->_sections['spieler']['show'] = false;
} else
    $this->_sections['spieler']['total'] = 0;
if ($this->_sections['spieler']['show']):

            for ($this->_sections['spieler']['index'] = $this->_sections['spieler']['start'], $this->_sections['spieler']['iteration'] = 1;
                 $this->_sections['spieler']['iteration'] <= $this->_sections['spieler']['total'];
                 $this->_sections['spieler']['index'] += $this->_sections['spieler']['step'], $this->_sections['spieler']['iteration']++):
$this->_sections['spieler']['rownum'] = $this->_sections['spieler']['iteration'];
$this->_sections['spieler']['index_prev'] = $this->_sections['spieler']['index'] - $this->_sections['spieler']['step'];
$this->_sections['spieler']['index_next'] = $this->_sections['spieler']['index'] + $this->_sections['spieler']['step'];
$this->_sections['spieler']['first']      = ($this->_sections['spieler']['iteration'] == 1);
$this->_sections['spieler']['last']       = ($this->_sections['spieler']['iteration'] == $this->_sections['spieler']['total']);
?>
  <tr bgcolor="#FFFFFF" class="klein">
    <td width="150"><?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['nachname']; ?>
</td>
    <td><?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['vorname']; ?>
</td>
    <td><?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['davor']; ?>
 <?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['verein']; ?>
</td>
    <td><?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['ak']; ?>
</td>
    <td><?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['geburtstag']; ?>
</td>
    <td><?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['geschlecht']; ?>
</td>
  </tr>
  <?php if ($this->_tpl_vars['meldungen'][$this->_sections['spieler']['index_next']]['ak'] != $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['ak']): ?>
  <tr bgcolor="#FFFFFF"><td colspan=6>&nbsp;---&nbsp;</td></tr>
  <?php elseif ($this->_tpl_vars['meldungen'][$this->_sections['spieler']['index_next']]['geschlecht'] != $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['geschlecht']): ?>
  <tr bgcolor="#FFFFFF"><td colspan=5 align=middle>&nbsp;---------------------&nbsp;</td></tr>
  <?php endif; ?>
  <?php endfor; endif; ?>
</table>
<p><span class="klein">www.esentri.de / turnieranmeldung</span><br><!--
<?php if (isset($this->_sections['spieler'])) unset($this->_sections['spieler']);
$this->_sections['spieler']['name'] = 'spieler';
$this->_sections['spieler']['loop'] = is_array($this->_tpl_vars['meldungen']) ? count($this->_tpl_vars['meldungen']) : max(0, (int)$this->_tpl_vars['meldungen']);
$this->_sections['spieler']['show'] = true;
$this->_sections['spieler']['max'] = $this->_sections['spieler']['loop'];
$this->_sections['spieler']['step'] = 1;
$this->_sections['spieler']['start'] = $this->_sections['spieler']['step'] > 0 ? 0 : $this->_sections['spieler']['loop']-1;
if ($this->_sections['spieler']['show']) {
    $this->_sections['spieler']['total'] = $this->_sections['spieler']['loop'];
    if ($this->_sections['spieler']['total'] == 0)
        $this->_sections['spieler']['show'] = false;
} else
    $this->_sections['spieler']['total'] = 0;
if ($this->_sections['spieler']['show']):

            for ($this->_sections['spieler']['index'] = $this->_sections['spieler']['start'], $this->_sections['spieler']['iteration'] = 1;
                 $this->_sections['spieler']['iteration'] <= $this->_sections['spieler']['total'];
                 $this->_sections['spieler']['index'] += $this->_sections['spieler']['step'], $this->_sections['spieler']['iteration']++):
$this->_sections['spieler']['rownum'] = $this->_sections['spieler']['iteration'];
$this->_sections['spieler']['index_prev'] = $this->_sections['spieler']['index'] - $this->_sections['spieler']['step'];
$this->_sections['spieler']['index_next'] = $this->_sections['spieler']['index'] + $this->_sections['spieler']['step'];
$this->_sections['spieler']['first']      = ($this->_sections['spieler']['iteration'] == 1);
$this->_sections['spieler']['last']       = ($this->_sections['spieler']['iteration'] == $this->_sections['spieler']['total']);
?>
<?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['nachname']; ?>
&#09;<?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['vorname']; ?>
<?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['davor']; ?>
 <?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['verein']; ?>
&#09;<?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['ak']; ?>
&#09;<?php echo $this->_tpl_vars['meldungen'][$this->_sections['spieler']['index']]['geschlecht']; ?>
<br>
<?php endfor; endif; ?>
  </p>-->
</body>
</html>