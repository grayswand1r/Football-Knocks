<?php
session_start();
header("Location: pool.php?search_week=".$_SESSION['sql_week']."&search=Search");

include_once('connect2.php');
    if (mysqli_connect_errno($con))
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

$cheks = implode("','", $_POST['checkboxNote']);
$sql = "delete from matchups where id in ('$cheks')";
$sqlone = "delete from matchups_cache where id in ('$cheks')";
$sql2 = "delete from wins where id in ('$cheks')";


mysqli_query($con, $sql);
mysqli_query($con, $sqlone);
mysqli_query($con, $sql2);
mysqli_close($con);

?>