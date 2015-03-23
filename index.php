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

<center>
<a href=/library ><img src=bfolder.png></a>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
<center>
<input type="text" name="booksname" />
<input type="submit" value="Make it rain" />
<form accept-charset="utf-8">
</form>


</body>
</html>


<?php


ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

// store some stuff in variables, it seems those home baked ones are easier to use in sql queries
// need to do this to avoid errors about empty variable index php trickery
$usersipaddress = $_SERVER['REMOTE_ADDR'];
$usersauthenticatewith = $_SERVER['PHP_AUTH_USER'];
$usersauthenticatewithpw = $_SERVER['PHP_AUTH_PW'];

$booksname = false;
if(isset($_GET['booksname'])){
        $booksname = ($_GET['booksname']);
} 



require('settings.php');

$con=pg_connect("host=$db_server dbname=$db_name user=$db_user password=$db_passwd");

//////////////////////////// execute the search query //////////////////////
// and subsequently display the results in a table

if (empty($booksname)) {
        echo "<center>";
        die("Welcome $usersauthenticatewith. \n
	      Enter a bookname, author's last name or topic and hit return.");
        echo "</center>";
}

// get the search results
// coming soon here - trigrams and tuples. Watch this space
// this method is not secure - and is succeptible to sql injections. only use this app with trusted users
// behind password protected areas folks!
// could be written with pdo or with prepared statement
$result = pg_query("SELECT * FROM books where filename  ~*('$booksname')");


// user feedback and figure out the number of results
echo "<br>Searched for: $booksname\n\n";
$num_rows = pg_num_rows($result);
echo "<br>Search result: $num_rows hits\n\n";


// no more record number for now       <th scope=\"col\">magic number</th>

///////////////////////// INSERT FIRST TABLE ON THE PAGE - MAIN POINT - THE SEARCH RESULTS /////////////////////////////

echo "<table id=\"hor-zebra\">
       <thead>
       <tr class=\"odd\">
       <th scope=\"col\">Search Results</th>
       </tr>";

while($row = pg_fetch_assoc($result)) {
      echo "<tr>";
      echo "<tr class=\"odd\">";
//      echo "<td>" . $row['ID'] . "</td>";
      echo "<td> <a href=\"books/" . $row['filename'] . " \"> " . htmlentities($row['filename']). " </a></td>";
      echo "</tr>";
}

echo "</table>";



/////////////// store the search query in the searchlog //////////////////////
$searchlog=pg_query("INSERT INTO searchlog (searchword, usersipaddress, usersauthenticatewith, usersauthenticatewithpw, searchhits) VALUES ('$booksname', '$usersipaddress', '$usersauthenticatewith', '$usersauthenticatewithpw', '$num_rows' )");


// retrieve the searchlog and store it in an array
// this line is a work in progress query not done yet // $displaysearchlog=pg_query($con, "SELECT * FROM searchlog ORDER BY id DESC LIMIT 50 ORDER BY id ASC");
$displaysearchlog = pg_query("SELECT * FROM searchlog order by timeofsearch DESC");
// $displaysearchlog = pg_query("SELECT * FROM searchlog ORDER BY id DESC LIMIT 50) ORDER BY id DESC");



//////////////////// ANOTHER TABLE ////////////////////////
// display the search log on the page

echo "<table id=\"hor-zebra\">
       <thead>
       <tr class=\"odd\">
       <th scope=\"col\">Latest searches</th>
       <th scope=\"col\">Hits</th>
       </tr>";

while($row = pg_fetch_assoc($displaysearchlog)) {
      echo "<tr>";
      echo "<tr class=\"odd\">";
      echo "<td> <a href=index.php?booksname=" .htmlentities($row['searchword']). " > ".  htmlentities($row['searchword']). " </a></td>";
      echo "<td>" . $row['searchhits'] . "</td>";						 
      echo "</tr>";
}

echo "</table>";



  
?>






<a href="https://github.com/thomasfrivold/searchbox" >Powered by Searchbox - Developed by Thomas Frivold</a>