<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8" />
<style type="text/css">  
body {
	background: #fba4f6;
		    color: #eee;
		    font-family: Century Gothic;
		    text-align: center;
		    font-size: 1em;
}
.center {
	text-align:center;
}
body,td,th {
	color: #eee; 
}
.larger {
	font-size:larger;
	text-align:right;
}
table {
	margin-left:auto;
	margin-right:auto;
} 
</style> <!-- Everything inside these style tags is just to make things look how you want them to look -->
</head>

<body>
<h3 class="center">COA123 - Server-Side Programming</h3> <!-- "<h>" is a heading tag ... there are  different settings of heading that look different "<h3>" for example -->
<h2 class="center">Individual Coursework - London 2012</h2>
<h1 class="center">Task 2 - Details (details.php)</h1>

<?php // The PHP code starts here

$DOB=$_GET['dob'];
//This instruction calls the date of birth from the database in the format YYYY/MM/DD
$CyclistName=$_GET["name"];
$CountryName=$_GET['ISO_id'];
$GDP=$_GET['gdp'];
$Population=$_GET['population'];

require_once 'MDB2.php';

include "coa123-mysql-connect.php"; 

//this is to get a $username,$password to access the databases

//T1. define $host and $dbName (coa123cdb) 
$host   = 'localhost';
$dbName = 'coa123cdb';

// make connection to the server 
$dsn = "mysql://$username:$password@$host/$dbName";
$db =& MDB2::connect($dsn);

if (PEAR::isError($db)) {
    die($db->getMessage());
}

$db->setFetchMode(MDB2_FETCHMODE_ASSOC);

$myAdmin="SELECT Country.ISO_id, Cyclist.name, Cyclist.dob, Country.gpd, Country.population
        
  FROM `Country` JOIN `Cyclist` ON Country.ISO_id=Cyclist.ISO_id
        
  WHERE Country.ISO_id LIKE '%" . $CountryName . "%' AND Country.gpd= '" . $GDP . "' AND Country.population = '" . $Population . '" AND Cyclist.name = "'. $CyclistName . '" AND Cyclist.dob = "' . $DOB . "'";

  $res =& $db->query($myAdmin);
  
    echo "<table>";
  
$date1 = strtotime($res["date"]);
$date2 = date("d/m/Y",$date1);

echo "<tr>";  
while($DOB=$res->fetchrow()){


        echo "<td>" . $DOB . "<br />" . "</td>";
        echo "<td>" . $CyclistName . "<br />" . "</td>";
		echo "<td>" . $CountryName . "<br />" . "</td>";
		echo "<td>" . $GDP . "<br />" . "</td>";
		echo "<td>" . $Population . "<br />" . "</td>";
        
    }
    
    echo "</tr>";

	
?>
</body>
</html>