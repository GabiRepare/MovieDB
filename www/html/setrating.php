<?php
session_start();

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
  $dbconn=pg_connect($conn_string) or die("Connection Failed");
}
else {
    die("Not logged in");
}

$date = date('Y-m-d');
$query="INSERT INTO moviedb.Rates(userid, movieId, rateDate, rating) VALUES ('".$_SESSION["username"]."', '".$_POST['movieid']."', '".$date."', '".$_POST['rating']."');";
$result=pg_query($dbconn, $query);

if(!$result){
    die("Error in SQL entry: ".pg_last_error());
}

?>
<!-- Test -->
<!Doctype html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
        <title>Test</title>
        </script>
    </head>
    <body>
        Test
    </body>
</html>
