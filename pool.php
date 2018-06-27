<?php
session_start();
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
    <title>Football Pool 2017-18</title>

    <!-- Bootstrap core CSS -->
	
    <link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous" type="text/css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" type="text/css">
  <style>
#draggable { 
  border-radius: 50%; 
  width: 75px; 
  height: 75px; 
  padding: 15px 0 0 0; 
  float: left; 
  margin: 10px 10px 10px 0; 
  text-align:center;
 }
  
  .modal-box {
  display: none;
  position: absolute;
  z-index: 1000;
  width: 50%;
  background: white;
  border-bottom: 1px solid #aaa;
  border-radius: 4px;
  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(0, 0, 0, 0.1);
  background-clip: padding-box;
}

.modal-box header,
.modal-box .modal-header {
  padding: 1.25em 1.5em;
  border-bottom: 1px solid #ddd;
}

.modal-box header h3,
.modal-box header h4,
.modal-box .modal-header h3,
.modal-box .modal-header h4 { margin: 0; }

.modal-box .modal-body { padding: 2em 1.5em; }

.modal-box footer,
.modal-box .modal-footer {
  padding: 1em;
  border-top: 1px solid #ddd;
  background: rgba(0, 0, 0, 0.02);
  text-align: right;
}

.modal-overlay {
  opacity: 0;
  filter: alpha(opacity=0);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3) !important;
}

a.close {
  line-height: 1;
  font-size: 1.5em;
  position: absolute;
  top: 5%;
  right: 2%;
  text-decoration: none;
  color: #bbb;
}

a.close:hover {
  color: #222;
  -webkit-transition: color 1s ease;
  -moz-transition: color 1s ease;
  transition: color 1s ease;
}
#hideme {
	display: none;
}

#draggable:hover #xbox{
	display : block;
	position: absolute;
	top: 0px;
	right: 0px;

}

#xbox {
	display: none;
	border-radius: 50%; 
	width: 20px; 
	height: 20px; 
	background-color: black;
	color: white;
	font-size: 8px;
	font-weight: bold;
}

#addnewcircle {
  border-radius: 50%; 
  width: 75px; 
  height: 75px; 
  padding: 0 0 0 0; 
  float: left; 
  margin: 10px 10px 10px 0; 
  text-align:center;
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

.highlighted {
	background-color: #c0d5f7;
}
.highlightedPrev {
    background-color: #c0d5f7;
}
   </style>
   
 

  <script>
  
  //click and drag names into Picks table

  $(function() {
    $(".ui-widget-content").draggable({
        revert : true
    });
    $("#newdrop").droppable({
		accept: ".ui-draggable-dragging",
		activeClass: "panel-info",
		drop: $('#droppable').val(""),
		drop: function( event, ui ) {
        $( '#droppable' )
            .val( $( ".ui-draggable-dragging" ).text() );
      }
	});
});

document.getElementById('autoselect').focus();




  </script>
</head>



<!--START: body -->
<body>

<div class="row">
<div class="col-xs-12" style="height:20px"></div>

<!--START: Add new picks -->
<form name="customer_details" method="POST" action="customer-details.php">
	<div class="col-xs-12 col-md-4">
		<div class="panel panel-primary" id="newdrop">
			<div class="panel-heading">
				<div class="row">
				<div class="col-xs-4">Name:</div><input autofocus id="droppable" class="col-xs-7" name=namename type=text style="color:black" value=" "/> 
				</div>
			</div>
			<div class="panel-heading">	
				<div class="row"><div class="col-xs-4">Pick 1:</div><input class="col-xs-7" name=picka type=text style="color:black" value=""/></div>
				<div class="row"><div class="col-xs-4">Pick 2:</div><input class="col-xs-7" name=pickb type=text style="color:black" value=""/></div>
				<div class="row"><div class="col-xs-4">Pick 3:</div><input class="col-xs-7" name=pickc type=text style="color:black" value=""/></div> 
				<div class="row"><div class="col-xs-4">Pick 4:</div><input class="col-xs-7" name=pickd type=text style="color:black" value=""/></div>
				<div class="row"><div class="col-xs-4">Pick 5:</div><input class="col-xs-7" name=picke type=text style="color:black" value=""/></div>
				<div class="row"><div class="col-xs-4">Tie Breaker:</div><input class="col-xs-7" name=tiebreaker type=text style="color:black"/></div>
				<input type="submit" value="Submit" style="color:black"/>
			</div>
		</div>
	</div>
