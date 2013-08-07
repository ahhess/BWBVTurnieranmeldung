<?php /* Smarty version 2.5.0, created on 2003-08-27 22:02:37
         compiled from index.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'capitalize', 'index.tpl', 9, false),
array('modifier', 'date_format', 'index.tpl', 12, false),
array('modifier', 'upper', 'index.tpl', 24, false),
array('function', 'popup', 'index.tpl', 14, false),
array('function', 'html_select_date', 'index.tpl', 66, false),
array('function', 'html_select_time', 'index.tpl', 72, false),
array('function', 'html_options', 'index.tpl', 79, false),)); ?><?php $this->config_load("test.conf", 'setup', 'local'); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("header.tpl", array('title' => 'foo'));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<PRE>


<?php if ($this->_config[0]['vars']['bold']): ?><b><?php endif; ?>

Title: <?php echo $this->_run_mod_handler('capitalize', true, $this->_config[0]['vars']['title']); ?>

<?php if ($this->_config[0]['vars']['bold']): ?></b><?php endif; ?>

The current date and time is <?php echo $this->_run_mod_handler('date_format', true, time(), "%Y-%m-%d %H:%M:%S"); ?>


Tooltip example: Move your mouse over the <A HREF="" <?php echo $this->_plugins['function']['popup'][0](array('sticky' => true,'caption' => "Smarty pop-up text",'delay' => 400,'text' => "This is an example of a tooltip. Tooltips are handy for context sensitive information, and extremely easy to add to your templates with Smarty and the integration of <a href='http://www.bosrup.com/web/overlib/'>overLIB</a> by Erik Bosrup"), $this) ; ?>
 onclick="return false;">Help</A> link to see an example of a tooltip using Smarty's popup function.

The value of global assigned variable $SCRIPT_NAME is <?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>


Example of accessing server environment variable SERVER_NAME: <?php echo $GLOBALS['HTTP_SERVER_VARS']['SERVER_NAME']; ?>


The value of {$Name} is <b><?php echo $this->_tpl_vars['Name']; ?>
</b>

variable modifier example of {$Name|upper}

<b><?php echo $this->_run_mod_handler('upper', true, $this->_tpl_vars['Name']); ?>
</b>


An example of a section loop:

<?php if (isset($this->_sections['outer'])) unset($this->_sections['outer']);
$this->_sections['outer']['name'] = 'outer';
$this->_sections['outer']['loop'] = is_array($this->_tpl_vars['FirstName']) ? count($this->_tpl_vars['FirstName']) : max(0, (int)$this->_tpl_vars['FirstName']);
$this->_sections['outer']['show'] = true;
$this->_sections['outer']['max'] = $this->_sections['outer']['loop'];
$this->_sections['outer']['step'] = 1;
$this->_sections['outer']['start'] = $this->_sections['outer']['step'] > 0 ? 0 : $this->_sections['outer']['loop']-1;
if ($this->_sections['outer']['show']) {
    $this->_sections['outer']['total'] = $this->_sections['outer']['loop'];
    if ($this->_sections['outer']['total'] == 0)
        $this->_sections['outer']['show'] = false;
} else
    $this->_sections['outer']['total'] = 0;
if ($this->_sections['outer']['show']):

            for ($this->_sections['outer']['index'] = $this->_sections['outer']['start'], $this->_sections['outer']['iteration'] = 1;
                 $this->_sections['outer']['iteration'] <= $this->_sections['outer']['total'];
                 $this->_sections['outer']['index'] += $this->_sections['outer']['step'], $this->_sections['outer']['iteration']++):
$this->_sections['outer']['rownum'] = $this->_sections['outer']['iteration'];
$this->_sections['outer']['index_prev'] = $this->_sections['outer']['index'] - $this->_sections['outer']['step'];
$this->_sections['outer']['index_next'] = $this->_sections['outer']['index'] + $this->_sections['outer']['step'];
$this->_sections['outer']['first']      = ($this->_sections['outer']['iteration'] == 1);
$this->_sections['outer']['last']       = ($this->_sections['outer']['iteration'] == $this->_sections['outer']['total']);
?>
<?php if ((($this->_sections['outer']['index'] / 2) % 2)): ?>
	<?php echo $this->_sections['outer']['rownum']; ?>
 . <?php echo $this->_tpl_vars['FirstName'][$this->_sections['outer']['index']]; ?>
 <?php echo $this->_tpl_vars['LastName'][$this->_sections['outer']['index']]; ?>

<?php else: ?>
	<?php echo $this->_sections['outer']['rownum']; ?>
 * <?php echo $this->_tpl_vars['FirstName'][$this->_sections['outer']['index']]; ?>
 <?php echo $this->_tpl_vars['LastName'][$this->_sections['outer']['index']]; ?>

<?php endif; ?>
<?php endfor; else: ?>
	none
<?php endif; ?>

An example of section looped key values:

<?php if (isset($this->_sections['sec1'])) unset($this->_sections['sec1']);
$this->_sections['sec1']['name'] = 'sec1';
$this->_sections['sec1']['loop'] = is_array($this->_tpl_vars['contacts']) ? count($this->_tpl_vars['contacts']) : max(0, (int)$this->_tpl_vars['contacts']);
$this->_sections['sec1']['show'] = true;
$this->_sections['sec1']['max'] = $this->_sections['sec1']['loop'];
$this->_sections['sec1']['step'] = 1;
$this->_sections['sec1']['start'] = $this->_sections['sec1']['step'] > 0 ? 0 : $this->_sections['sec1']['loop']-1;
if ($this->_sections['sec1']['show']) {
    $this->_sections['sec1']['total'] = $this->_sections['sec1']['loop'];
    if ($this->_sections['sec1']['total'] == 0)
        $this->_sections['sec1']['show'] = false;
} else
    $this->_sections['sec1']['total'] = 0;
if ($this->_sections['sec1']['show']):

            for ($this->_sections['sec1']['index'] = $this->_sections['sec1']['start'], $this->_sections['sec1']['iteration'] = 1;
                 $this->_sections['sec1']['iteration'] <= $this->_sections['sec1']['total'];
                 $this->_sections['sec1']['index'] += $this->_sections['sec1']['step'], $this->_sections['sec1']['iteration']++):
$this->_sections['sec1']['rownum'] = $this->_sections['sec1']['iteration'];
$this->_sections['sec1']['index_prev'] = $this->_sections['sec1']['index'] - $this->_sections['sec1']['step'];
$this->_sections['sec1']['index_next'] = $this->_sections['sec1']['index'] + $this->_sections['sec1']['step'];
$this->_sections['sec1']['first']      = ($this->_sections['sec1']['iteration'] == 1);
$this->_sections['sec1']['last']       = ($this->_sections['sec1']['iteration'] == $this->_sections['sec1']['total']);
?>
	phone: <?php echo $this->_tpl_vars['contacts'][$this->_sections['sec1']['index']]['phone']; ?>
<br>
	fax: <?php echo $this->_tpl_vars['contacts'][$this->_sections['sec1']['index']]['fax']; ?>
<br>
	cell: <?php echo $this->_tpl_vars['contacts'][$this->_sections['sec1']['index']]['cell']; ?>
<br>
<?php endfor; endif; ?>
<p>

testing strip tags
<table border=0><tr><td><A HREF="<?php echo $this->_tpl_vars['SCRIPT_NAME']; ?>"><font color="red">This is a  test     </font></A></td></tr></table>

</PRE>

This is an example of the html_select_date function:

<form>
<?php echo $this->_plugins['function']['html_select_date'][0](array('start_year' => 1998,'end_year' => 2010), $this) ; ?>

</form>

This is an example of the html_select_time function:

<form>
<?php echo $this->_plugins['function']['html_select_time'][0](array('use_24_hours' => false), $this) ; ?>

</form>

This is an example of the html_options function:

<form>
<select name=states>
<?php echo $this->_plugins['function']['html_options'][0](array('values' => $this->_tpl_vars['option_values'],'selected' => $this->_tpl_vars['option_selected'],'output' => $this->_tpl_vars['option_output']), $this) ; ?>

</select>
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("footer.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>