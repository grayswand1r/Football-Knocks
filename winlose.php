<?php
session_start();
?>

<html>
	  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Scoreboard</title>

    <!-- Bootstrap core CSS -->
    <link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous" type="text/css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link href="animate.css" rel="stylesheet">
  <style>
  
.item {
	-webkit-animation-duration: 3s;
    -moz-animation-duration: 3s;

} 
table {
	font-size:16px; 
	background-color:white;
	border-collapse:separate;
}

td {
	border-style: solid; 
	margin: 2px;
	text-align: center;
	padding: 10px;
	border-collapse:separate;
	border-width: 1px; 
	border-color: rgb(132, 132, 132); 

}
body {
background-color:#EDF1FA; 
-moz-transform: scale(1); 
transform-origin: top left;
zoom: 67%;
}
img {
	
}
   </style>
   </head>
   
   
   
<!-- START: body -->   
<body>

<!-- START: web crawl to get scores from nfl.com -->   
 <?php
include_once('getgames.php');
    

//If $_SESSION['sql_week'] is not empty, select the scores from that week of nfl.com
if (!empty($_SESSION['sql_week'])) {  
	$Url = 'http://www.nfl.com/scores/2017/REG'.$_SESSION['sql_week'];

	
} else { //Else get the latest scores from nfl.com
	$Url = 'http://www.nfl.com/scores';
}
	
	//Tell it where to start scraping
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
	$start = strpos($output, '<div class="scorebox-wrapper">');
	$end = strpos($output, '<div class="mboxDefault"></div', $start);
	//echo htmlspecialchars($output);
	//echo "<hr>";
	$length = $end-$start;
	$output = substr($output, $start, $length);
	$output = strval($output);
	//echo htmlspecialchars($output);
	$nflgames = explode('<div class="new-score-box">', $output);
	$xnflgames = array();
for ($i = 0; $i <= 100; ++$i) {
	if (!empty($nflgames[$i])) {
		array_push($xnflgames, explode('<p', $nflgames[$i]));
	}
}


//echo "<hr>";
//print_r($nflgames);
//echo "<hr>";

//print_r($xnflgames);


//echo $xnflgames[1][2].' '.$xnflgames[1][3];


$finalscores = "";
for ($i = 0; $i <= 100; ++$i) {
	if (!empty($xnflgames[$i]) && !empty($xnflgames[$i][2]) && !empty($xnflgames[$i][3])) {
		$finalscores .= $xnflgames[$i][2].' '.$xnflgames[$i][3];
	} if (!empty($xnflgames[$i]) && !empty($xnflgames[$i][6]) && !empty($xnflgames[$i][7])) {
		$finalscores .= $xnflgames[$i][6].' '.$xnflgames[$i][7];
	} 
}
	



//echo "scores: ".$finalscores;
	
$re1 = '/raiders|titans|texans|patriots|cardinals|bills|redskins|giants|browns|dolphins|ravens|jaguars|lions|packers|broncos|bengals|vikings|panthers|
|buccaneers|jets|rams|chiefs|chargers|colts|bears|cowboys|falcons|saints|49ers|seahawks|steelers|eagles|--|[0-9]{1,2}/';

$re2 = 'raiders titans texans patriots cardinals bills redskins giants browns dolphins ravens jaguars lions packers broncos bengals vikings panthers rams buccaneers jets chiefs chargers colts bears cowboys falcons saints 49ers seahawks steelers eagles ';
preg_match_all($re1, strtolower($finalscores), $morescores);





// Set key value pairs for team (ex. $morescores[0][3]) and score (ex. $morescores[0][4])
$arr = array();

for ($i = 0; $i <= 300; ++$i) {
	if (!empty($morescores[0][$i])) {
	if (strpos($re2, $morescores[0][$i]) !== false) {
		$arr[$morescores[0][$i]] = $morescores[0][($i+3)];
	} 
}
}

//print_r($morescores);
//echo "<hr>";
//print_r($arr); //THIS should look something like this: Array ( [chiefs] => 42 [patriots] => 27 [steelers] => 21 [browns] => 18 [cardinals] => 23 [lions] => 35 [jaguars] => 29 [texans] => 7 [raiders] => 26 [titans] => 16 [eagles] => 30 [redskins] => 17 [ravens] => 20 [bengals] => 0 [falcons] => 23 [bears] => 17 [jets] => 12 [bills] => 21 [colts] => 9 [9] => [rams] => 46 [seahawks] => 9 [packers] => 17 [panthers] => 23 [49ers] => 3 [giants] => 3 [cowboys] => 19 [saints] => 19 [vikings] => 29 [chargers] => 21 [broncos] => 24 )
	
	//CONNECT TO MYSQLDB
include_once('connect2.php');
    if (mysqli_connect_errno($conn))
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

	  
	  
if (!empty($_SESSION['sql_week'])) {
	$query="SELECT * FROM matchups_cache WHERE week = '".$_SESSION['sql_week']."' ORDER BY name ASC";
	$query2='SELECT * FROM spreadlock WHERE week = "'.$_SESSION['sql_week'].'";';  
} else {
	$query="SELECT * FROM matchups_cache WHERE week LIKE (SELECT MAX(week) FROM spreadlock) ORDER BY name ASC";
	$query2="SELECT * FROM spreadlock ORDER BY id DESC LIMIT 1; ";
}