</form>


<!--START: Circles with names -->
<div id="container">
<?php
include_once('connect2.php');
    if (mysqli_connect_errno($conn))
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

$query="SELECT * FROM contact_widget ORDER BY name ASC";

$result= mysqli_query($conn, $query) or die("Invalid query");

$count = mysqli_affected_rows($conn);
while($row = mysqli_fetch_array($result)){
?>

<form name="deleteNew" method="POST" action="deleteNew.php">
<div id="draggable" class="ui-widget-content">
<?php echo $row['name']; ?>
<input id="hideme" name="todelete" value="<?php echo $row['id']; ?>">
<input id="xbox" type="submit" value="X"/>
</div>
</form>

<?php
}
?>


<!--START: Add new names -->
<div id="popup" class="modal-box">  
 
	<form name="addNew" method="POST" action="addNew.php">
	<div class="col-xs-12 col-md-4">
			<div class="panel-heading">
				<div class="row">
				<div class="col-xs-4">Name:</div><input id="autoselect" class="col-xs-7" name=addanother type=text style="color:black"/> 
				</div>
			</div>
			<div class="panel-heading">	
				<input type="submit" value="Submit" style="color:black"/>
			</div>
	</div>
</form>


  <footer>
    <a href="#" class="js-modal-close">Close</a>
  </footer>
</div>


<button id="addnewcircle" href="#" data-modal-id="popup" style="text-align: center"> Add New </button>


</div>
</div>



<!--START: Select previous week  -->

<?php
include_once("connect2.php");

$week_query = "SELECT week FROM spreadlock GROUP BY (week);";

$result= mysqli_query($conn, $week_query) or die("Invalid query");



?>


<form method="get">
	<p>
		<label for="searchterm">Select Week:</label>
		<select name="search_week">
		<option value="">--</option>
		<?php
		while($row = mysqli_fetch_assoc($result)){
			echo "<option value='".$row['week']."'>".$row['week']."</option>";
		}
		?>
		</select>
		<input type="submit" name="search" id="search" value="Search">
	</p>
</form>

<?php 
$sql_week = "";
if (isset($_GET['search_week'])) { 
	$sql_week = $_GET['search_week'];
	$_SESSION['sql_week'] = $_GET['search_week'];
} else {
	$_SESSION['sql_week'] = "";
}



//echo $_SESSION['sql_week'];
 
 ?>
 
<p id="demo"></p>

<!--START: Table to display everyone's picks -->
<div>
	<form name="formNote" method="POST" action="deletepick.php">
		<table id="allPicks">
	
<?php
include_once('newtest.php'); // Query the mysql db to get values for spreadlock and matchups


