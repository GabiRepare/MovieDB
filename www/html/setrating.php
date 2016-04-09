<?php
if (!isset($_POST['movieid'])){
    die("No movie argument");
}

if (!isset($_POST['rating'])){
    die("No movie argument");
}

if(isset($_SESSION['username'])){

  $usname=$_SESSION['username'];

  //database connection string
  $conn_string="host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";

  //Connect to database
  $dbconnx=pg_connect($conn_string) or die("Connection Failed");
}
else {
    die("Not logged in");
}

$queryx="SELECT rating FROM moviedb.rates WHERE rates.movieid='".$_POST['movieid']."' AND rates.userid='".$_SESSION['username']."';";
$resultx=pg_query($dbconnx, $queryx);
$date = date('Y-m-d');
if($rowx=pg_fetch_array($resultx)){
    $queryx="UPDATE moviedb.rates SET rateDate='".$date."', rating='".$_POST['rating']."'
             WHERE rates.userid='".$_SESSION["username"]."' AND rates.movieId='".$_POST['movieid']."';";
} else {
    $queryx="INSERT INTO moviedb.rates (userid, movieid, ratedate, rating)
             VALUES ('".$_SESSION["username"]."', '".$_POST['movieid']."', '".$date."', '".$_POST['rating']."');";
}

$resultx=pg_query($dbconnx, $queryx);

if(!$resultx){
    die("Error in SQL entry: ".pg_last_error());
}

pg_free_result($resultx);
pg_close($dbconnx);
?>
