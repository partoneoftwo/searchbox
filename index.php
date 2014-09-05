<html>
<body>
<head>
<style type="text/css">
<!--
@import url("style.css");
-->
</style>
<meta charset='utf-8'>
<form accept-charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
<center>
<input type="text" name="booksname" />
<input type="submit" value="Make it rain" />
<form accept-charset="utf-8">
</form>

</body>
</html>


<?php

// store some stuff in variables, it seems those home baked ones are easier to use in sql queries
// need to do this to avoid errors about empty variable index php trickery
$usersipaddress = $_SERVER['REMOTE_ADDR'];
$userauthenticatedwith = $_SERVER['PHP_AUTH_USER'];
$userauthenticatedwithpw = $_SERVER['PHP_AUTH_PW'];

$booksname = false;
if(isset($_GET['booksname'])){
        $booksname = ($_GET['booksname']);
} 


// disable all error messages 
error_reporting(E_ERROR | E_PARSE);

require('settings.php');

$con=mysqli_connect("$db_server","$db_user","$db_passwd","$db_name");
// Check connection
if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


/////////////// Runtime enforce UTF-8 ////////////////////////////////
mysqli_query ("set character_set_client='utf8'");
mysqli_query ("set character_set_results='utf8'");
mysqli_query ("set collation_connection='utf8_general_ci'");
mysqli_set_charset("UTF8");
  /* change character set to utf8 */
if (!$con->set_charset("utf8")) {
            printf("Error loading character set utf8: %s\n", $con->error);
} else {
//            printf("Current character set: %s\n", $con->character_set_name());
}




//echo htmlentities($row['name'], ENT_QUOTES, 'UTF-8'); // wip

//////////////////////////// execute the search query //////////////////////
// and subsequently display the results in a table

// get the search results
$result = mysqli_query($con,"SELECT * FROM books where filename rlike ('$booksname') ");


// user feedback and figure out the number of results
echo "<br>Searched for: $booksname\n\n";
$num_rows = mysqli_num_rows($result);
echo "<br>Search result: $num_rows hits\n\n";


// no more record number for now       <th scope=\"col\">magic number</th>

///////////////////////// INSERT FIRST TABLE /////////////////////////////

echo "<table id=\"hor-zebra\">
       <thead>
       <tr class=\"odd\">
       <th scope=\"col\">Search Results</th>
       </tr>";

while($row = mysqli_fetch_array($result)) {
      echo "<tr>";
      echo "<tr class=\"odd\">";
// no more record number for now      echo "<td>" . $row['ID'] . "</td>";
      echo "<td> <a href=\"books/" . $row['filename'] . " \"> " . htmlentities($row['filename']). " </a></td>";
      echo "</tr>";
}

echo "</table>";


/////////////// store the search query in the searchlog //////////////////////
$searchlog=mysqli_query($con, "INSERT INTO searchlog (searchword, usersipaddress, userauthenticatedwith, userauthenticatedwithpw, searchhits) VALUES ('$booksname', '$usersipaddress', '$userauthenticatedwith', '$userauthenticatedwithpw', '$num_rows' )");

// store the searchlog in an array
// this line is a work in progress query not done yet // $displaysearchlog=mysqli_query($con, "SELECT * FROM searchlog ORDER BY id DESC LIMIT 50 ORDER BY id ASC");
$displaysearchlog = mysqli_query($con,"(SELECT * FROM searchlog ORDER BY id DESC LIMIT 50) ORDER BY id DESC");



//////////////////// ANOTHER TABLE ////////////////////////
// display the search log

echo "<table id=\"hor-zebra\">
       <thead>
       <tr class=\"odd\">
       <th scope=\"col\">Latest searches</th>
       <th scope=\"col\">Hits</th>
       </tr>";

while($row = mysqli_fetch_array($displaysearchlog)) {
      echo "<tr>";
      echo "<tr class=\"odd\">";
      echo "<td> <a href=index.php?booksname=".$row['searchword']. "> " .$row['searchword']. " </a></td>";
      echo "<td>" . $row['searchhits'] . "</td>";						 
      echo "</tr>";
}

echo "</table>";


mysqli_close($con);
implode( array_values( get_html_translation_table( HTML_ENTITES ) ), "\t" )

?>






<a href="https://github.com/thomasfrivold/searchbox" >Powered by Searchbox - Developed by Thomas Frivold</a>