<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="robots" content="noindex, nofollow" />
        <style type="text/css">
        body{background-color:orange;font-size:1.1em;text-align:center;}
        </style>
        <title>Task 2</title>
		<style type="text/css">
body{
  background-color:#aaaabb;}
table.table{
  font-size:1.5em;
  text-align:center;
  width:60%;
  margin-left:auto;
  margin-right:auto;
  border-style:outset;
  border-width:0.3em;
  border-color:#6666dd;}
th.head{
  border-style:inset;
  border-width:0.15em;
  border-color:#9999ff;
  background-color:#44bbbb;}
td.cell1{
  border-style:inset;
  border-width:0.15em;
  border-color:#9999ff;
  background-color:#8888ff;}
td.cell2{
  border-style:inset;
  border-width:0.15em;
  border-color:#9999ff;
  background-color:#88ff88;
}
td:hover{
  background-color:#ffbbff;}

</style>
    </head>
    <body> 
	
	<table class="table">
	<tr>
		<td class="cell1">NAME</td>
		<td class="cell1">GENDER</td>
		<td class="cell1">BMI</td>
	</tr>
<?php
$country_id = $_GET['country_id'];
$part_name = $_GET['part_name'];
require_once 'MDB2.php';

include "coa123-mysql-connect.php"; //to provide $username,$password 

//T1. define $host and $dbName (coa123cdb) 
$host='localhost';
$dbName='coa123cdb';

// make connection to the server 
$dsn = "mysql://$username:$password@$host/$dbName"; 
$db =& MDB2::connect($dsn); 

if(PEAR::isError($db)){ 
    die($db->getMessage());
}
$table_cyclist="Cyclist";
$table_country="Country";

$db->setFetchMode(MDB2_FETCHMODE_ASSOC);

//T2. search for countries with population > 50000000, save the results in $res
$sql="SELECT * FROM $table_country WHERE population > 50000000";
$res =& $db->query($sql);
//search for part_name
$sql1="SELECT * FROM `Cyclist` WHERE `name` LIKE '%$part_name%' AND `ISO_id` LIKE '%$country_id%'";
$res1=& $db->query($sql1);

if(PEAR::isError($res)){
    die($res->getMessage());
}

//T4. display relevent information (e.g. country_name list) using fetchRow 
while ($row = $res1->fetchRow()) { // fetches each row of the sql query
	echo '<tr>'; //adds new row
	echo '<td class="cell2">'.$row[strtolower('name')].'</td>'; //adds the name to the first column
	echo '<td class="cell2">'.$row[strtolower('gender')].'</td>'; // adds the gender of the cyclist to the second column
	$weight1 = $row[strtolower('weight')];
	$bmi = round(($row[strtolower('weight')]/(pow(($row[strtolower('height')]/100),2))),3); //calculates bmi score
	if($weight1 === ""){
		echo '<td class="cell2">N/A</td>';
	}
	else{
		echo '<td class="cell2">'.$bmi.'</td>'; //adds bmi score to the 3rd column of the table
	}
	echo '</tr>';
}
?>
</table>
</body>
</html>