<?php
session_start();

if(isset($_SESSION['username'])){


  $usname=$_SESSION['username'];
  $msg="You are logged in, Welcome!"; 

 
}else{
	$msg= "You are not logged in!";
	
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>User Info</title>
</head>

<body>
<h3>"This is a logged in page to be seen throughout the site and modified accordingly."</h3><br>
<?php echo $msg ?>


</body>
</html>