// This get the first gray cell and then gets everyone's names
echo '<tr><td align="left" style="text-align: left; background-color:#e6e6e6; color:green; border-color: #262626"><div style="width: 225px;">Week '.$xxweek.'</div></td>';
foreach (array_combine($data['xid'], $data['xname']) as $xidx => $xnamex) {
	  printf('<td id="'.$xnamex.'" name="'.$xnamex.'">
	  <div>
		<input style="width:100px" name="checkboxNote[]" class="check-class" type="checkbox"  value='.$xidx.'>
	</div>
	<div class="col-xs-11" align="center"><b>'.$xnamex.'</b>
	</div></td>', htmlspecialchars($xnamex));

}

echo '</tr>';




//This gets all of the games from the spreadlock table and puts them in the html table

$countPick = 0;

for ($i = 1; $i <= 100; ++$i) {
	if (!empty(${"xxgame$i"}) && !empty(${"xxgame".($i).""})) {  //--if it's the last game on the list, echo tiebreaker...not sure why this works but it does...seems like it should be $i+1 but who knows
		echo '<tr><td style="text-align: left; background-color:#337ab7; color:white; border-color: #262626">'.${"xxgame$i"}.'</td>';
			
			// This puts everyone's picks into the table
			if(!empty($data['xgame'.($i).''])) {
				foreach($data['xgame'.($i).''] as $n) {
					$countPick += 1;
					printf('<td id="countPick" name="countPick">%s</td>', htmlspecialchars($n));
}
echo '</tr>';
} 

} else {
echo '<tr><td style="text-align: left; background-color:#224f77; color:white; border-color: #262626">'.preg_replace('/[0-9]+|-/', '',$xxtiebreaker).'</td>'; //preg_replace takes the spread out of the tiebreaker game
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
		
		
<!--START: Buttons at the bottom of the table (i.e. "Delete Selected", "Export to Excel", etc.) -->		
<div class="row">
	<div class="col-xs-2">
		<button id="deleteNote">Delete Selected</button>
	</form>
	</div>
<!--	
	<div class="col-xs-2">
		<form action="matchupscache.php" method="POST">
			<input type="submit" value="Start New Week">
		</form>
	</div>
-->

	<div class="col-xs-2">
		<form action="toxml.php" method="POST">
			<input type="submit" value="Export to Excel">
		</form>
	</div>
	
	<div class="col-xs-2">
		<form action="spreadlock.php" method="POST">
			<input type="submit" value="Update Spreads">
		</form>
	</div>
	
	<div class="col-xs-2">
		<form action="winlose.php" method="POST">
			<input type="submit" value="See Who Won">
		</form>
	</div>
</div>

</div>

<!-- Start: *Stats pulled from...info -->
<div class="col-xs-12"><hr></hr></div>
<div class="col-xs-12">*Stats pulled from <a target="_blank" href="http://www.footballlocks.com/nfl_lines.shtml">FootballLocks.com</a>...Last update: <p></p>
</div>







<!-- Start: Javascript to add new Names -->
<script>
$(function(){

var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

  $('button[data-modal-id]').click(function(e) {
    e.preventDefault();
    $("body").append(appendthis);
    $(".modal-overlay").fadeTo(500, 0.7);
    //$(".js-modalbox").fadeIn(500);
    var modalBox = $(this).attr('data-modal-id');
    $('#'+modalBox).fadeIn($(this).data());
  });  
  
  
$(".js-modal-close, .modal-overlay").click(function() {
  $(".modal-box, .modal-overlay").fadeOut(500, function() {
    $(".modal-overlay").remove();
  });
});
 
$(window).resize(function() {
  $(".modal-box").css({
    top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
    left: ($(window).width() - $(".modal-box").outerWidth()) / 2
  });
});
 
$(window).resize();
 
});
</script>


 
    <script>
 <?php 
 include_once('newtest.php');
 
 // START highlight names with less than 6 picks
$query8 = "SELECT * FROM matchups_cache WHERE week='".$thisweek."'";
$result3= mysqli_query($con, $query8) or die("Invalid query");
$card = "";
$ntest = "";
$numwins = "";
$blar = "";
$maxs = array_keys('', '');
$maxs2 = array_keys('', '');


while($row = mysqli_fetch_assoc($result3)){
	$card .= $row['name'].", ";
}

$card = explode(", ", $card);

foreach ($card as $p){
	$query9 = "SELECT game1, game2, game3, game4, game5, game6, game7, game8, game9, game10, game11, game12, game13, game14, game15, tiebreaker FROM matchups_cache WHERE name='$p' AND week='".$thisweek."';";
	$newcard = mysqli_query($con, $query9);
	while($row = mysqli_fetch_assoc($newcard)){
		 $maxs[$p] = $row;

			}

}	
//echo $blar;
//print_r($maxs['Michael']);
//echo "<hr>";


$coun = 0;
foreach($maxs as $k => $v) {
		$maxs2[$k] = count(array_filter($v));

	}


//print_r($maxs2);
//echo "<hr>";



$incomplete = "";
foreach($maxs2 as $k => $v) {
	if($v<6){
		$incomplete .= $k.", ";
		
	}

}



$incomplete2 = explode(', ', $incomplete);

 
foreach ($incomplete2 as $p) {
 	echo 'var t = parseInt($("#'.$p.'").index()) + 1;';
	echo "$('td:nth-child(' + t + ')').addClass('highlighted');";
}

if(!empty($incomplete)){
	
echo 'document.getElementById("demo").innerHTML = "We have detected incomplete data for the following user(s): <b>'.$incomplete.'</b>";';
} 

	?>
  </script>
  
  

  
</body>
</html>