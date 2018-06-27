<?php
session_start();
header("Location: pool.php?search_week=".$_SESSION['sql_week']."&search=Search");

// Get data
include_once('newtest.php');


$new1 = "" ;
$new2 = "" ;
$new3 = "" ;
$new4 = "" ;
$new5 = "" ;
$new6 = "" ;
$new7 = "" ;
$new8 = "" ;
$new9 = "" ;
$new10 = "" ;
$new11 = "" ;
$new12 = "" ;
$new13 = "" ;
$new14 = "" ;
$new15 = "" ;
$new16 = "" ;

$xnew1 = $_POST['picka'];
$xnew2 = $_POST['pickb'];
$xnew3 = $_POST['pickc'];
$xnew4 = $_POST['pickd'];
$xnew5 = $_POST['picke'];

$tiebreaker = $_POST['tiebreaker'];
$newtiebreaker = "";

// This allows picks to be entered in shorthand that doesn't match the webcrawl (i.e. if picka is entered as "gb", this changes it to "Green Bay" when sorting)


// modify $xnew$n (1-5)
for ($n = 1; $n <= 5; ++$n) {
	if("" == trim(${"xnew$n"})){
    ${"xnew$n"} = 'NULL';
} elseif(mb_strtolower("LA") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'NULL';
} 
elseif(mb_strtolower("GB") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'Green Bay';
} elseif(mb_strtolower("LAC") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'LA Chargers';
} elseif(mb_strtolower("NO") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'New Orleans';
} elseif(mb_strtolower("SF") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'San Francisco';
} elseif(mb_strtolower("KC") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'Kansas City';
} elseif(mb_strtolower("TB") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'Tampa Bay';
} elseif(mb_strtolower("NE") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'New England';
} elseif(mb_strtolower("LAR") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'LA Rams';
} elseif(mb_strtolower("Arz") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'Arizona';
} elseif(mb_strtolower("Jax") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'Jacksonville';
} elseif(mb_strtolower("MN") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'Minnesota';
} elseif(mb_strtolower("Indy") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'Indiana';
} elseif(mb_strtolower("TN") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'Tennessee';
} elseif(mb_strtolower("NYJ") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'NY Jets';
} elseif(mb_strtolower("NYG") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'NY Giants';
} elseif(mb_strtolower("falcons") == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'Atlanta';
} elseif (mb_strtolower('ravens') == mb_strtolower(${"xnew$n"})){
${"xnew$n"} = 'baltimore';}
elseif
	
(mb_strtolower('bills') == mb_strtolower(${"xnew$n"})){
${"xnew$n"} = 'buffalo';} elseif
	
(mb_strtolower('bengals') == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'cincinnati';} elseif
	
(mb_strtolower('browns') == mb_strtolower(${"xnew$n"})){
    ${"xnew$n"} = 'cleveland';} elseif
	
(mb_strtolower('broncos') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'denver';} elseif
	
(mb_strtolower('texans') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'houston';} elseif
	
(mb_strtolower('colts') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'indianapolis';} elseif
	
(mb_strtolower('jaguars') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'jacksonville';} elseif
	
(mb_strtolower('chiefs') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'kansas city';} elseif
	
(mb_strtolower('dolphins') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'miami';} elseif
	
(mb_strtolower('patriots') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'new england';} elseif
	
(mb_strtolower('jets') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'ny jets';} elseif
	
(mb_strtolower('raiders') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'oakland';} elseif
	
(mb_strtolower('steelers') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'pittsburgh';} elseif
	
(mb_strtolower('chargers') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'la chargers';} elseif
	
(mb_strtolower('titans') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'tennessee';} elseif
	
(mb_strtolower('cardinals') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'arizona';} elseif
	
(mb_strtolower('falcons') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'atlanta';} elseif
	
(mb_strtolower('panthers') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'carolina';} elseif
	
(mb_strtolower('bears') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'chicago';} elseif
	
(mb_strtolower('cowboys') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'dallas';} elseif
	
(mb_strtolower('lions') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'detroit';} elseif
	
(mb_strtolower('packers') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'green bay';} elseif
	
(mb_strtolower('rams') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'la rams';} elseif
	
(mb_strtolower('vikings') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'minnesota';} elseif
	
(mb_strtolower('saints') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'new orleans';} elseif
	
(mb_strtolower('giants') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'ny giants';} elseif
	
(mb_strtolower('eagles') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'philadelphia';} elseif
	
(mb_strtolower('49ers') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'san francisco';} elseif
	
(mb_strtolower('seahawks') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'seattle';} elseif

(mb_strtolower('buccaneers') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'tampa bay';} elseif
	
(mb_strtolower('redskins') == mb_strtolower(${"xnew$n"})){ ${"xnew$n"} = 'washington';}
}