$result= mysqli_query($conn, $query) or die("Invalid query");
$result2= mysqli_query($conn, $query2) or die("Invalid query");


// sets $data to an array of arrays...i forget why...

$data = array('xid' => array(), 'xname' => array(), 'xgame1' => array(), 'xgame2' => array(), 'xgame3' => array(), 'xgame4' => array(), 'xgame5' => array(), 'xgame6' => array(), 'xgame7' => array(), 'xgame8' => array(), 'xgame9' => array(), 'xgame10' => array(), 'xgame11' => array(), 'xgame12' => array(), 'xgame13' => array(), 'xgame14' => array(), 'xgame15' => array(), 'xtiebreaker' => array());


// sets $xdata to an array of arrays? idk...
$xdata = array('xid' => array(), 'xname' => array(), 'xgame1' => array(), 'xgame2' => array(), 'xgame3' => array(), 'xgame4' => array(), 'xgame5' => array(), 'xgame6' => array(), 'xgame7' => array(), 'xgame8' => array(), 'xgame9' => array(), 'xgame10' => array(), 'xgame11' => array(), 'xgame12' => array(), 'xgame13' => array(), 'xgame14' => array(), 'xgame15' => array(), 'xtiebreaker' => array());




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

}





// Change $arr[$key] from mascot to city...has to be a better way

foreach ($arr as $k => $v) {
	if ($k == 'ravens') {$arr['baltimore'] = $arr['ravens'];
unset($arr['ravens']);} elseif
	
($k =='bills') {$arr['buffalo'] = $arr['bills'];
unset($arr['bills']);} elseif
	
($k =='bengals') {$arr['cincinnati'] = $arr['bengals'];
unset($arr['bengals']);} elseif
	
($k =='browns') {$arr['cleveland'] = $arr['browns'];
unset($arr['browns']);} elseif
	
($k =='broncos') {$arr['denver'] = $arr['broncos'];
unset($arr['broncos']);} elseif
	
($k =='texans') {$arr['houston'] = $arr['texans'];
unset($arr['texans']);} elseif
	
($k =='colts') {$arr['indianapolis'] = $arr['colts'];
unset($arr['colts']);} elseif
	
($k =='jaguars') {$arr['jacksonville'] = $arr['jaguars'];
unset($arr['jaguars']);} elseif
	
($k =='chiefs') {$arr['kansas city'] = $arr['chiefs'];
unset($arr['chiefs']);} elseif
	
($k =='dolphins') {$arr['miami'] = $arr['dolphins'];
unset($arr['dolphins']);} elseif
	
($k =='patriots') {$arr['new england'] = $arr['patriots'];
unset($arr['patriots']);} elseif
	
($k =='jets') {$arr['ny jets'] = $arr['jets'];
unset($arr['jets']);} elseif
	
($k =='raiders') {$arr['oakland'] = $arr['raiders'];
unset($arr['raiders']);} elseif
	
($k =='steelers') {$arr['pittsburgh'] = $arr['steelers'];
unset($arr['steelers']);} elseif
	
($k =='chargers') {$arr['la chargers'] = $arr['chargers'];
unset($arr['chargers']);} elseif
	
($k =='titans') {$arr['tennessee'] = $arr['titans'];
unset($arr['titans']);} elseif
	
($k =='cardinals') {$arr['arizona'] = $arr['cardinals'];
unset($arr['cardinals']);} elseif
	
($k =='falcons') {$arr['atlanta'] = $arr['falcons'];
unset($arr['falcons']);} elseif
	
($k =='panthers') {$arr['carolina'] = $arr['panthers'];
unset($arr['panthers']);} elseif
	
($k =='bears') {$arr['chicago'] = $arr['bears'];
unset($arr['bears']);} elseif
	
($k =='cowboys') {$arr['dallas'] = $arr['cowboys'];
unset($arr['cowboys']);} elseif
	
($k =='lions') {$arr['detroit'] = $arr['lions'];
unset($arr['lions']);} elseif
	
($k =='packers') {$arr['green bay'] = $arr['packers'];
unset($arr['packers']);} elseif
	
($k =='rams') {$arr['la rams'] = $arr['rams'];
unset($arr['rams']);} elseif
	
($k =='vikings') {$arr['minnesota'] = $arr['vikings'];
unset($arr['vikings']);} elseif
	
($k =='saints') {$arr['new orleans'] = $arr['saints'];
unset($arr['saints']);} elseif
	
($k =='giants') {$arr['ny giants'] = $arr['giants'];
unset($arr['giants']);} elseif
	
($k =='eagles') {$arr['philadelphia'] = $arr['eagles'];
unset($arr['eagles']);} elseif
	
($k =='49ers') {$arr['san francisco'] = $arr['49ers'];
unset($arr['49ers']);} elseif
	
($k =='seahawks') {$arr['seattle'] = $arr['seahawks'];
unset($arr['seahawks']);} elseif

($k =='buccaneers') {$arr['tampa bay'] = $arr['buccaneers'];
unset($arr['buccaneers']);} elseif
	
($k =='redskins') {$arr['washington'] = $arr['redskins'];
unset($arr['redskins']);}}

