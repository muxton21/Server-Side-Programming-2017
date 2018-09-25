<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8"/>
      <title>Task 4</title>
      <link rel="stylesheet" type="text/css" href="view.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script>
	  //scrols down page when subTitle is clicked
         $(document).ready(function() {
             $("#subTitlePHP").click(function(event){
                 $('html, body').animate({scrollTop: $(".back").offset().top},1600);	//animation for fade in efffect
             });
         });
     </script>
   </head>
   <!-- starts page half way down for consistancy-->
   <body onload="window.scrollTo(0,900);">
      <!-- top cyclist image -->
      <div class="bgimg-1">
         <div class="captionPHP">
            <p class="pageTitlePHP">OLYMPIC CYCLING TEAMS</p>
            <span class="borderPHP" id="subTitlePHP">CLICK TO COMPARE</span>
         </div>
      </div>
      <!-- number of cyclists to compare header, selected number is pink -->
      <h2 id="title">number of Countries to compare</h2>
      <table class="countries-choice">
         <tr class="countries-choice">
            <th class="countries-choice">
               <p class="countries-choice">two</p>
            </th>
            <th class="countries-choice">
               <p class="countries-choice" style="color:#feb0b0;" id="countries-four">four
               <p>
            </th>
         </tr>
      </table>
      <!-- horizontal line -->
      <hr color="#111;" size="2" width="65%">
      <div class="country-display">
         <table align="center" class="country-display">
            <?php
               $country_one = $_REQUEST['dropDownCountryOne']; //gets the ISO_id entered for country one
               $country_two = $_REQUEST['dropDownCountryTwo']; //gets the ISO_id entered for country two
               $country_three = $_REQUEST['dropDownCountryThree']; //gets the ISO_id entered for country three
               $country_four = $_REQUEST['dropDownCountryFour']; //gets the ISO_id entered for country four
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
               $sql1="SELECT * FROM `Country` WHERE `ISO_id` LIKE '%$country_one%'";
               $sql2="SELECT * FROM `Country` WHERE `ISO_id` LIKE '%$country_two%'";
               $sql3="SELECT Cyclist.name FROM Country JOIN Cyclist ON Country.ISO_id=Cyclist.ISO_id WHERE Country.ISO_id LIKE '%$country_one%'";
               $sql4="SELECT Cyclist.name FROM Country JOIN Cyclist ON Country.ISO_id=Cyclist.ISO_id WHERE Country.ISO_id LIKE '%$country_two%'";
               //countries 3 and 4
               $sql5="SELECT * FROM `Country` WHERE `ISO_id` LIKE '%$country_three%'";
               $sql6="SELECT * FROM `Country` WHERE `ISO_id` LIKE '%$country_four%'";
               $sql7="SELECT Cyclist.name FROM Country JOIN Cyclist ON Country.ISO_id=Cyclist.ISO_id WHERE Country.ISO_id LIKE '%$country_three%'";
               $sql8="SELECT Cyclist.name FROM Country JOIN Cyclist ON Country.ISO_id=Cyclist.ISO_id WHERE Country.ISO_id LIKE '%$country_four%'";
               
               
               //countries 1 and 2
               $res1=& $db->query($sql1);
               $res2=& $db->query($sql2);
               //$res3=& $db->query($sql3);
               $res3=& $db->query($sql3);
               $res4=& $db->query($sql4);
               
               //countries 3 and 4
               $res5=& $db->query($sql5);
               $res6=& $db->query($sql6);
               //$res3=& $db->query($sql3);
               $res7=& $db->query($sql7);
               $res8=& $db->query($sql8);
               if(PEAR::isError($res1)){
                   die($res1->getMessage());
               }
               if(PEAR::isError($res2)){
                   die($res2->getMessage());
               }
               
               //creates the results tables headings
               echo '<tr>';
               echo '<th><h4>Country</h4></th>';
               echo '<th><h4>Gold</h4></th>';
               echo '<th><h4>Silver</h4></th>';
               echo '<th><h4>Bronze</h4></th>';
               echo '<th><h4>Total</h4></th>';
               echo '<th><h4>G.D.P</h4></th>';
               echo '<th><h4>Population</h4></th>';
               echo '</tr>';
               // displays relevent information (e.g. country_name, gold, silver, bronze ) using fetchRow 
               //countries 1 and 2
			   
			   while ($row0 = $res1->fetchRow()) {
				$rows0[] = $row0;
			   }
			   
			   
               while ($row1 = $res2->fetchRow()) {
               	$rows1[] = $row1;
               }
               
               //countries 3 and 4
               while ($row4 = $res5->fetchRow()) {
               	$rows4[] = $row4;
               }
               while ($row5 = $res6->fetchRow()) {
               	$rows5[] = $row5;
               }
               //json encode the SQL outputs
               //countries 1 and 2
               $jsonResult0 = json_encode($rows0);
               $jsonResult1 = json_encode($rows1);
               $jsonResult2 = json_encode($res3->fetchAll());
               $jsonResult3 = json_encode($res4->fetchAll());
               
               //countries 3 and 4
               $jsonResult4 = json_encode($rows4);
               $jsonResult5 = json_encode($rows5);
               $jsonResult6 = json_encode($res7->fetchAll());
               $jsonResult7 = json_encode($res8->fetchAll());
               
               
               
               ?>
            <!-- country medal results, gdp and population outputs -->
            <tr id="countryOne"></tr>
            <tr id="countryTwo"></tr>
            <tr id="countryThree"></tr>
            <tr id="countryFour"></tr>
            <tr>
               <th colspan="7" id="comparison"></th>
            </tr>
            <!-- names output tables -->
            <tr id="cyclists" valign="top">
               <th></th>
               <!-- country one cyclists list -->
               <th colspan='2'>
                  <table class="cyclistList" id="cyclistsListOne" align="center">
                     <tr>
                        <th id="cyclistsCountryOne" align='center' valign="top"></th>
                     </tr>
                  </table>
               </th>
               <!-- country two cyclists list -->
               <th>
                  <table class="cyclistList" id="cyclistsListTwo" align="center">
                     <tr>
                        <th id="cyclistsCountryTwo" align='center' valign="top"></th>
                     </tr>
                  </table>
               </th>
               <!-- country three cyclists list -->
               <th>
                  <table class="cyclistList" id="cyclistsListThree" align="center">
                     <tr>
                        <th id="cyclistsCountryThree" align='center' valign="top"></th>
                     </tr>
                  </table>
               </th>
               <!-- country four cyclists list -->
               <th colspan='2'>
                  <table class="cyclistList" id="cyclistsListFour" align="center">
                     <tr>
                        <th id="cyclistsCountryFour" align='center' valign="top"></th>
                     </tr>
                  </table>
               </th>
            </tr>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
            <script type="text/javascript">
               //countries 1 and 2
               // calculates the difference between two countries medals 
               function differenceCalculation(x,y){
               if((x && y)==0)return 0; 
			   if(x>y){
               var result =x-y;
               return result;
               }
               else{
               var result =y-x;
               return result;
               }
               }
               //calculates which country has the highest gdp via bubble sort
               function highestGDP(a,b,c,d){
               var gdpArray = [a, b, c, d];
                function bubbleSort(theArray) {
                var i, j;
                for (i = theArray.length - 1; i >= 0; i--) {
                    for (j = 0; j <= i; j++) {
                        if (theArray[j + 1] < theArray[j]) {
                            var temp = theArray[j];
                            theArray[j] = theArray[j + 1];
                            theArray[j + 1] = temp;
                        }
                    }
                }
                return theArray;
               }
               return bubbleSort(gdpArray[0]);
               }
               
               var arrayOne='<?php echo $jsonResult0?>';  // php write into javascript, as jsontext
               var arrayTwo='<?php echo $jsonResult1?>';  // php write into javascript, as jsontext
               var arrayThree='<?php echo $jsonResult2?>';  // php write into javascript, as jsontext
               var arrayFour='<?php echo $jsonResult3?>';  // php write into javascript, as jsontext
               console.log(arrayThree);
               console.log(arrayFour);
               //countries 3 and 4
               var arrayFive='<?php echo $jsonResult4?>';  // php write into javascript, as jsontext
               var arraySix='<?php echo $jsonResult5?>';  // php write into javascript, as jsontext
               var arraySeven='<?php echo $jsonResult6?>';  // php write into javascript, as jsontext
               var arrayEight='<?php echo $jsonResult7?>';  // php write into javascript, as jsontext
               console.log(arraySeven);
               console.log(arrayEight);
               //countries 1 and 2
               var obj = JSON.parse(arrayOne);
               var obj1 = JSON.parse(arrayTwo);
               var obj2 = JSON.parse(arrayThree);
               var obj3 = JSON.parse(arrayFour);
               //countries 3 and 4
               var obj4 = JSON.parse(arrayFive);
               var obj5 = JSON.parse(arraySix);
               var obj6 = JSON.parse(arraySeven);
               var obj7 = JSON.parse(arrayEight);
               //countries 1 and 2 (this main section)
               $(document).ready(function(){ 
                   // displays country_name, medal total, number of each type of medal, gdp and population of country 1 as well as 3 comparasions 
               for(field in obj) {
               $("#countryOne").append( "<th><h5>" + obj[field].country_name +"</h5></th>" ); 
               $("#countryOne").append( "<th><h5>" + obj[field].gold +"</h5></th>" ); 
               $("#countryOne").append( "<th><h5>" + obj[field].silver +"</h5></th>" );
               $("#countryOne").append( "<th><h5>" + obj[field].bronze +"</h5></th>" ); 
               $("#countryOne").append( "<th><h5>" + obj[field].total +"</h5></th>" ); 
               $("#countryOne").append( "<th><h5>" + obj[field].gdp +"</h5></th>" ); 
               $("#countryOne").append( "<th><h5>" + obj[field].population +"</h5></th>" );
               $("#cyclistsCountryOne").append( "<h3 align='center'>" + obj[field].country_name +" Cyclists</h3>" );			
               }
               
               });
               // displays country_name, medal total, number of each type of medal, gdp and population of country 2
               $(document).ready(function(){ 
               for(field in obj1) {
               $("#countryTwo").append( "<th><h5>" + obj1[field].country_name +"</h5></th>" ); 
               $("#countryTwo").append( "<th><h5>" + obj1[field].gold +"</h5></th>" ); 
               $("#countryTwo").append( "<th><h5>" + obj1[field].silver +"</h5></th>" );
               $("#countryTwo").append( "<th><h5>" + obj1[field].bronze +"</h5></th>" ); 
               $("#countryTwo").append( "<th><h5>" + obj1[field].total +"</h5></th>" ); 
               $("#countryTwo").append( "<th><h5>" + obj1[field].gdp +"</h5></th>" ); 
               $("#countryTwo").append( "<th><h5>" + obj1[field].population +"</h5></th>" );
               $("#cyclistsCountryTwo").append( "<h3 align='center'>" + obj1[field].country_name +" Cyclists</h3>" ); 			
               }
               
               });
               //adds cyclist names of country one
               $(document).ready(function(){ 
               for(field in obj2) {
               $("#cyclistsListOne").append("<tr><td align='center'>" + obj2[field].name +"</td></tr>" );		
               }
               });
               //adds cyclist names of country 2 
               $(document).ready(function(){  
               for(field in obj3) {
               $("#cyclistsListTwo").append("<tr><td align='center'>"+obj3[field].name+"</td></tr>");		
               }
               });
               //countries 3 and 4 (this main section)
               // displays country_name, medal total, number of each type of medal, gdp and population of country 3 
               $(document).ready(function(){ 
               for(field in obj4) {
               $("#countryThree").append( "<th><h5>" + obj4[field].country_name +"</h5></th>" ); 
               $("#countryThree").append( "<th><h5>" + obj4[field].gold +"</h5></th>" ); 
               $("#countryThree").append( "<th><h5>" + obj4[field].silver +"</h5></th>" );
               $("#countryThree").append( "<th><h5>" + obj4[field].bronze +"</h5></th>" ); 
               $("#countryThree").append( "<th><h5>" + obj4[field].total +"</h5></th>" ); 
               $("#countryThree").append( "<th><h5>" + obj4[field].gdp +"</h5></th>" ); 
               $("#countryThree").append( "<th><h5>" + obj4[field].population +"</h5></th>" );
               $("#cyclistsCountryThree").append( "<h3 align='center'>" + obj4[field].country_name +" Cyclists</h3>" );			
               }
               
               });
               // displays country_name, medal total, number of each type of medal, gdp and population of country 4
               $(document).ready(function(){ 
               // parse() method parses a jsontext string back to JSON array,
               // https://msdn.microsoft.com/library/cc836466%28v=vs.94%29.aspx 
                   //Task3: display iso_id, medal total and cyclist name of these countries at #stub2 using $().append(...) 
               for(field in obj5) {
               $("#countryFour").append( "<th><h5>" + obj5[field].country_name +"</h5></th>" ); 
               $("#countryFour").append( "<th><h5>" + obj5[field].gold +"</h5></th>" ); 
               $("#countryFour").append( "<th><h5>" + obj5[field].silver +"</h5></th>" );
               $("#countryFour").append( "<th><h5>" + obj5[field].bronze +"</h5></th>" ); 
               $("#countryFour").append( "<th><h5>" + obj5[field].total +"</h5></th>" ); 
               $("#countryFour").append( "<th><h5>" + obj5[field].gdp +"</h5></th>" ); 
               $("#countryFour").append( "<th><h5>" + obj5[field].population +"</h5></th>" );
               $("#cyclistsCountryFour").append( "<h3 align='center'>" + obj5[field].country_name +" Cyclists</h3>" ); 			
               }
               
               });
               $(document).ready(function(){ 
               // adds cyclist names from country 3 to table
               for(field in obj6) {
               $("#cyclistsListThree").append("<tr><td align='center'>" + obj6[field].name +"</td></tr>" );		
               }
               });
               $(document).ready(function(){ 
               // adds cyclist names from country 4 to table
               for(field in obj7) {
               $("#cyclistsListFour").append("<tr><td align='center'>"+obj7[field].name+"</td></tr>");		
               }
               });
            </script>
         </table>
         <br>
         <br>
         <!-- back to main page button -->
         <form action="view.php">
            <input type="submit" class="back" value="Start Over"  width="100%"/>
         </form>
         <br>
         <br>
         <br>
      </div>
      </div>
   </body>
</html>
