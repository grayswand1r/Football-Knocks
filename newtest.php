<?php
//Populate the table on newpool.php from `spreadlock` and `matchups`

//CONNECT TO MYSQLDB
include_once('connect2.php');
    if (mysqli_connect_errno($conn))
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

	 
	 
$query1="SELECT MAX(week)FROM spreadlock";
$resultin = mysqli_query($conn, $query1) or die("Invalid query");

$thewik = "";
while($row = mysqli_fetch_assoc($resultin)){
	$thewik = $row['MAX(week)'];
	
	}

//echo $thewik;	


$thisweek ='';


if (!empty($_SESSION['sql_week'])) {
	$query="SELECT * FROM matchups_cache WHERE week = '".$_SESSION['sql_week']."' ORDER BY name ASC";
	$query2='SELECT * FROM spreadlock WHERE week = "'.$_SESSION['sql_week'].'";';  
	$thisweek = $_SESSION['sql_week'];
} else {
	
	$query="SELECT * FROM matchups_cache WHERE week LIKE '%".$thewik."%'  ORDER BY name ASC";
	$query2="SELECT * FROM spreadlock ORDER BY id DESC LIMIT 1; ";
	$queryweek = "(SELECT MAX(week) FROM spreadlock)";
	$resultweek= mysqli_query($conn, $queryweek) or die("Invalid query");
	while($row = mysqli_fetch_assoc($resultweek)){
	$thisweek = $row['MAX(week)'];
	
	}
}



$result= mysqli_query($conn, $query) or die("Invalid query");
$result2= mysqli_query($conn, $query2) or die("Invalid query");


// sets $data to an array of arrays
$data = array('xid' => array(), 'xname' => array(), 'xgame1' => array(), 'xgame2' => array(), 'xgame3' => array(), 'xgame4' => array(), 'xgame5' => array(), 'xgame6' => array(), 'xgame7' => array(), 'xgame8' => array(), 'xgame9' => array(), 'xgame10' => array(), 'xgame11' => array(), 'xgame12' => array(), 'xgame13' => array(), 'xgame14' => array(), 'xgame15' => array());


// sets $xdata to an array of arrays
$xdata = array('xid' => array(), 'xname' => array(), 'xgame1' => array(), 'xgame2' => array(), 'xgame3' => array(), 'xgame4' => array(), 'xgame5' => array(), 'xgame6' => array(), 'xgame7' => array(), 'xgame8' => array(), 'xgame9' => array(), 'xgame10' => array(), 'xgame11' => array(), 'xgame12' => array(), 'xgame13' => array(), 'xgame14' => array(), 'xgame15' => array());




// THIS means that $data[] = the mysql `matchups` query by row
while($row = mysqli_fetch_assoc($result)){
  $data['xid'][] = $row['id'];
  $data['xname'][] = $row['name'];
  $data['xgame1'][] = $row['game1'];
  $data['xgame2'][] = $row['game2'];
  $data['xgame3'][] = $row['game3'];
  $data['xgame4'][] = $row['game4'];
  $data['xgame5'][] = $row['game5'];
  $data['xgame6'][] = $row['game6'];
  $data['xgame7'][] = $row['game7'];
  $data['xgame8'][] = $row['game8'];
  $data['xgame9'][] = $row['game9'];
  $data['xgame10'][] = $row['game10'];
  $data['xgame11'][] = $row['game11'];
  $data['xgame12'][] = $row['game12'];
  $data['xgame13'][] = $row['game13'];
  $data['xgame14'][] = $row['game14'];
  $data['xgame15'][] = $row['game15'];
  $data['xtiebreaker'][] = $row['tiebreaker'];

}


// THIS means that $ = the mysql `spreadlock` query by row
while($row = mysqli_fetch_assoc($result2)){
  $xxid = $row['id'];
  $xxname = $row['name'];
  $xxgame1 = $row['game1'];
  $xxgame2 = $row['game2'];
  $xxgame3 = $row['game3'];
  $xxgame4 = $row['game4'];
  $xxgame5 = $row['game5'];
  $xxgame6 = $row['game6'];
  $xxgame7 = $row['game7'];
  $xxgame8 = $row['game8'];
  $xxgame9 = $row['game9'];
  $xxgame10 = $row['game10'];
  $xxgame11 = $row['game11'];
  $xxgame12 = $row['game12'];
  $xxgame13 = $row['game13'];
  $xxgame14 = $row['game14'];
  $xxgame15 = $row['game15'];
  $xxtiebreaker = $row['tiebreaker'];
  $xxdate = $row['date'];
  $xxweek = $row['week'];


}






?>