$keep = ["carolina"=>0, "denver"=>0, "atlanta"=>0, "tampa bay"=>0, "minnesota"=>0, "tennessee"=>0, "philadelphia"=>0, "cleveland"=>0, "cincinnati"=>0, "ny jets"=>0, "new orleans"=>0, "oakland"=>0, "kansas city"=>0, "la chargers"=>0, "baltimore"=>0, "buffalo"=>0, "houston"=>0, "chicago"=>0, "green bay"=>0, "jacksonville"=>0, "seattle"=>0, "miami"=>0, "dallas"=>0, "ny giants"=>0, "indianapolis"=>0, "detroit"=>0, "arizona"=>0, "new england"=>0, "pittsburgh"=>0, "washington"=>0, "la rams"=>0, "san francisco"=>0];


// This trims the array ($arr) to include ONLY the keys in $keep
$arr3=(array_intersect_key($keep, $arr));
$arr=(array_intersect_key($arr, $arr3));				

//Determine the winners referencing the spreadlock table
//print_r($arr);

$foo ="";
$bar = 0;
$foo2 ="";
$bar2 = 0;
$splitgame = array();
$splitgame_tb = array();

$spread = 0;
$winner = "";
$loser = "";
$pending = "";
foreach ($arr as $key => $value) {
	for ($i=1; $i<=15; $i++) {
		$splitgame = explode('/ ', ${"xxgame$i"});
		$splitgame_tb = explode('/ ', $xxtiebreaker);

		$str = $splitgame[0];
		$str_tb = $splitgame_tb[0];

		preg_match_all('!\d+!', $str, $matchers);
		
		if (!empty(${"xxgame$i"}) && strpos(mb_strtolower($splitgame[0]), mb_strtolower($key)) !== false){
			$foo = $key;
			$bar = $value;
			$bar2 = $arr[mb_strtolower($splitgame[1])];
			if ($bar !== "--") {
				
			if (($bar-$matchers[0][0])>$bar2) {
			//echo $foo."(".$bar.")(-".$matchers[0][0].") ...won, and ".$splitgame[1]."(".$bar2.") ...lost";			
			//echo "<hr>";
			//echo ${"xxgame$i"};
			//echo "<hr>";
			$winner .= $foo.", ";
			$loser .= mb_strtolower($splitgame[1]).", ";
			} else {
				//echo $splitgame[1]."(".$bar2.")(-".$matchers[0][0].") ...won, and ".$foo."(".$bar.") ...lost";			
				//echo "<hr>";
				//echo ${"xxgame$i"};
				//echo "<hr>";
				$winner .= mb_strtolower($splitgame[1]).", ";
				$loser .= $foo.", ";
			} 
			} else {
				$pending .= $foo.", ".mb_strtolower($splitgame[1]).", ";
			}
			} 
		} 
			
			
		} 

$splitgame_tb = explode('/ ', $xxtiebreaker);
$str_tb = $splitgame_tb[0];
$str_tb2 = explode(' -', $str_tb);
preg_match_all('!\d+!', $str_tb, $matchers2);



$winner_tb = "";
$totalscore = "";

if (($arr[mb_strtolower($str_tb2[0])] + $arr[mb_strtolower($splitgame_tb[1])]) > 0) {
if ($arr[mb_strtolower($str_tb2[0])] > $arr[mb_strtolower($splitgame_tb[1])]) {
	$winner_tb = mb_strtolower($str_tb2[0]);
	$totalscore = $arr[mb_strtolower($str_tb2[0])] + $arr[mb_strtolower($splitgame_tb[1])];
}	else {
	$winner_tb = mb_strtolower($splitgame_tb[1]);
	$totalscore = $arr[mb_strtolower($str_tb2[0])] + $arr[mb_strtolower($splitgame_tb[1])];

}
} else {
	$winner_tb = "";
}

//echo $winner_tb;
//echo "<hr>";
//echo $totalscore;
//echo "<hr>";
//echo $winner;
//echo $arr[mb_strtolower($str_tb2[0])] + $arr[mb_strtolower($splitgame_tb[1])];


	
// $winner is the string that the $xxgame1-15 (user picks from matchups) will be compared to....so this has to match the entries as they look on the table, with the right capitalizations
$winnerx = explode(', ', $winner);

