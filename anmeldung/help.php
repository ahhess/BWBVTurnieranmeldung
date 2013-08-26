<?php
session_start();
include("funktionen.inc.php");

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('menuakt','help.php');
$smarty->display('help.tpl.htm');
?>