// ...same with Tiebreaker
$this_tb = explode(' ', $tiebreaker);
$that_tb = $this_tb[0];

if("" == trim($that_tb)){
    $that_tb = 'NULL';
} elseif(mb_strtolower("LA") == mb_strtolower($that_tb)){
    $that_tb = 'NULL';
}
elseif(mb_strtolower("GB") == mb_strtolower($that_tb)){
    $that_tb = 'Green Bay';
} elseif(mb_strtolower("LAC") == mb_strtolower($that_tb)){
    $that_tb = 'LA Chargers';
} elseif(mb_strtolower("NO") == mb_strtolower($that_tb)){
    $that_tb = 'New Orleans';
} elseif(mb_strtolower("SF") == mb_strtolower($that_tb)){
    $that_tb = 'San Francisco';
} elseif(mb_strtolower("KC") == mb_strtolower($that_tb)){
    $that_tb = 'Kansas City';
} elseif(mb_strtolower("TB") == mb_strtolower($that_tb)){
    $that_tb = 'Tampa Bay';
} elseif(mb_strtolower("NE") == mb_strtolower($that_tb)){
    $that_tb = 'New England';
} elseif(mb_strtolower("LAR") == mb_strtolower($that_tb)){
    $that_tb = 'LA Rams';
} elseif(mb_strtolower("Arz") == mb_strtolower($that_tb)){
    $that_tb = 'Arizona';
} elseif(mb_strtolower("Jax") == mb_strtolower($that_tb)){
    $that_tb = 'Jacksonville';
} elseif(mb_strtolower("MN") == mb_strtolower($that_tb)){
    $that_tb = 'Minnesota';
} elseif(mb_strtolower("Indy") == mb_strtolower($that_tb)){
    $that_tb = 'Indiana';
} elseif(mb_strtolower("TN") == mb_strtolower($that_tb)){
    $that_tb = 'Tennessee';
} elseif(mb_strtolower("NYJ") == mb_strtolower($that_tb)){
    $that_tb = 'NY Jets';
} elseif(mb_strtolower("NYG") == mb_strtolower($that_tb)){
    $that_tb = 'NY Giants';
} elseif(mb_strtolower("falcons") == mb_strtolower($that_tb)){
    $that_tb = 'Atlanta';
} elseif (mb_strtolower('ravens') == mb_strtolower($that_tb)){
$that_tb = 'baltimore';}
elseif
	
(mb_strtolower('bills') == mb_strtolower($that_tb)){
$that_tb = 'buffalo';} elseif
	
(mb_strtolower('bengals') == mb_strtolower($that_tb)){
    $that_tb = 'cincinnati';} elseif
	
(mb_strtolower('browns') == mb_strtolower($that_tb)){
    $that_tb = 'cleveland';} elseif
	
(mb_strtolower('broncos') == mb_strtolower($that_tb)){ $that_tb = 'denver';} elseif
	
(mb_strtolower('texans') == mb_strtolower($that_tb)){ $that_tb = 'houston';} elseif
	
(mb_strtolower('colts') == mb_strtolower($that_tb)){ $that_tb = 'indianapolis';} elseif
	
(mb_strtolower('jaguars') == mb_strtolower($that_tb)){ $that_tb = 'jacksonville';} elseif
	
(mb_strtolower('chiefs') == mb_strtolower($that_tb)){ $that_tb = 'kansas city';} elseif
	
(mb_strtolower('dolphins') == mb_strtolower($that_tb)){ $that_tb = 'miami';} elseif
	
