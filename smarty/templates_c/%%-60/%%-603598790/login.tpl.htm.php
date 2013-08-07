<?php /* Smarty version 2.5.0, created on 2012-01-13 22:48:21
         compiled from login.tpl.htm */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Badminton Turnieranmeldesystem</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

<form name="form1" method="post" action="">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="400" border="0" align="center" cellpadding="4" cellspacing="1">
    <tr>
      <td colspan="2"><p class="gross"><strong>Badminton Turnieranmeldung via
            Internet </strong><span class="mittel">Geben Sie an dieser Stelle
            bitte Ihre Zugangsdaten ein.</span></p>
          <p class="gross">&nbsp;</p></td>
    </tr>
    <tr bgcolor="#EEEEEE">
      <td width="85">Benutzername</td>
      <td width="305"><input name="benutzer" type="text" id="benutzer"></td>
    </tr>
    <tr bgcolor="#EEEEEE">
      <td>Kennwort </td>
      <td>
        <input name="passwort" type="password" id="passwort"></td>
    </tr>
    <tr>
      <td><p><img src="img/fbaelle.jpg" width="100" height="69"><br>
        <br>
      </p>      </td>
      <td valign="top"><p>
        <input name="doLoginSubmit" type="submit" id="doLoginSubmit" value="Abschicken">
      </p>
      <p><font color="red" class="klein"><?php echo $this->_tpl_vars['fehlermeldung_zugang']; ?>
</font><br>
      </p></td>
    </tr>
    <tr bgcolor="#f8f8f8">
      <td colspan="2"><p class="mittel">&Uuml;bersicht aktuelle Turniere:</p>
        <p class="klein"> <?php if (isset($this->_sections['t'])) unset($this->_sections['t']);
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
?><strong>- <?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['name_lang']; ?>
</strong><br>
          <?php if ($this->_tpl_vars['turniere'][$this->_sections['t']['index']]['datum_anmelden_ab'] != 0000 -00 -00): ?>Meldung m&ouml;glich
          bis <?php echo $this->_tpl_vars['turniere'][$this->_sections['t']['index']]['datum_anmelden_bis']; ?>
<?php endif; ?></p>
        <p class="klein"><?php endfor; else: ?>- Derzeit keine Turniere
       f&uuml;r Meldung verf&uuml;gbar -<?php endif; ?></p>
       <p class="mittel">Turniere mit abgelaufener Meldefrist:</p>
       <p class="klein"><?php if (isset($this->_sections['t'])) unset($this->_sections['t']);
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
?><strong>- <?php echo $this->_tpl_vars['turniere_abgelaufen'][$this->_sections['t']['index']]['name_lang']; ?>
</strong> </span><br>
         <?php endfor; else: ?>- Derzeit keine
      Turniere mit abgelaufener Meldefrist verf&uuml;gbar -<?php endif; ?> </p>       </td>
    </tr>
  </table>
</form>
<center>
<table bgcolor="#aaffaa" width="300"><tr><td class="klein">Neu: Um als Verein Bestätigungsmails an mehrere Kontakte zu erhalten, im Profil Email-Adressen durch Strichpunkt trennen (;)</td></tr></table>
<br>
<table bgcolor="#eeeeff" width="300"><tr><td class="klein">Hinweis: Vereine ohne bekannte Zugangsdaten können ihre <b>Zugangsdaten</b> bei Dirk Morgenroth <a href="mailto:dirk.morgenroth@gmx.net">Email</a> <b>beantragen</b>. Notwendige Informationen in der Email: genauer Name des Vereins, Email des Ansprechpartners für Turniermeldungen.</td></tr></table>

</center>
</body>
</html>