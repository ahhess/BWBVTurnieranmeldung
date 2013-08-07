<?php

include("config.inc.php");
include("funktionen.inc.php");

// Vereine holen
include("../adodb/adodb.inc.php");
$conn = &ADONewConnection('mysql');	# create a connection
$conn->PConnect('localhost',"root","","anmeldung");   # connect to MS-Access, northwind dsn
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$recordSet = &$conn->Execute('select * from tas_vereine');

$aVerein=array();
if (!$recordSet)
	print $conn->ErrorMsg();
else
while (!$recordSet->EOF) {
	$aVerein[strtolower($recordSet->fields["name"])]=$recordSet->fields["id"];
	$recordSet->MoveNext();
}
$recordSet->Close(); # optional
$conn->Close(); # optional


$lines = file("datensatz_w.inc");
$countLines=count($lines);
reset($lines);
$j=0;
for ($i=0;$i<$countLines;$i++)
{
	$row=explode("\t",$lines[$i]);
	if (true)
	{
		$s[$j]["vorname"]=$row[4];
		$s[$j]["nachname"]=$row[3];
		$s[$j]["geburtstag"]=$row[5];
	//	$s[$j]["passnummer"]=$row[];
		$s[$j]["geschlecht"]='w';

		$verein=trim(strtolower($row[9]));
		$s[$j]["id_vereine"]=$aVerein[$verein];
		if (!$s[$j]["id_vereine"]) $s[$j]["bemerkung"]=strtolower($row[9]);
		$j++;
	}
}

//print "<pre>";print_r($s);
//print_r($aVerein);


// Spieler speichern
$sql = "SELECT * FROM tas_spieler WHERE id = -1";
# Select an empty record from the database

$conn = &ADONewConnection("mysql");  # create a connection
$conn->debug=1;
$conn->PConnect('localhost',"root","","anmeldung");   # connect to MS-Access, northwind dsn
$rs = $conn->Execute($sql); # Execute the query and get the empty recordset

$record = array(); # Initialize an array to hold the record data to insert

# Pass the empty recordset and the array containing the data to insert
# into the GetInsertSQL function. The function will process the data and return
# a fully formatted insert sql statement.

for ($i=0;$i<$j;$i++)
{
	$record=$s[$i];
	$record["geburtstag"]=substr($record["geburtstag"],6,4)."-".substr($record["geburtstag"],3,2)."-".substr($record["geburtstag"],0,2);
	echo $record["geburtstag"];
	$insertSQL = $conn->GetInsertSQL($rs, $record);
//	print "sql: ".$insertSQL."<br>";
	$conn->Execute($insertSQL); # Insert the record into the database
}



?>