(mb_strtolower('patriots') == mb_strtolower($that_tb)){ $that_tb = 'new england';} elseif
	
(mb_strtolower('jets') == mb_strtolower($that_tb)){ $that_tb = 'ny jets';} elseif
	
(mb_strtolower('raiders') == mb_strtolower($that_tb)){ $that_tb = 'oakland';} elseif
	
(mb_strtolower('steelers') == mb_strtolower($that_tb)){ $that_tb = 'pittsburgh';} elseif
	
(mb_strtolower('chargers') == mb_strtolower($that_tb)){ $that_tb = 'la chargers';} elseif
	
(mb_strtolower('titans') == mb_strtolower($that_tb)){ $that_tb = 'tennessee';} elseif
	
(mb_strtolower('cardinals') == mb_strtolower($that_tb)){ $that_tb = 'arizona';} elseif
	
(mb_strtolower('falcons') == mb_strtolower($that_tb)){ $that_tb = 'atlanta';} elseif
	
(mb_strtolower('panthers') == mb_strtolower($that_tb)){ $that_tb = 'carolina';} elseif
	
(mb_strtolower('bears') == mb_strtolower($that_tb)){ $that_tb = 'chicago';} elseif
	
(mb_strtolower('cowboys') == mb_strtolower($that_tb)){ $that_tb = 'dallas';} elseif
	
(mb_strtolower('lions') == mb_strtolower($that_tb)){ $that_tb = 'detroit';} elseif
	
(mb_strtolower('packers') == mb_strtolower($that_tb)){ $that_tb = 'green bay';} elseif
	
(mb_strtolower('rams') == mb_strtolower($that_tb)){ $that_tb = 'LA Rams';} elseif
	
(mb_strtolower('vikings') == mb_strtolower($that_tb)){ $that_tb = 'minnesota';} elseif
	
(mb_strtolower('saints') == mb_strtolower($that_tb)){ $that_tb = 'new orleans';} elseif
	
(mb_strtolower('giants') == mb_strtolower($that_tb)){ $that_tb = 'ny giants';} elseif
	
(mb_strtolower('eagles') == mb_strtolower($that_tb)){ $that_tb = 'philadelphia';} elseif
	
(mb_strtolower('49ers') == mb_strtolower($that_tb)){ $that_tb = 'san francisco';} elseif
	
(mb_strtolower('seahawks') == mb_strtolower($that_tb)){ $that_tb = 'seattle';} elseif

(mb_strtolower('buccaneers') == mb_strtolower($that_tb)){ $that_tb = 'tampa bay';} elseif
	
(mb_strtolower('redskins') == mb_strtolower($that_tb)){ $that_tb = 'washington';}

