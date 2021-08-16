<!DOCTYPE html>
<html>
   <!-- Simple Input Form With Submit Button -->
   <body style="font-family: 'Courier New', Courier, monospace">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
         <h3>MySQL Query Tester</h3>
         <B>Query:</B><br>
         <textarea name="querytext" rows="10" cols="100" style="margin-top: 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);"><?php echo $_POST["querytext"]; ?></textarea>
         <br><input type="submit" style="padding: 8px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
      </form>
      <?php
		 // Enter you MySQL details here and a default query if any--
         $host    = "localhost";
         $user    = "username";
         $pass    = "password";
         $db_name = "database name";
         $defaultQuery = "SELECT * FROM table_name LIMIT 5;"; // Replace 'table_name' with your table name, if it's a large table use SELECT * FROM demo LIMIT 100; to avoid issues!
		 
         //Create DB Connection--
         $connection = mysqli_connect($host, $user, $pass, $db_name);
         
         //Check if connection failed--
         if(mysqli_connect_errno()){
             die("connection failed: "
                 . mysqli_connect_error()
                 . " (" . mysqli_connect_errno()
                 . ")");
         }
         
         //Get Query from Form, Execute Query--
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
         	$querytext = $_POST['querytext'];
         }
         if (empty($querytext)) {
         	$querytext=$defaultQuery;
         }
         $result = mysqli_query($connection,$querytext);
         echo "<h4>".$querytext."</h4>";
         
         $all_property = array();
         
         //Show Table Column Names--
         echo '<table class="data-table" style="border-collapse: collapse; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                	<tr class="data-heading" style="background-color: #04AA6D;">'; 
         while ($property = mysqli_fetch_field($result)) {
             echo '<td style="border: thin solid black; padding: 8px;"><b>' . $property->name . '</b></td>';  
             array_push($all_property, $property->name); 
         }
         echo '</tr>'; 
         //Show Results Data--
         while ($row = mysqli_fetch_array($result)) {
             echo "<tr>";
             foreach ($all_property as $item) {
                	echo '<td style="border: thin solid black; padding: 8px;">' . $row[$item] . '</td>'; 
             }
             echo '</tr>';
         }
         echo "</table>";
         ?>
   </body>
</html>