<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8"/>
      <title>Task 4</title>
      <link rel="stylesheet" type="text/css" href="view.css">
      <!-- links the external css file -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script>
	       <?php 
				  require_once 'MDB2.php';
               
               include "coa123-mysql-connect.php"; //to provide $username,$password 
               
               //defines $host and $dbName 
               $host='localhost';
               $dbName='coa123cdb';
               
               // makes connection to the server 
               $dsn = "mysql://$username:$password@$host/$dbName"; 
               $db =& MDB2::connect($dsn); 
               
               if(PEAR::isError($db)){ 
                   die($db->getMessage());
               }
               $table_cyclist="Cyclist";
               $table_country="Country";
               
               $db->setFetchMode(MDB2_FETCHMODE_ASSOC);
               
               
               //search for ISO_id in JOINed SQL databases
               //countries 1 and 2
               $sql1="SELECT `ISO_id`,`country_name` FROM `Country`";
               
               
               //countries 1 and 2
               $dropDown=& $db->query($sql1);
               if(PEAR::isError($dropDown)){
                   die($dropDown->getMessage());
               }
               
               //creates the results tables headings
               // displays relevent information (e.g. country_name, gold, silver, bronze ) using fetchRow 
               //countries 1 and 2
			   
			   $dropDownResult =json_encode($dropDown->fetchAll());
               ?>
         $(function() {
             $(".pageTitle").animate({opacity:'1'}, 1000); //animation for fade in efffect
         });
         $(function() {
             $(".caption").animate({opacity:'1'}, 3000); //animation for fade in efffect
         });
         $(function() {
             $(".border").animate({opacity:'1'}, 4000); //animation for fade in efffect
         });
         $(document).ready(function() {
             $("#subTitle").click(function(event){
                 $('html, body').animate({scrollTop: $("#submit").offset().top},1600);	//animation for fade in efffect
             });
         });
         $(document).ready(function() {
             $("#countries-four").click(function(event){ //adds 2 more input boxes if 4 countries are selected
				$( "#country-inputs" ).html(  "<form id='countryForm' action='viewFour.php'><table class='country-select'><tr><th class='country-select'><select name='dropDownCountryOne' id='dropDownCountryOne' required></select></th></tr><tr><th class='country-select'><select name='dropDownCountryTwo' id='dropDownCountryTwo' required></select></th></tr><tr><tr><th class='country-select'><select name='dropDownCountryThree' id='dropDownCountryThree' required></select></th></tr><tr><th class='country-select'><select name='dropDownCountryFour' id='dropDownCountryFour' required></select></th></tr></table><input type='submit' align='left' id='submit' value='Submit'><br><br><br></form>" );
                 $( "#countries-four" ).html("<p class='countries-choice'  style='color:#feb0b0;'>Four</p>");
         		$( "#countries-two" ).html("<p class='countries-choice'>Two</p>");
				var dropDownArray = <?php echo $dropDownResult ?>;
				$("#dropDownCountryOne").append ("<option disabled selected>Select A Country</option>");
			    $("#dropDownCountryTwo").append ("<option disabled selected>Select A Country</option>");
				$("#dropDownCountryThree").append ("<option disabled selected>Select A Country</option>");
			    $("#dropDownCountryFour").append ("<option disabled selected>Select A Country</option>");
				console.log(dropDownArray);
				for(var i=0;i<dropDownArray.length;i++){
					$("#dropDownCountryOne").append("<option value="+dropDownArray[i].iso_id+">"+dropDownArray[i].country_name+" ("+dropDownArray[i].iso_id+")</option>");
					$("#dropDownCountryTwo").append("<option value="+dropDownArray[i].iso_id+">"+dropDownArray[i].country_name+" ("+dropDownArray[i].iso_id+")</option>");
				    $("#dropDownCountryThree").append("<option value="+dropDownArray[i].iso_id+">"+dropDownArray[i].country_name+" ("+dropDownArray[i].iso_id+")</option>");
					$("#dropDownCountryFour").append("<option value="+dropDownArray[i].iso_id+">"+dropDownArray[i].country_name+" ("+dropDownArray[i].iso_id+")</option>");
				}
				
         	});
         });
         $(document).ready(function() {
             $("#countries-two").click(function(event){ // inserts the input boxes if 2 countries to compare are selected
				$( "#country-inputs" ).html( "<form id='countryForm' action='viewTwo.php'><table class='country-select'><tr><th class='country-select'><select name='dropDownCountryOne' id='dropDownCountryOne' required></select></th></tr><tr><th class='country-select'><select name='dropDownCountryTwo' id='dropDownCountryTwo' required></select></th></tr></table><input type='submit' align='left' id='submit' value='Submit'><br><br><br></form" );
                 $( "#countries-four" ).html("<p class='countries-choice'>Four</p>");
         		$( "#countries-two" ).html("<p class='countries-choice' style='color:#feb0b0;'>two</p>");
         	    var dropDownArray = <?php echo $dropDownResult ?>;
				$("#dropDownCountryOne").append ("<option disabled selected>Select A Country</option>");
			    $("#dropDownCountryTwo").append ("<option disabled selected>Select A Country</option>");
				console.log(dropDownArray);
				for(var i=0;i<dropDownArray.length;i++){
					$("#dropDownCountryOne").append("<option value="+dropDownArray[i].iso_id+">"+dropDownArray[i].country_name+" ("+dropDownArray[i].iso_id+")</option>");
					$("#dropDownCountryTwo").append("<option value="+dropDownArray[i].iso_id+">"+dropDownArray[i].country_name+" ("+dropDownArray[i].iso_id+")</option>");
				}
			});
		 });
      </script>
   </head>
   <body onload="window.scrollTo(0,0);">
      <!-- on refresh page starts at the top -->
      <div class="bgimg-1">
         <div class="caption">
            <!-- title and click border -->
            <p class="pageTitle">OLYMPIC CYCLING TEAMS</p>
            <span class="border" id="subTitle">CLICK TO COMPARE</span>
         </div>
      </div>
      <h2>number of Countries to compare</h2>
      <table class="countries-choice">
         <tr class="countries-choice">
            <!-- number of countries selected header -->
            <th class="countries-choice" id="countries-two">
               <p class="countries-choice"  style="color:#feb0b0;">two</p>
            </th>
            <th class="countries-choice" id="countries-four">
               <p class="countries-choice" >four</p>
               <p>
            </th>
         </tr>
      </table>
      <hr color="#111;" size="2" width="60%">
      <!-- horizontal bar -->
      <div class="country-select" id="country-inputs">
         <form id="countryForm" action="viewTwo.php" method='post'>
            <table class="country-select">
               <!-- country inputs -->
               <tr>
				  <th class="country-select"><select name="dropDownCountryOne" id="dropDownCountryOne" required></select></th>
               </tr>
               <tr>
                  <th class="country-select"><select name="dropDownCountryTwo" id="dropDownCountryTwo" required></select></th>
               </tr>
            </table>
            <!-- submit buttons -->
            <input type="submit" align="left" id="submit" value="Submit">
            <br><br><br>
         </form>
      </div>
   </body>
   <script>
    var dropDownArray = <?php echo $dropDownResult ?>;
    $("#dropDownCountryOne").append ("<option disabled selected>Select A Country</option>");
	$("#dropDownCountryTwo").append ("<option disabled selected>Select A Country</option>");
	console.log(dropDownArray);
	for(var i=0;i<dropDownArray.length;i++){
		$("#dropDownCountryOne").append("<option value="+dropDownArray[i].iso_id+">"+dropDownArray[i].country_name+" ("+dropDownArray[i].iso_id+")</option>");
		$("#dropDownCountryTwo").append("<option value="+dropDownArray[i].iso_id+">"+dropDownArray[i].country_name+" ("+dropDownArray[i].iso_id+")</option>");
	}
	</script>			
</html>

