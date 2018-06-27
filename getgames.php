<?php	

error_reporting(0);


	$Url = 'http://www.footballlocks.com/nfl_lines.shtml';
	//$Url = 'http://www.footballlocks.com/nfl_lines_week_8.shtml';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = strip_tags(curl_exec($ch));
    curl_close($ch);
	if
	(strpos($output, '9/10') !== false){
    $start = strpos($output, '9/10'); //need to find a way to automate this
	} elseif
	(strpos($output, '9/17') !== false){
    $start = strpos($output, '9/17'); //need to find a way to automate this
	} elseif
	(strpos($output, '9/24') !== false){
    $start = strpos($output, '9/24'); //need to find a way to automate this
	} elseif
	(strpos($output, '10/15') !== false){
    $start = strpos($output, '10/15'); //need to find a way to automate this
	} elseif
	(strpos($output, '10/22') !== false){
    $start = strpos($output, '10/22'); //need to find a way to automate this
	} elseif
	(strpos($output, '10/29') !== false){
    $start = strpos($output, '10/29'); //need to find a way to automate this
	} elseif
	(strpos($output, '11/12') !== false){
    $start = strpos($output, '11/12'); //need to find a way to automate this
	}  elseif
	(strpos($output, '11/19') !== false){
    $start = strpos($output, '11/19'); //need to find a way to automate this
	} elseif
	(strpos($output, '12/10') !== false){
    $start = strpos($output, '12/10'); //need to find a way to automate this
	} 
	
	
	$end = strpos($output, 'Monday Night', $start);
	$length = $end-$start;
	$output = substr($output, $start, $length);
	$output = strval($output);
	$re = "/Carolina|Denver|Atlanta|Tampa Bay|Minnesota|Tennessee|Philadelphia|Cleveland|Cincinnati|NY Jets|New Orleans|Oakland|Kansas City|LA Chargers|Baltimore|Buffalo|Houston|Chicago|Green Bay|Jacksonville|Seattle|Miami|Dallas|NY Giants|Indianapolis|Detroit|Arizona|New England|Pittsburgh|Washington|LA Rams|San Francisco|PK|Off|-[0-9]{1,2}/"; 
	preg_match_all($re, $output, $matches);
	
	

	//echo $output;
	//echo"<hr>";
	//print_r($matches[0]);
	//echo"<hr>";

$cnt = array();
$cnt = array_count_values($matches[0]);

if ($cnt['Off'] == 2) {
for ($i = 0; $i <= 100; $i=$i+1) {
	if (strpos(mb_strtolower('off'), mb_strtolower($matches[0][$i])) !== false) {
		unset($matches[0][$i-1]);
		unset($matches[0][$i]);
	}
}
} elseif ($cnt['Off'] == 1) {
	for ($i = 0; $i <= 100; $i=$i+1) {
	if (strpos(mb_strtolower('off'), mb_strtolower($matches[0][$i])) !== false) {
		unset($matches[0][$i]);
	}
}
}
 
//print_r($matches[0]); 

$arr_matches = array();

foreach($matches[0] as $new) { //Need to do this to reset the array count after deleting "Off" teams
	$arr_matches[] = $new;
}

//echo"<hr>";
//print_r($arr_matches);
// Rejoin the crawled data into one long string seperated by , 	
$game = "";

for ($i = 0; $i <= 100; $i=$i+3) {
	if (!empty($arr_matches[$i])) {
		$game .= '"'.$arr_matches[$i].' '.$arr_matches[$i+1].' / '.$arr_matches[$i+2].'", ';
	} //else (${"game$i-1"} = tiebreaker)
} 

$dataxgame = explode(",", $game);

// do the same thing again but to find the Week #
$Url2 = 'http://www.footballlocks.com/nfl_lines.shtml';
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $Url2);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    $output2 = curl_exec($ch2);
    curl_close($ch2);
	$start2 = strpos($output2, 'NFL Lines For');
	$end2 = strpos($output2, '- NFL Football Line Week Three', $start2);
	$length2 = $end2-$start2;
	$output2 = substr($output2, $start2, $length2);
	$output2 = strval($output2);
	$re2 = "/Week|[0-9]{1,2}/"; 
	preg_match_all($re2, $output2, $matches2);
	
	
	//PRINT PLAIN HTML FROM $Url 
	//echo "<HR>";
	//echo ($output);
	///print_r($matches2[0]);
	//echo "<HR>";
	
$week = '';	
	if (!empty($matches2[0][0]) && !empty($matches2[0][1])) {
		$week .= $matches2[0][1];
	} 

//echo "<hr>";
//echo $week;
?>