for ($n = 0; $n<(count($winnerx)-1); ++$n) {

	if (strpos(mb_strtolower("green bay"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "GB";
} elseif (strpos(mb_strtolower("la chargers"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "LAC";
} elseif (strpos(mb_strtolower("cincinnati"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Cinci";
} elseif (strpos(mb_strtolower("denver"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Den";
} elseif (strpos(mb_strtolower("oakland"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Oak";
} elseif (strpos(mb_strtolower("tennessee"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "TN";
} elseif (strpos(mb_strtolower("arizona"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Arz";
} elseif (strpos(mb_strtolower("jacksonville"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Jax";
} elseif (strpos(mb_strtolower("miami"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Miami";
} elseif (strpos(mb_strtolower("cleveland"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Clev";
} elseif (strpos(mb_strtolower("ny giants"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "NYG";
} elseif (strpos(mb_strtolower("washington"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Wash";
} elseif (strpos(mb_strtolower("detroit"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Det";
} elseif (strpos(mb_strtolower("carolina"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Car";
} elseif (strpos(mb_strtolower("minnesota"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Minn";
} elseif (strpos(mb_strtolower("seattle"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Seattle";
} elseif (strpos(mb_strtolower("pittsburgh"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Pitt";
} elseif (strpos(mb_strtolower("philadelphia"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Phil";
} elseif (strpos(mb_strtolower("indianapolis"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Indy";
} elseif (strpos(mb_strtolower("dallas"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Dallas";
} elseif (strpos(mb_strtolower("chicago"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Chic";
} elseif (strpos(mb_strtolower("buffalo"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Buff";
} elseif (strpos(mb_strtolower("atlanta"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Atl";
} elseif (strpos(mb_strtolower("ny jets"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "NYJ";
} elseif (strpos(mb_strtolower("new orleans"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "NO";
}elseif (strpos(mb_strtolower("san francisco"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "SF";
}elseif (strpos(mb_strtolower("kansas city"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "KC";
}elseif (strpos(mb_strtolower("tampa bay"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "TB";
}elseif (strpos(mb_strtolower("new england"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "NE";
}elseif (strpos(mb_strtolower("la rams"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "LAR";
} elseif (strpos(mb_strtolower("baltimore"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Balt";
} elseif (strpos(mb_strtolower("houston"), mb_strtolower($winnerx[$n])) !== false) {
    $winnerx[$n] = "Hou";
}else {
	
} 
}
//print_r($winner);

$winner = implode(', ', $winnerx);

//Same for $loser

$loserx = explode(', ', $loser);

for ($n = 0; $n<(count($loserx)-1); ++$n) {

	if (strpos(mb_strtolower("green bay"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "GB";
} elseif (strpos(mb_strtolower("la chargers"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "LAC";
} elseif (strpos(mb_strtolower("cincinnati"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Cinci";
} elseif (strpos(mb_strtolower("denver"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Den";
} elseif (strpos(mb_strtolower("oakland"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Oak";
} elseif (strpos(mb_strtolower("tennessee"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "TN";
} elseif (strpos(mb_strtolower("arizona"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Arz";
} elseif (strpos(mb_strtolower("jacksonville"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Jax";
} elseif (strpos(mb_strtolower("miami"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Miami";
} elseif (strpos(mb_strtolower("cleveland"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Clev";
} elseif (strpos(mb_strtolower("ny giants"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "NYG";
} elseif (strpos(mb_strtolower("washington"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Wash";
} elseif (strpos(mb_strtolower("detroit"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Det";
} elseif (strpos(mb_strtolower("carolina"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Car";
} elseif (strpos(mb_strtolower("minnesota"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Minn";
} elseif (strpos(mb_strtolower("seattle"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Seattle";
} elseif (strpos(mb_strtolower("pittsburgh"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Pitt";
} elseif (strpos(mb_strtolower("philadelphia"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Phil";
} elseif (strpos(mb_strtolower("indianapolis"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Indy";
} elseif (strpos(mb_strtolower("dallas"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Dallas";
} elseif (strpos(mb_strtolower("chicago"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Chic";
} elseif (strpos(mb_strtolower("buffalo"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Buff";
} elseif (strpos(mb_strtolower("atlanta"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Atl";
} elseif (strpos(mb_strtolower("ny jets"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "NYJ";
} elseif (strpos(mb_strtolower("new orleans"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "NO";
}elseif (strpos(mb_strtolower("san francisco"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "SF";
}elseif (strpos(mb_strtolower("kansas city"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "KC";
}elseif (strpos(mb_strtolower("tampa bay"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "TB";
}elseif (strpos(mb_strtolower("new england"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "NE";
}elseif (strpos(mb_strtolower("la rams"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "LAR";
} elseif (strpos(mb_strtolower("baltimore"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Balt";
} elseif (strpos(mb_strtolower("houston"), mb_strtolower($loserx[$n])) !== false) {
    $loserx[$n] = "Hou";
} else {
	
} 
}
//print_r($loser);

$loser = implode(', ', $loserx);

//Same for $pending

$pendingx = explode(', ', $pending);

for ($n = 0; $n<(count($pendingx)-1); ++$n) {

	if (strpos(mb_strtolower("green bay"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "GB";
} elseif (strpos(mb_strtolower("la chargers"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "LAC";
} elseif (strpos(mb_strtolower("cincinnati"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Cinci";
} elseif (strpos(mb_strtolower("denver"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Den";
} elseif (strpos(mb_strtolower("oakland"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Oak";
} elseif (strpos(mb_strtolower("tennessee"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "TN";
} elseif (strpos(mb_strtolower("arizona"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Arz";
} elseif (strpos(mb_strtolower("jacksonville"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Jax";
} elseif (strpos(mb_strtolower("miami"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Miami";
} elseif (strpos(mb_strtolower("cleveland"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Clev";
} elseif (strpos(mb_strtolower("ny giants"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "NYG";
} elseif (strpos(mb_strtolower("washington"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Wash";
} elseif (strpos(mb_strtolower("detroit"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Det";
} elseif (strpos(mb_strtolower("carolina"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Car";
} elseif (strpos(mb_strtolower("minnesota"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Minn";
} elseif (strpos(mb_strtolower("seattle"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Seattle";
} elseif (strpos(mb_strtolower("pittsburgh"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Pitt";
} elseif (strpos(mb_strtolower("philadelphia"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Phil";
} elseif (strpos(mb_strtolower("indianapolis"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Indy";
} elseif (strpos(mb_strtolower("dallas"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Dallas";
} elseif (strpos(mb_strtolower("chicago"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Chic";
} elseif (strpos(mb_strtolower("buffalo"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Buff";
} elseif (strpos(mb_strtolower("atlanta"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Atl";
} elseif (strpos(mb_strtolower("ny jets"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "NYJ";
} elseif (strpos(mb_strtolower("new orleans"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "NO";
}elseif (strpos(mb_strtolower("san francisco"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "SF";
}elseif (strpos(mb_strtolower("kansas city"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "KC";
}elseif (strpos(mb_strtolower("tampa bay"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "TB";
}elseif (strpos(mb_strtolower("new england"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "NE";
}elseif (strpos(mb_strtolower("la rams"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "LAR";
}elseif (strpos(mb_strtolower("houston"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Hou";
} elseif (strpos(mb_strtolower("baltimore"), mb_strtolower($pendingx[$n])) !== false) {
    $pendingx[$n] = "Balt";
} else {
	
} 
}
//print_r($pending);
$pending = implode(', ', $pendingx);


// Same for winner_tb
if (strpos(mb_strtolower("green bay"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "GB";
} elseif (strpos(mb_strtolower("la chargers"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "LAC";
} elseif (strpos(mb_strtolower("cincinnati"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Cinci";
} elseif (strpos(mb_strtolower("denver"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Den";
} elseif (strpos(mb_strtolower("oakland"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Oak";
} elseif (strpos(mb_strtolower("tennessee"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "TN";
} elseif (strpos(mb_strtolower("arizona"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Arz";
} elseif (strpos(mb_strtolower("jacksonville"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Jax";
} elseif (strpos(mb_strtolower("miami"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Miami";
} elseif (strpos(mb_strtolower("cleveland"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Clev";
} elseif (strpos(mb_strtolower("ny giants"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "NYG";
} elseif (strpos(mb_strtolower("washington"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Wash";
} elseif (strpos(mb_strtolower("detroit"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Det";
} elseif (strpos(mb_strtolower("carolina"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Car";
} elseif (strpos(mb_strtolower("minnesota"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Minn";
} elseif (strpos(mb_strtolower("seattle"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Seattle";
} elseif (strpos(mb_strtolower("pittsburgh"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Pitt";
} elseif (strpos(mb_strtolower("philadelphia"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Phil";
} elseif (strpos(mb_strtolower("indianapolis"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Indy";
} elseif (strpos(mb_strtolower("dallas"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Dallas";
} elseif (strpos(mb_strtolower("chicago"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Chic";
} elseif (strpos(mb_strtolower("buffalo"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Buff";
} elseif (strpos(mb_strtolower("atlanta"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Atl";
} elseif (strpos(mb_strtolower("ny jets"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "NYJ";
} elseif (strpos(mb_strtolower("new orleans"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "NO";
}elseif (strpos(mb_strtolower("san francisco"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "SF";
}elseif (strpos(mb_strtolower("kansas city"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "KC";
}elseif (strpos(mb_strtolower("tampa bay"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "TB";
}elseif (strpos(mb_strtolower("new england"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "NE";
}elseif (strpos(mb_strtolower("la rams"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "LAR";
}elseif (strpos(mb_strtolower("houston"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Hou";
} elseif (strpos(mb_strtolower("baltimore"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Balt";
} else {
	
} 

?>


<!-- START: Table -->  
<table style="font-size:16px; background-color:white" id="mytable">

<?php
// This get the first gray cell and then gets everyone's names
echo '<td align="left" style="text-align: left; background-color:#e6e6e6; color:green; border-color: #262626"><div style="width: 325px;">Week '.$_SESSION['sql_week'].'</div></td>';
foreach (array_combine($data['xid'], $data['xname']) as $xidx => $xnamex) {
	  printf('<td>
			<div name="'.$xnamex.'x">
			<div name="'.$xnamex.'"; style="width: 95px;" align="center">
				<b>'.$xnamex.'</b>
				<img name="firework" ></img>
			</div>
			</div>

</td>', htmlspecialchars($xnamex));

}

echo '</tr>';



// Connect to mysql db to get games/spreadlock 
include_once('connect2.php');
    if (mysqli_connect_errno($con))
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

	  
	  
	  
//This gets all of the games from the spreadlock table and puts them in the html table  
for ($i = 1; $i <= 15; ++$i) {
	if (!empty(${"xxgame$i"}) && !empty(${"xxgame".($i).""})) {  //--if it's the last game on the list, echo tiebreaker
		$splitthis = explode('/ ', ${"xxgame$i"});
		$splitfirst = explode(' -', $splitthis[0]);
	echo '<tr><td style="text-align: left; background-color:#337ab7; color:white; border-color: #262626;">'.$splitfirst[0].' <b style="background-color:#707070; color:white; text-shadow: 2px 2px black">&nbsp'.$arr[mb_strtolower($splitfirst[0])].'&nbsp</b>&nbsp(-'.$splitfirst[1].')/&nbsp'.$splitthis[1].'&nbsp<b style="background-color:#707070; color:white; text-shadow: 2px 2px black">&nbsp'.$arr[mb_strtolower($splitthis[1])].'&nbsp</b>&nbsp</td>';
			

//THIS could/does put all of the scores into the `scores` tables. *****
$result = mysql_query("SELECT * FROM `scores` WHERE `week` LIKE 'Week 2' AND `team` LIKE `team`='".$splitfirst[0]."' AND `team` LIKE '".$splitthis[1]."'");

if(mysql_num_rows($result) == 0)
{
    $sql_scores = "INSERT INTO `scores` (`team`, `score`, `spread`, `week`) VALUES ('".$splitfirst[0]."', '".$arr[mb_strtolower($splitfirst[0])]."', '-".$splitfirst[1]."', '".$_SESSION['sql_week']."');"; 
	$sql_scores2 = "INSERT INTO `scores` (`team`, `score`, `week`) VALUES ('".$splitthis[1]."', '".$arr[mb_strtolower($splitthis[1])]."', '".$_SESSION['sql_week']."');";
	mysqli_query($conn, $sql_scores);
	mysqli_query($conn, $sql_scores2);
	//echo $query2;
}
else
{
     $query = "UPDATE `scores` SET `team`='".$splitfirst[0]."', `score`='".$arr[mb_strtolower($splitfirst[0])]."', `spread`='-".$splitfirst[1]."'  WHERE week LIKE '".$_SESSION['sql_week']."' AND `team` LIKE `team`='".$splitfirst[0]."';"; 
	 $query2 = "UPDATE `scores` SET `team`='".$splitthis[1]."', `score`='".$arr[mb_strtolower($splitthis[1])]."',  WHERE week LIKE '".$_SESSION['sql_week']." AND `team` LIKE '".$splitthis[1]."'';"; 

	mysqli_query($conn, $query);
	mysqli_query($conn, $query2);
	//echo $query;
}
			//****delete between if needed. 
			
			// This puts everyone's picks into the table...$data['xgame$i'] is an arrary composed of the row game1
			if(!empty($data['xgame'.($i).''])) {
					foreach($data['xgame'.($i).''] as $n) {
					printf('<td', htmlspecialchars($n));
						if (!empty($n) && strpos($winner, $n) !== false) {
							echo " style='background-color:#d3e8d5'><b>Win</b> (".$n.")</td>";
							
							// This updates the wins table to be only Win/Loss...added javascript to give the winner fireworks on the table
							for ($w = 1; $w <= 15; ++$w) {
								$sql7 = "UPDATE `wins` SET `game$w` = replace(`game$w`, '$n', 'Win') WHERE week LIKE '".$_SESSION['sql_week']."';";
								//echo $sql7;
								//echo "<hr>";
								mysqli_query($con, $sql7);
							}
						} elseif (!empty($n) && strpos($loser, $n) !== false) {
							echo " style='background-color:#e8d3d3'>Loss (".$n.")</td>";
							for ($w = 1; $w <= 15; ++$w) {
								$sql7 = "UPDATE `wins` SET `game$w` = replace(`game$w`, '$n', 'Loss') WHERE week LIKE '".$_SESSION['sql_week']."';";
								//echo $sql7;
								//echo "<hr>";
								mysqli_query($con, $sql7);
							}
						} elseif (!empty($n) && strpos($pending, $n) !== false) {
							echo " style='background-color:#f4eeb5'>".$n."</td>";
						} 
						  else {
							echo '>'.$n.'</td>';
						
						}
						
					}


echo '</tr>';
 
			}	

} else {
$splitthis = explode('/ ', $xxtiebreaker);
		$splitfirst = explode(' -', $splitthis[0]);
	echo '<tr>
	<td style="text-align: left; background-color:#337ab7; color:white; border-color: #262626;">'.$splitfirst[0].' 
	<b style="background-color:#707070; color:white; text-shadow: 2px 2px black">&nbsp'.$arr[mb_strtolower($splitfirst[0])].'&nbsp</b>&nbsp
	/&nbsp'.$splitthis[1].'&nbsp
	<b style="background-color:#707070; color:white; text-shadow: 2px 2px black">&nbsp'.$arr[mb_strtolower($splitthis[1])].'&nbsp</b>&nbsp|&nbsp
	Total:&nbsp<b style="background-color:#969570; color:white; text-shadow: 2px 2px black">&nbsp'.($arr[mb_strtolower($splitfirst[0])]+$arr[mb_strtolower($splitthis[1])]).'&nbsp</b>&nbsp</td>';	
	$i=101;
	if (!empty($data['xtiebreaker'])) {
	foreach($data['xtiebreaker'] as $n) {
					$plode = explode(' ', $n);
					$citi = $plode[0];
					$pts = $plode[1];
					
			
					
					
					if (!empty($winner_tb)) {
					printf('<td', htmlspecialchars($n));
					if (strpos(mb_strtolower($winner_tb), mb_strtolower($citi)) !== false && $pts <= $totalscore) {
							echo " style='background-color:#d3e8d5'><b>Win</b> (".$n.")</td>";
							
							
						} else {
							echo " style='background-color:#e8d3d3'>Loss (".$n.")</td>";

						}
					} else {
						echo "<td>".$n."</td>";

					}
					
	}
}
echo "</tr>";
}
}


// START highlight the winner
$query8 = "SELECT * FROM wins WHERE week = '".$_SESSION['sql_week']."'";
$result3= mysqli_query($con, $query8) or die("Invalid query");
$card = "";
$ntest = "";
$numwins = "";
$blar = "";

while($row = mysqli_fetch_assoc($result3)){
	$card .= $row['name'].", ";
}

$card = explode(", ", $card);

foreach ($card as $p){
	$query9 = "SELECT name, game1, game2, game3, game4, game5, game6, game7, game8, game9, game10, game11, game12, game13, game14, game15, tiebreaker FROM wins WHERE name='$p' AND week = '".$_SESSION['sql_week']."';";
	$newcard = mysqli_query($con, $query9) or die("Invalid query");
	while($row = mysqli_fetch_assoc($newcard)){
		 $ntest = implode(", ", $row);
		 $numwins = explode("Win, ", $ntest);
		 $blar .= $row['name'].": ".(count($numwins)-1)."/ ";
			}

}	
//echo $blar;


$xblar = explode("/ ", $blar);

foreach ($xblar as $k => $v) {
	$xblar[$k] = explode(": ",$v);
}
//echo "<hr>";
//print_r($xblar);

$newblar = array();

for ($uu=0; $uu <= 30; ++$uu) {
	if (!empty($xblar[$uu]) && !empty($xblar[$uu][0]) && $xblar[$uu][1] !== false) {
		$newblar[$xblar[$uu][0]] = $xblar[$uu][1];
	}
}
//print_r($newblar);

$maxs = array_keys($newblar, max($newblar));

foreach ($maxs as $m) {
	unset($newblar[$m]);
}

//print_r($maxs); //## working as of 12/7/2017
//print_r('"'.$maxs[0].'"');






$newlist = "";
foreach ($maxs as $y) {
		$query10 = "SELECT tiebreaker FROM wins WHERE name='$y' AND week = '".$_SESSION['sql_week']."';";
		$their_tb = mysqli_query($con, $query10);
		while($row = mysqli_fetch_assoc($their_tb)){
			$plode = explode(' ', $row['tiebreaker']);
			$citi = $plode[0];
			$pts = $plode[1];
			if (strpos(mb_strtolower("kc"), mb_strtolower($citi)) !== false) {
				$citi2 = "kansas city";
			}
		
	
//print_r($winner_tb);
//echo "<hr>";


//$winner_tb = implode(', ', $winner_tbx);
			if (strpos(mb_strtolower($winner_tb), mb_strtolower($citi)) !== false) {
				if (($totalscore - $pts) >= 0) {
					$newlist .= $y.": ".($totalscore - $pts)."/ ";
				}
		}		
	}
}

//echo $newlist; //...$newlist will have the list of everyone who qualifies for the tiebreaker along with the difference between the score they picked and the final score of the game
//echo "<hr>";

$xlist = explode("/ ", $newlist);


//$xblar = explode("/ ", $blar);

foreach ($xlist as $k => $v) {
	$xlist[$k] = explode(": ",$v);
}
//echo "<hr>";
//print_r($xlist);

$newlist = array();

for ($uu=0; $uu <= 30; ++$uu) {
	if (!empty($xlist[$uu]) && !empty($xlist[$uu][0]) && $xlist[$uu][1] !== false) {
		$newlist[$xlist[$uu][0]] = $xlist[$uu][1];
	}
}
//print_r($newblar);

$maxs2 = array_keys($newlist, min($newlist));

foreach ($maxs2 as $m) {
	unset($newlist[$m]);
}

//print_r($maxs2);

// $maxs2 = THE BIG OVERALL WINNER



//print_r($maxs); //$maxs is the list of everyone who qualified for the tiebreaker

//echo"<hr>";

//print_r($maxs2); //$maxs2 will be >1 if there is an actual tie going into Monday night



$bigwinner = $maxs2;

 //##






mysqli_close($con);





?>
</table>



<div class="row">
	<div class="col-xs-12" style="color:white">|
</div>
</div>
	<div class="col-xs-2">
		<form action="winlose_excel.php" method="POST">
			<input type="submit" value="Export to Excel">
		</form>
	</div>
	
	
	


<!-- Start: verify current stats -->
<div class="col-xs-12">*Stats pulled from <a target="_blank" href="http://www.footballlocks.com/nfl_lines.shtml">FootballLocks.com</a> and NFL.com...Last update: <p><?php include_once('getdate.php'); echo $newtime; ?></p>
</div>


<!-- Start: export to Excel-->


<iframe name="nflframe" class="col-xs-12" style="height:1000px; width: 100%;" src="" ></iframe>





<!-- Start: Animate winner -->

<?php

// This will be the condition that determines whether or not to animate the names (i.e. whether or not all of the scores are final)


if ($arr[mb_strtolower($str_tb2[0])] + $arr[mb_strtolower($splitgame_tb[1])] == 0){
	//if there is no final score for the tiebreaker...do nothing
	
} else {

?>


<script>

//Animate the winners

<?php 
if (count($maxs2) < 2) { //...if there's a clear winner without the tiebreaker...
 foreach ($maxs2 as $h) { 
	
	echo 'var x = document.getElementsByName("'.$h.'");';
	//echo 'x[0].innerHTML = "Example";';
    //echo 'x[0].style.backgroundColor = "blue";';
    echo 'x[0].style.fontSize = "xx-large";';
    echo 'x[0].className= "item animated tada";';
    echo 'x[0].getElementsByTagName("img")[0].src = "animated-fireworks.gif";';
    echo 'x[0].getElementsByTagName("img")[0].style.height = "100px";';
    echo 'x[0].getElementsByTagName("img")[0].style.width = "200px";';
	}


} else { //..if there's a tie going into Monday night...
	
	foreach ($maxs2 as $h) {
	
	echo 'var x = document.getElementsByName("'.$h.'");';
	//echo 'x[0].innerHTML = "Example";';
    //echo 'x[0].style.backgroundColor = "green";';
    echo 'x[0].style.fontSize = "xx-large";';
    echo 'x[0].className= "item animated tada";';
    echo 'x[0].getElementsByTagName("img")[0].src = "tiebreaker.png";';
    echo 'x[0].getElementsByTagName("img")[0].style.height = "100px";';
    echo 'x[0].getElementsByTagName("img")[0].style.width = "200px";';

}
}
?>



//Animate the losers to fade out
var delay=3000; //1 second

setTimeout(function() {
<?php	
$newss = "";


if (count($maxs2) < 2) {
foreach (array_combine($data['xid'], $data['xname']) as $xidx => $xnamex) {
	if ($maxs2[0] !== $xnamex) {
		echo 'var x = document.getElementsByName("'.$xnamex.'");';
		echo 'x[0].className= "item animated hinge";';
		
	}
}


?>
}, delay);


//Animate the losers to fade back in
var delay=5000; //1 second

setTimeout(function() {
<?php	
$newss = "";

foreach (array_combine($data['xid'], $data['xname']) as $xidx => $xnamex) {
	if ($maxs2[0] !== $xnamex) {
	
	echo 'var x = document.getElementsByName("'.$xnamex.'x");';
    echo 'x[0].innerHTML = "'.$xnamex.'";';
	echo 'x[0].style.width="95px";';
	echo 'x[0].style.align="center";';
	echo 'x[0].style.color="gray";';
    echo 'x[0].className= "item animated fadeIn";';

	}
}
}
?>
}, delay);


</script>

<?php 

}

?>









<!-- Start: load the nfl.com scores page with the appropiate week -->

<?php

if (!empty($_SESSION['sql_week'])) {

?>

<script>
var delay=4000; //1 second

setTimeout(function() {
	document.getElementsByTagName("iframe")[0].src="<?php echo $Url; ?>";
	//document.getElementsByTagName("iframe")[0].src="http://growhomenow.com/snapshot.php";

	
}, delay);


<?php 
} else {
?>

<script>
var delay=4000; //1 second

setTimeout(function() {
	document.getElementsByTagName("iframe")[0].src="http://www.nfl.com/";
	//document.getElementsByTagName("iframe")[0].src="http://growhomenow.com/snapshot.php";

	
}, delay);

<?php
}

?>

var x = document.getElementsByClassName("item animated hinge");
	x[0].className= "item animated fadeIn";
</script>

<script>
$("#aa").click(function(){
    $("table").each(function() {
        var $this = $(this);
        var newrows = [];
        $this.find("tr").each(function(){
            var i = 0;
            $(this).find("td").each(function(){
                i++;
                if(newrows[i] === undefined) { newrows[i] = $("<tr></tr>"); }
                newrows[i].append($(this));
            });
        });
        $this.find("tr").remove();
        $.each(newrows, function(){
            $this.append(this);
        });
    });

    return false;
});
</script>





<!-- NOTES/ unused code:






// Get time in game 
	$Url = 'localhost/dashboard/snapshot.php';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
	$start = strpos($output, '<div class="scorebox-wrapper">');
	$end = strpos($output, '<div class="footer-links-container"', $start);
	//echo htmlspecialchars($output);
	//echo "<hr>";
	$length = $end-$start;
	$output = substr($output, $start, $length);
	$output = strval($output);
	$tig = explode('<div class="game-center-area">', $output);
	//print_r($tig);
	
	
	$xtig = array();
for ($i = 0; $i <= 1000; ++$i) {
	if (!empty($tig[$i])) {
		array_push($xtig, explode('<span class="time-left" >', $tig[$i]));
	}
}

//print_r($xtig[2][0][1]);

//print_r($xtig[1][1]);
//echo "<hr>";

$finaltig = "";
for ($i = 0; $i <= 100; ++$i) {
	if (!empty($xtig[$i][1])) {
		$finaltig .= $xtig[$i][1].', ';
	} 
}

//echo $finaltig;
-->
</body>
</html>