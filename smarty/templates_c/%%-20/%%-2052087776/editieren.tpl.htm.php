<?php /* Smarty version 2.5.0, created on 2012-01-14 23:16:14
         compiled from editieren.tpl.htm */ ?>
<?php $this->_load_plugins(array(
array('function', 'cycle', 'editieren.tpl.htm', 44, false),)); ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Turnieranmeldesystem Badminton NB - Editieren</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<p><?php if (isset($this->_sections["&quot;fehlerbox&quot;"])) unset($this->_sections["&quot;fehlerbox&quot;"]);
$this->_sections["&quot;fehlerbox&quot;"]['name'] = "&quot;fehlerbox&quot;";
$this->_sections["&quot;fehlerbox&quot;"]['show'] = (bool)$this->_tpl_vars['fehlermeldung'];
$this->_sections["&quot;fehlerbox&quot;"]['loop'] = 1;
$this->_sections["&quot;fehlerbox&quot;"]['max'] = $this->_sections["&quot;fehlerbox&quot;"]['loop'];
$this->_sections["&quot;fehlerbox&quot;"]['step'] = 1;
$this->_sections["&quot;fehlerbox&quot;"]['start'] = $this->_sections["&quot;fehlerbox&quot;"]['step'] > 0 ? 0 : $this->_sections["&quot;fehlerbox&quot;"]['loop']-1;
if ($this->_sections["&quot;fehlerbox&quot;"]['show']) {
    $this->_sections["&quot;fehlerbox&quot;"]['total'] = $this->_sections["&quot;fehlerbox&quot;"]['loop'];
    if ($this->_sections["&quot;fehlerbox&quot;"]['total'] == 0)
        $this->_sections["&quot;fehlerbox&quot;"]['show'] = false;
} else
    $this->_sections["&quot;fehlerbox&quot;"]['total'] = 0;
if ($this->_sections["&quot;fehlerbox&quot;"]['show']):

            for ($this->_sections["&quot;fehlerbox&quot;"]['index'] = $this->_sections["&quot;fehlerbox&quot;"]['start'], $this->_sections["&quot;fehlerbox&quot;"]['iteration'] = 1;
                 $this->_sections["&quot;fehlerbox&quot;"]['iteration'] <= $this->_sections["&quot;fehlerbox&quot;"]['total'];
                 $this->_sections["&quot;fehlerbox&quot;"]['index'] += $this->_sections["&quot;fehlerbox&quot;"]['step'], $this->_sections["&quot;fehlerbox&quot;"]['iteration']++):
$this->_sections["&quot;fehlerbox&quot;"]['rownum'] = $this->_sections["&quot;fehlerbox&quot;"]['iteration'];
$this->_sections["&quot;fehlerbox&quot;"]['index_prev'] = $this->_sections["&quot;fehlerbox&quot;"]['index'] - $this->_sections["&quot;fehlerbox&quot;"]['step'];
$this->_sections["&quot;fehlerbox&quot;"]['index_next'] = $this->_sections["&quot;fehlerbox&quot;"]['index'] + $this->_sections["&quot;fehlerbox&quot;"]['step'];
$this->_sections["&quot;fehlerbox&quot;"]['first']      = ($this->_sections["&quot;fehlerbox&quot;"]['iteration'] == 1);
$this->_sections["&quot;fehlerbox&quot;"]['last']       = ($this->_sections["&quot;fehlerbox&quot;"]['iteration'] == $this->_sections["&quot;fehlerbox&quot;"]['total']);
?></p>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#FF0000"><?php echo $this->_tpl_vars['fehlermeldung']; ?>
</td>
  </tr>
</table>
<p><?php endfor; endif; ?><?php if (isset($this->_sections["&quot;systembox&quot;"])) unset($this->_sections["&quot;systembox&quot;"]);
$this->_sections["&quot;systembox&quot;"]['name'] = "&quot;systembox&quot;";
$this->_sections["&quot;systembox&quot;"]['show'] = (bool)$this->_tpl_vars['systemmeldung'];
$this->_sections["&quot;systembox&quot;"]['loop'] = 1;
$this->_sections["&quot;systembox&quot;"]['max'] = $this->_sections["&quot;systembox&quot;"]['loop'];
$this->_sections["&quot;systembox&quot;"]['step'] = 1;
$this->_sections["&quot;systembox&quot;"]['start'] = $this->_sections["&quot;systembox&quot;"]['step'] > 0 ? 0 : $this->_sections["&quot;systembox&quot;"]['loop']-1;
if ($this->_sections["&quot;systembox&quot;"]['show']) {
    $this->_sections["&quot;systembox&quot;"]['total'] = $this->_sections["&quot;systembox&quot;"]['loop'];
    if ($this->_sections["&quot;systembox&quot;"]['total'] == 0)
        $this->_sections["&quot;systembox&quot;"]['show'] = false;
} else
    $this->_sections["&quot;systembox&quot;"]['total'] = 0;
if ($this->_sections["&quot;systembox&quot;"]['show']):

            for ($this->_sections["&quot;systembox&quot;"]['index'] = $this->_sections["&quot;systembox&quot;"]['start'], $this->_sections["&quot;systembox&quot;"]['iteration'] = 1;
                 $this->_sections["&quot;systembox&quot;"]['iteration'] <= $this->_sections["&quot;systembox&quot;"]['total'];
                 $this->_sections["&quot;systembox&quot;"]['index'] += $this->_sections["&quot;systembox&quot;"]['step'], $this->_sections["&quot;systembox&quot;"]['iteration']++):
