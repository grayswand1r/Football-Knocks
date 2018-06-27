<?php
/*
Template Name: matchupscache.php
*/
?><?php

header("Location: pool.php");

include_once('connect2.php');
    if (mysqli_connect_errno($con))
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }


$sql = "INSERT INTO `matchups_cache` (name, game1, game2, game3, game4, game5, game6, game7, game8, game9, game10, game11, game12, game13, tiebreaker, week) select name, game1, game2, game3, game4, game5, game6, game7, game8, game9, game10, game11, game12, game13, tiebreaker, week from `matchups`";

$sql2 = "truncate table matchups";
$sql3 = "truncate table wins";

mysqli_query($con, $sql);
mysqli_query($con, $sql2);
mysqli_query($con, $sql3);

mysqli_close($con);


?>