// modify $newtiebreaker
if (strpos(mb_strtolower("green bay"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "GB ".$this_tb[1];
	
}  elseif (strpos(mb_strtolower("la chargers"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "LAC ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("cincinnati"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Cinci ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("baltimore"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Balt ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("denver"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Den ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("oakland"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Oak ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("tennessee"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "TN ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("arizona"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Arz ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("jacksonville"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Jax ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("miami"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Miami ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("cleveland"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Clev ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("ny giants"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "NYG ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("washington"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Wash ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("detroit"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Det ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("carolina"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Car ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("minnesota"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Minn ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("seattle"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Seattle ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("pittsburgh"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Pitt ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("philadelphia"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Phil ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("indianapolis"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Indy ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("dallas"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Dallas ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("chicago"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Chic ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("buffalo"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Buff ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("atlanta"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Atl ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("ny jets"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "NYJ ".$this_tb[1];
	
} elseif (strpos(mb_strtolower("new orleans"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "NO ".$this_tb[1];
	
}elseif (strpos(mb_strtolower("san francisco"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "SF ".$this_tb[1];
	
}elseif (strpos(mb_strtolower("kansas city"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "KC ".$this_tb[1];
	
}elseif (strpos(mb_strtolower("tampa bay"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "TB ".$this_tb[1];
	
}elseif (strpos(mb_strtolower("new england"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "NE ".$this_tb[1];
	
}elseif (strpos(mb_strtolower("LA Rams"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "LAR ".$this_tb[1];
	
}elseif (strpos(mb_strtolower("houston"), mb_strtolower($that_tb)) !== false) {
    $newtiebreaker = "Hou ".$this_tb[1];
	
} else {
    
} 












// For every entered pick, if it is part of one of the spreadlock table games ($xxgame$i), then it goes in that row of the mysql table `matchups_cache`, AND is reformatted for uniform look (ex. "green b" = "GB")
for ($n = 1; $n <= 5; ++$n) {

for ($i = 1; $i <= 14; ++$i) {
	if (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("green bay"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "GB";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
}  elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("la chargers"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "LAC";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("cincinnati"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Cinci";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("baltimore"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Balt";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("denver"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Den";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("oakland"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Oak";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("tennessee"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "TN";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("arizona"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Arz";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("jacksonville"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Jax";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("miami"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Miami";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("cleveland"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Clev";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("ny giants"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "NYG";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("washington"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Wash";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("detroit"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Det";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("carolina"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Car";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("minnesota"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Minn";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("seattle"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Seattle";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("pittsburgh"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Pitt";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("philadelphia"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Phil";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("indianapolis"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Indy";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("dallas"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Dallas";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("chicago"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Chic";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("buffalo"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Buff";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("atlanta"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Atl";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("ny jets"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "NYJ";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("new orleans"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "NO";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
}elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("san francisco"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "SF";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
}elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("kansas city"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "KC";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
}elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("tampa bay"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "TB";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
}elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("new england"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "NE";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
}elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("la rams"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "LAR";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
}elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false && strpos(mb_strtolower("houston"), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = "Hou";
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
}elseif (strpos(mb_strtolower(${"xxgame$i"}), mb_strtolower(${"xnew$n"})) !== false) {
    ${"new$i"} = ${"xnew$n"};
	echo "<hr>";
	echo ${"new$i"};
	echo "<hr>";
} else {
    $new15 = ${"xnew$n"};
} 
}

}




$name = $_POST['namename'];



// Database connection

include_once('connect2.php');
if(!$conn) {
die('Problem in database connection: ' . mysql_error());
}

// Data insertion into database 
//**tooke out 'week' from the end of the liests beloew. Add them back in? 

//**that seemed to worqke 
//echo $name."', '".$new1."', '".$new2."', '".$new3."', '".$new4."', '".$new5."', '".$new6."', '".$new7."', '".$new8."', '".$new9."', '".$new10."', '".$new11."', '".$new12."', '".$new13."', '".$newtiebreaker;


include_once('getgames.php');

$this_sql_week = '';

if (!empty($_SESSION['sql_week'])) {
	$this_sql_week = $_SESSION['sql_week'];
} else {
	$this_sql_week = $week;
}
  
echo $this_sql_week;
  

$query1 = "INSERT INTO `matchups_cache` (`name`, `game1`, `game2`, `game3`, `game4`, `game5`, `game6`, `game7`, `game8`, `game9`, `game10`, `game11`, `game12`, `game13`, `tiebreaker`, `week`)
  VALUES
  ('".$name."', '".$new1."', '".$new2."', '".$new3."', '".$new4."', '".$new5."', '".$new6."', '".$new7."', '".$new8."', '".$new9."', '".$new10."', '".$new11."', '".$new12."', '".$new13."', '".$newtiebreaker."', '".$this_sql_week."');";
  
  
$query2 = "INSERT INTO `wins` (`name`, `game1`, `game2`, `game3`, `game4`, `game5`, `game6`, `game7`, `game8`, `game9`, `game10`, `game11`, `game12`, `game13`, `tiebreaker`)
  VALUES
  ('".$name."', '".$new1."', '".$new2."', '".$new3."', '".$new4."', '".$new5."', '".$new6."', '".$new7."', '".$new8."', '".$new9."', '".$new10."', '".$new11."', '".$new12."', '".$new13."', '".$newtiebreaker."');";

  
 
echo $xxgame1;

mysqli_query($conn, $query1);
 
mysqli_query($conn, $query2);




//if (!mysqli_query($conn,$query))
//  {
//  echo("Error description: " . mysqli_error($conn));
//  }


?>