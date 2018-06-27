<?php
session_start();
// The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "Board.xls"
header("Content-Disposition: attachment; filename=Board.xls");
 ?>
 <style>
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
	text-align: center;
	padding: 10px;
}
   </style>
<table style="font-size:16px; background-color:white">
	
<?php

	//CONNECT TO MYSQLDB
include_once('connect2.php');
    if (mysqli_connect_errno($conn))
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

if (!empty($_SESSION['sql_week'])) {
	$query="SELECT * FROM matchups_cache WHERE week LIKE '%".$_SESSION['sql_week']."%' ORDER BY name ASC";
	$query2='SELECT * FROM spreadlock WHERE week LIKE "%'.$_SESSION['sql_week'].'%";';  
} else {
	$query="SELECT * FROM matchups_cache WHERE week LIKE (SELECT MAX(week) FROM spreadlock) ORDER BY name ASC";
	$query2="SELECT * FROM spreadlock ORDER BY id DESC LIMIT 1; ";
}

$result= mysqli_query($conn, $query) or die("Invalid query");
$result2= mysqli_query($conn, $query2) or die("Invalid query");



// sets $data to an array of arrays? idk... but it is used next, twice.........better change the 'xgame' variable to auto increment.....BUT HOOOOOWWWWW????
$data = array('xid' => array(), 'xname' => array(), 'xgame1' => array(), 'xgame2' => array(), 'xgame3' => array(), 'xgame4' => array(), 'xgame5' => array(), 'xgame6' => array(), 'xgame7' => array(), 'xgame8' => array(), 'xgame9' => array(), 'xgame10' => array(), 'xgame11' => array(), 'xgame12' => array(), 'xgame13' => array());

//TTTTTTTTHIIIIIIISSS...this is the round 2 of the above
$data = array('xid' => array(), 'xname' => array(), 'xgame1' => array(), 'xgame2' => array(), 'xgame3' => array(), 'xgame4' => array(), 'xgame5' => array(), 'xgame6' => array(), 'xgame7' => array(), 'xgame8' => array(), 'xgame9' => array(), 'xgame10' => array(), 'xgame11' => array(), 'xgame12' => array(), 'xgame13' => array());


// sets $xdata to an array of arrays? idk...
$xdata = array('xid' => array(), 'xname' => array(), 'xgame1' => array(), 'xgame2' => array(), 'xgame3' => array(), 'xgame4' => array(), 'xgame5' => array(), 'xgame6' => array(), 'xgame7' => array(), 'xgame8' => array(), 'xgame9' => array(), 'xgame10' => array(), 'xgame11' => array(), 'xgame12' => array(), 'xgame13' => array());






$dataxgamenew = "";
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



// This get the first gray cell and then gets everyone's names

echo '<td align="left" style="text-align: left;"><div style="width: 200px;">'.$xxweek.'</div></td>';
foreach (array_combine($data['xid'], $data['xname']) as $xidx => $xnamex) {
	  printf('<td>

	<div class="col-xs-11" align="center"><b>'.$xnamex.'</b>
	</div></td>', htmlspecialchars($xnamex));

}

echo '</tr>';







//This gets all of the games from the web crawl and puts them in the table

for ($i = 1; $i <= 100; ++$i) {
	if (!empty(${"xxgame$i"}) && !empty(${"xxgame".($i).""})) {  //--if it's the last game on the list, echo tiebreaker
		echo '<tr><td style="text-align: left;">'.${"xxgame$i"}.'</td>';
			
			// This puts everyone's picks into the table
			if(!empty($data['xgame'.($i).''])) {
				foreach($data['xgame'.($i).''] as $n) {
					printf('<td>%s</td>', htmlspecialchars($n));
}
echo '</tr>';
} 

} else {
echo '<tr><td style="text-align: left;">'.$xxtiebreaker.'</td>';
	$i=101;
	if (!empty($data['xtiebreaker'])) {
	foreach($data['xtiebreaker'] as $n) {
					printf('<td>%s</td>', htmlspecialchars($n));
	}
}
echo "</tr>";
}
}






?>
	

</table>


<p style='font-size:16px; background-color:white'>
<td>*Stats pulled from FootballLocks.com - Last update: <?php include_once('getdate.php'); echo $newtime; ?> </td></p>
