<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="robots" content="noindex, nofollow" />
        <style type="text/css">
        body{background-color:orange;font-size:1.1em;text-align:center;}
        </style>
        <title>Task 3</title>
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
<?php
function dateConverter($dateInput){ //converts date to database form
	$date = substr($dateInput,0,2); //day of the dob
	$month = substr($dateInput,3,2); //month of dob
	$year = substr($dateInput,6); //year of dob
	$result = $year."-".$month."-".$date; //converts dob to YYYY-MM-DD form
	return $result;
}
$date_1 = dateConverter($_GET['date_1']); //gets date 1 from HTML form
$date_2 = dateConverter($_GET['date_2']); //gets date 2 from HTML form
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
$sql1="SELECT * FROM `Cyclist` INNER JOIN `Country` ON Cyclist.ISO_id=Country.ISO_id WHERE `dob` >= '$date_1' AND `dob` <= '$date_2'";
$res1=& $db->query($sql1);
if(PEAR::isError($res)){
    die($res->getMessage());
}
while($row=$res1->fetchRow()){
	$rows[] = $row;	
}
$jsonResult = json_encode($rows); // json encodes the sql result
$json_array  = json_decode($jsonResult, true);
$elementCount  = count($json_array);
echo $jsonResult; //output the JSON array object


?>
</table>	
</body>
</html>