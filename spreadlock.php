<?php
// Redirection to the success page
header("Location: pool.php?search_week=".$week."&search=Search"); 

include_once('getgames.php');

// Connect to mysql	
	include_once('connect2.php');
		if(!$conn) {
			die('Problem in database connection: ' . mysql_error());
}

// Data insertion into database

$sqlgame = ''; //This will be a string that looks like "`game1`, `game2`, `game3`, `game4`, etc" to mimic the spreadlock table columns
$newtiebreaker = '';

for ($i = 1; $i <= 100; ++$i) {
	if (!empty($dataxgame[$i]) && !empty($dataxgame[($i+1)])) {
		$sqlgame .= '`game'.$i.'`, ';
	} else {
		$i =101;
	}
}


//echo $sqlgame;
//echo "<hr>";
//echo rtrim($game, ", ");
//echo "<hr>";


// The next few lines are needed to UPDATE the spreadlock table if the week already exists
$arr1 = explode(', ', $sqlgame);
$arr2 = explode(', ', rtrim($game, ", "));
$arr3 = array_combine($arr1, $arr2);
$newstring = '';

foreach ($arr3 as $k => $v) {
	if (!empty($k) && !empty($v)){
	$newstring .= $k."=".$v.", ";
	} else {
		$newstring .= "`tiebreaker`=".$v;
	}
}

//echo $newstring;
//echo "<hr>";

//print_r($arr1);
//echo "<hr>";
//print_r($arr2);
//echo "<hr>";
//print_r($arr3);


//echo $week;
//echo "<hr>";


$result = mysql_query("SELECT * FROM `spreadlock` WHERE `week` LIKE '".$week."'");

if(!mysql_num_rows($result))
{
    $query2 = "INSERT INTO `spreadlock` (".$sqlgame." `tiebreaker`, week)
	VALUES
	(".rtrim($game, ", ").", '".$week."');"; // Had to add rtrim to delete the last ", " that comes after the tiebreaker in the mysql query
	mysqli_query($conn, $query2);
	//echo $query2;
}
else
{
     $query = "UPDATE `spreadlock` SET ".$newstring." WHERE week LIKE '".$week."';"; 
	mysqli_query($conn, $query);
	//echo $query;
}




for ($w = 1; $w <= 15; ++$w) {
	$sql90 = "UPDATE `spreadlock` SET `game$w` = replace(`game$w`, 'PK', '-0');";
	mysqli_query($conn, $sql90);
	
}



?>
<!DOCTYPE html>
<html>
	  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Football Pool 2016-17</title>

    <!-- Bootstrap core CSS -->
	
    <link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous" type="text/css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" type="text/css">
  </head>
  <body>
  
  <script>
 
var wik = '<?php echo $week; ?>';
 
  
    window.location.replace("http://10.0.0.166/dashboard/newpool.php?search_week="+wik+"&search=Search");
</script>

  </body>
  
  
  