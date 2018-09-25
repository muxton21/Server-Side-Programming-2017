<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex, nofollow" />

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

<title>Task 1 B619042</title>

</head>
<body>
<table class="table">
<?php 

$min_weight = $_GET['min_weight']; // obtains the value of the min weight field in the form of the bmi.htm file
$max_weight = $_GET['max_weight']; // obtains the value of the max weight field in the form of the bmi.htm file
$min_height = $_GET['min_height']; // obtains the value of the min height field in the form of the bmi.htm file
$max_height = $_GET['max_height']; // obtains the value of the max height field in the form of the bmi.htm file

for($i=$min_weight-5;$i<=$max_weight;$i=$i+5){ //initiates for loop cycling through the range of weights, adding 5 to the i variable to increment through factors of 5 until the i variable is greater than the max weight
	echo '<tr>'; // creates the table row
	if ($i===($min_weight-5)){ //if statement to add the first colum as the header 
		echo '<td class="cell1">Weight(Kg)/Height(cm)</td>';
		for($j=$min_height;$j<=$max_height;$j=$j+5) {
			echo '<td class="cell1">'.$j.'</td>'; // for loop adds each increment of 5 in the range of heights to the top row in individual colums 
		}
	}
	else{
		for($j=$min_height-5;$j<=$max_height;$j=$j+5) { // for loop cycles through the range of heights adding 5 to the j variable
			if($i === ($min_weight-5) || $j === ($min_height-5) ){ // if statement identifies that this is a new row and the first colum so the weight variable should be in this field
    		echo '<td class="cell1">'.$i.'</td>'; // adds the current weight value to the first field of each row
			}
			else {
				echo '<td class="cell2">'.round(($i/(pow(($j/100),2))),3).'</td>'; // calculates the BMI for each weight and height score
				}
			}
		}
		echo '</tr>'; //closing tag for a table row
	}

?>
</table>
</body>
</html>