$this->_sections["&quot;systembox&quot;"]['rownum'] = $this->_sections["&quot;systembox&quot;"]['iteration'];
$this->_sections["&quot;systembox&quot;"]['index_prev'] = $this->_sections["&quot;systembox&quot;"]['index'] - $this->_sections["&quot;systembox&quot;"]['step'];
$this->_sections["&quot;systembox&quot;"]['index_next'] = $this->_sections["&quot;systembox&quot;"]['index'] + $this->_sections["&quot;systembox&quot;"]['step'];
$this->_sections["&quot;systembox&quot;"]['first']      = ($this->_sections["&quot;systembox&quot;"]['iteration'] == 1);
$this->_sections["&quot;systembox&quot;"]['last']       = ($this->_sections["&quot;systembox&quot;"]['iteration'] == $this->_sections["&quot;systembox&quot;"]['total']);
?></p>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td bgcolor="#00FF00"><?php echo $this->_tpl_vars['systemmeldung']; ?>
</td>
  </tr>
</table>
<p><?php endfor; endif; ?></p>
<table width="400" border="0" cellpadding="2" cellspacing="1" bgcolor="#00CC33">
  <tr bgcolor="#FFFFFF"> 
    <td>Eingeloggter Verein</td>
    <td> <?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['davor']; ?>
 <?php echo $GLOBALS['HTTP_SESSION_VARS']['verein']['name']; ?>
</td>
  </tr>
</table>
<a href="logoff.php">Logoff</a> <a href="index.php">&Uuml;bersicht</a> 
<h1>EDITIERMODUS!!!</h1>
<p>Zum L&ouml;schen eines Spielers bitte den Inhalt dessen Feld Nachname <em>l&ouml;schen<br>
  Funktion f&uuml;r Geschlecht funktioniert noch nicht einwandfrei..</em></p>
<form action="" method="post" name="f" id="f">
  <table width="750" border="0" cellpadding="2" cellspacing="1" bgcolor="#0033FF">
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td>Nachname</td>
      <td>Vorname</td>
      <td>Geburtsdatum<br>
        JAHR-MONAT-TAG</td>
      <td>Passnummer</td>
      <td>Geschlecht</td>
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
      <td> <input name="meldung[]" type="checkbox" id="meldung[]" value="<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['turnier_id'] == $GLOBALS['HTTP_SESSION_VARS']['tid']): ?>CHECKED<?php endif; ?>></td>
      <td><input name="nachname[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]" type="text" id="nachname[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]" value="<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['nachname']; ?>
"> 
      </td>
      <td><input name="vorname[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]" type="text" id="vorname[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]" value="<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['vorname']; ?>
"> 
      </td>
      <td> <input name="geburtstag[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]" type="text" id="geburtstag[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]" value="<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geburtstag']; ?>
 "></td>
      <td><input name="passnummer[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]" type="text" id="passnummer[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]" value="<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['passnummer']; ?>
"></td>
      <td><select name="geschlecht[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]" id="geschlecht[<?php echo $this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['id']; ?>
]">
          <option value="m" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geschlecht'] == m): ?>SELECTED<?php endif; ?>>M&auml;nnlich</option>
          <option value="w" <?php if ($this->_tpl_vars['spieler'][$this->_sections['zeile']['index']]['geschlecht'] == w): ?>SELECTED<?php endif; ?>>Weiblich</option>
        </select></td>
    </tr>
    <?php endfor; endif; ?> 
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td colspan="5" align="center"> <input name="doSpielerAktualisieren" type="submit" id="doSpielerAktualisieren" value="Spielerdaten aktualisieren"> 
      </td>
    </tr>
  </table>
</form>
<form name="form1" method="post" action="">
  <p>Neuen Spieler hinzuf&uuml;gen:</p>
  <table border="0" cellpadding="2" cellspacing="1" bgcolor="#0033FF">
    <tr bgcolor="#FFFFFF"> 
      <td>Nachname</td>
      <td>Vorname</td>
      <td>Geburtsdatum</td>
      <td>Passnummer</td>
      <td>Geschlecht</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#dddddd"> 
      <td valign="top"> <input name="nachname" type="text" id="nachname3" size="20"></td>
      <td valign="top"> <input name="vorname" type="text" id="vorname3" size="20"></td>
      <td valign="top"> <input name="tag" type="text" id="tag3" size="2" maxlength="2">
        . 
        <input name="monat" type="text" id="monat3" size="2" maxlength="2">
        . 
        <input name="jahr" type="text" id="jahr3" size="4" maxlength="4">
        (Tag.Monat.Jahr) </td>
      <td valign="top"> <input name="passnummer" type="text" id="passnummer3" size="20"></td>
      <td valign="top"><select name="geschlecht" id="select2">
          <option value="m">M&auml;nnlich</option>
          <option value="w">Weiblich</option>
      </select></td>
      <td valign="top"><input name="doInsertSubmit" type="submit" id="doInsertSubmit2" value="Spieler hinzuf&uuml;gen"></td>
    </tr>
  </table>
</form>
</body>
</html>