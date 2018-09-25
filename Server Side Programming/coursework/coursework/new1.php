<?php
require_once 'MDB2.php';

include "coa123-mysql-connect.php"; //to provide $username,$password

$host='localhost';
$dbName='coa123cdb';
$dsn = "mysql://$username:$password@$host/$dbName"; 

$db =& MDB2::connect($dsn); 
if(PEAR::isError($db)){ 
    die($db->getMessage());
}
$table_cyclist="Cyclist";
$table_country="Country";

$db->setFetchMode(MDB2_FETCHMODE_ASSOC);

//Task1: set $sql string to select cyclists from countries wining over total 100 medals with information of country ISO_id, cyclist name and total medal number, order the result based on total medal number.
$sql="SELECT Cyclist.name, Country.ISO_id, Country.total FROM 
Country JOIN Cyclist ON Country.ISO_id=Cyclist.ISO_id 
WHERE Country.total>80 order by Country.total DESC, name";

$res =& $db->query($sql);
if(PEAR::isError($res)){
    die($res->getMessage());
}

$value = json_encode($res->fetchAll());
?>
<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript">
    var value='<?php echo $value?>';  // php write into javascript, as jsontext 
    $(document).ready(function(){ 
		//Task2: replace the text of #stub1 with value from Json using jQuery $().text (Ref. lecture example) 
		$("#stub1").text("Detailed value from Json: "+value);
		
		// parse() method parses a jsontext string back to JSON array,
		// https://msdn.microsoft.com/library/cc836466%28v=vs.94%29.aspx 
        var obj2 = JSON.parse(value); 
        //Task3: display iso_id, medal total and cyclist name of these countries at #stub2 using $().append(...) 
		for(field in obj2) {
			$("#stub2").append( "<div>" + obj2[field].iso_id + " " + obj2[field].total + " "+ obj2[field].name +"</div>" ); 
		}

    });
</script>
<style type="text/css">
        body{background-color:orange;font-size:1.1em;text-align:center;}
</style>
</head>
<body>
	<h2> Workshop 5 - MySQL Databases with PEAR and AJAX </h2>
	<p id="stub1">Details of these cyclists displayed here (jsontext)</p> 	
    <p id="stub2">iso_id and cyclists of countries with total medal number > 80 displayed below</p> 
</body>
</html>