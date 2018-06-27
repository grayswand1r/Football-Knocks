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
 
// scrape final scores from nfl.com 
if (!empty($_SESSION['sql_week'])) {
	$url_arr = array();
	$url_arr = explode(' ', $_SESSION['sql_week']);
	$Url = 'http://www.nfl.com/scores/2017/REG'.$url_arr[1];
} else {
	$Url = 'http://www.nfl.com/scores';
}
	
	//$Url = 'http://www.nfl.com/scores/2017/REG3';
	//$Url = 'http://localhost/dashboard/snapshot.php';
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
	$query="SELECT * FROM matchups_cache WHERE week LIKE '%".$_SESSION['sql_week']."%' ORDER BY name ASC";
	$query2='SELECT * FROM spreadlock WHERE week LIKE "%'.$_SESSION['sql_week'].'%";';  
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
    $winnerx[$n] = "LA";
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
    $loserx[$n] = "LA";
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
    $pendingx[$n] = "LA";
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
    $winner_tb = "LA";
}elseif (strpos(mb_strtolower("houston"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Hou";
} elseif (strpos(mb_strtolower("baltimore"), mb_strtolower($winner_tb)) !== false) {
    $winner_tb = "Balt";
} else {
	
} 



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
echo '<td align="left" style="text-align: left; background-color:#e6e6e6; color:green; border-color: #262626"><div style="width: 325px;">'.$_SESSION['sql_week'].'</div></td>';
foreach (array_combine($data['xid'], $data['xname']) as $xidx => $xnamex) {
	  printf('<td>

	<div class="col-xs-11" align="center"><b>'.$xnamex.'</b>
	</div></td>', htmlspecialchars($xnamex));

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
	echo '<tr><td style="text-align: left; background-color:#337ab7; color:white; border-color: #262626;">'.$splitfirst[0].' <b style="background-color:#707070; color:white; text-shadow: 2px 2px black">'.$arr[mb_strtolower($splitfirst[0])].'</b>(-'.$splitfirst[1].')/'.$splitthis[1].'<b style="background-color:#707070; color:white; text-shadow: 2px 2px black">'.$arr[mb_strtolower($splitthis[1])].'</b></td>';

			// This puts everyone's picks into the table...$data['xgame$i'] is an arrary composed of the row game1
			if(!empty($data['xgame'.($i).''])) {
					foreach($data['xgame'.($i).''] as $n) {
					printf('<td', htmlspecialchars($n));
						if (!empty($n) && strpos($winner, $n) !== false) {
							echo " style='background-color:#d3e8d5'><b>Win</b> (".$n.")</td>";
							
							// This updates the wins table to be only Win/Loss...added javascript to give the winner fireworks on the table
							for ($w = 1; $w <= 15; ++$w) {
								$sql7 = "UPDATE `wins` SET `game$w` = replace(`game$w`, '$n', 'Win');";
								//echo $sql7;
								//echo "<hr>";
								mysqli_query($con, $sql7);
							}
						} elseif (!empty($n) && strpos($loser, $n) !== false) {
							echo " style='background-color:#e8d3d3'>Loss (".$n.")</td>";
							for ($w = 1; $w <= 15; ++$w) {
								$sql7 = "UPDATE `wins` SET `game$w` = replace(`game$w`, '$n', 'Loss');";
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
	<b style="background-color:#707070; color:white; text-shadow: 2px 2px black">'.$arr[mb_strtolower($splitfirst[0])].'</b>
	/'.$splitthis[1].'
	<b style="background-color:#707070; color:white; text-shadow: 2px 2px black">'.$arr[mb_strtolower($splitthis[1])].'</b>|
	Total:<b style="background-color:#969570; color:white; text-shadow: 2px 2px black">'.($arr[mb_strtolower($splitfirst[0])]+$arr[mb_strtolower($splitthis[1])]).'</b></td>';	
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





?>
	

</table>


<p style='font-size:16px; background-color:white'>
<td>*Stats pulled from FootballLocks.com - Last update: <?php include_once('getdate.php'); echo $newtime; ?> </td></p>
