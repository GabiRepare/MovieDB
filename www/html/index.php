<?php
session_start();

//Skip login page if user already logged in
if(isset($_SESSION['username'])){
    header("Location:browse.php");
    die("Already logged in");
}

if(isset($_POST['username'])) {

//database connection string
$conn_string="host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";

//Connect to database
$dbconn=pg_connect($conn_string) or die("Connection Failed");
//get info user entered
  $usname=strip_tags($_POST["username"]);
  $paswd=strip_tags($_POST["password"]);

//database connection string
$conn_string="host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";

//Connect to database
$dbconn=pg_connect($conn_string) or die("Connection Failed");

$query="SELECT * FROM moviedb.USERS WHERE Userid=$1 AND Password=$2";
$stmt=pg_prepare($dbconn, "ps", $query);
$result=pg_execute($dbconn,"ps",array($usname, $paswd));

 if(!$result){
	 die("Error in SQL: ".pg_last_error());

 }

 $row_count=pg_num_rows($result);
 if($row_count>0){
	 $_SESSION['username']=$usname;
	 header("Location:browse.php");
	 die("Succesfully logged In");
 }else{
	 echo "Wrong login or password, please try again.";
 }
pg_free_result($result);
pg_close($dbconn);

}

?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="stylesheet.php"/>
<title>Welcome</title>
</head>

<body>
<div id="wrapper">
<h1>Welcome to MovieExchange</h1>
<form id="form" action="index.php" method="post" enctype="multipart/form-data">
Username: <input type="text" name="username" /> <br/><br/>
Password: <input type="password" name="password" /> <br/>
<input type="submit" value="Login" name="Submit" /><br/>
Not registered yet? <a href='register.php'>Click Here to Register</a>
</form>


</body>

</html>
