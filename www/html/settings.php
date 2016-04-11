<?php
session_start();
$msg=null;

if(isset($_SESSION['username'])){

  $usname=$_SESSION['username'];
  
  //database connection string
$conn_string="host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";

//Connect to database
$dbconn=pg_connect($conn_string) or die("Connection Failed");

$query="SELECT * FROM moviedb.USERS WHERE Userid=$1";
$stmt=pg_prepare($dbconn, "ps", $query);
$result=pg_execute($dbconn,"ps",array($usname));

while($row=pg_fetch_row($result)){
	$userid=$row[0];
	$lname=$row[1];
	$fname=$row[2];
	$email=$row[3];
	$gender=$row[4];
	$agerangeid=$row[6];
	
}
if($agerangeid==0){
	$age="Under 6";
}else if($agerangeid==1){
	$age="6-10";
}else if($agerangeid==2){
	$age="11-15";
}else if($agerangeid==3){
	$age="16-20";
}else if($agerangeid==4){
	$age="21-30";
}else if($agerangeid==5){
	$age="31-60";
}else{
	$age="60+";
}
pg_free_result($result);


	$conn_string="host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";
	$dbconn=pg_connect($conn_string) or die("Connection to the Server Failed");
	
	if(array_key_exists('save',$_POST)){
		$newUserid=$_POST['newUserid'];
		$newLname=$_POST['newLname'];
		$newFname=$_POST['newFname'];
		$newEmail=$_POST['newEmail'];
		$newGender=$_POST['newGender'];
		$newAgerange=$_POST['newAge'];
		$newPassword=$_POST['newPassword'];
		
		$query="UPDATE moviedb.USERS SET userid='$newUserid', lname='$newLname', fname='$newFname', email='$newEmail', gender='$newGender', agerangeid='$newAgerange', password='$newPassword' WHERE userid='$usname'";
		
		$result=pg_query($dbconn,$query);
		if(!$result){
			die("Error in SQL entry: ".pg_last_error());
		}
		
		
		pg_free_result($result);
		pg_close($dbconn);
		header("Location:index.php");
		}
		pg_close($dbconn);
	


}else{
	header("Location:index.php");
	
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>User Settings</title>
</head>

<body>
<?php echo $msg; ?>
<h1>Update your settings here</h1><br>

Current Settings: <br>
Username: <?php echo $userid ?><br>
First Name: <?php echo $fname ?><br>
Last Name: <?php echo $lname ?><br>
Email: <?php echo $email ?><br>
Age: <?php echo $age ?><br>
<p>
New Settings: <br>
</p>
<form id="mainform" name="mainform" method="post" action="">
<p><label for="newUserid">Create a User ID: </label><br>
<input  name="newUserid" type="text" id="newUserid" required/>
</p>
<p><label for="newFname">First Name: </label><br>
<input name="newFname" type="text" id="newFname" required/>
</p>
<p><label for="newLname">Last Name: </label><br>
<input name="newLname" type="text" id="newLname" required/>
</p>
<p><label for="newEmail">Email: </label><br>
<input name="newEmail" type="email" id="newEmail" required/>
</p>
<p><label for "newGender">Gender: </label><br>
<select name="newGender" required>
	<option value="m">Male</option>
	<option value="f">Female</option>
</select>
</p>
<p><label for "newAge">Your age: </label><br>
<select name="newAge" required>
	<option value="1">Under 6</option>
	<option value="2">6-10</option>
	<option value="3">11-15</option>
	<option value="4">16-20</option>
	<option value="5">21-30</option>
	<option value="6">31-60</option>
	<option value="7">60+</option>
</select>
</p>
<p><label for="newPassword">Create Password (4-20 characters) </label><br>
<input name="newPassword" type="password" style = "font-size:7pt;" id="newPassword" pattern=".{4,20}" required/>
</p>
<p><label for="newConfpassword">Confirm Password (4-20 characters) </label><br>
<input name="newConfpassword" type="password" style = "font-size:7pt;" id="newConfpassword" pattern=".{4,20}" required/>
</p>

<input type="submit" name="save" value="Update"/>
</p>
</form>

 </center>
 <script>
 var password = document.getElementById("newPassword")
  , confirm_password = document.getElementById("newConfpassword");
function validatePassword(){
  if(password.value != confpassword.value) {
    password.setCustomValidity("Passwords Don't Match");
  } else {
    password.setCustomValidity('');
  }
}
password.onchange = validatePassword;
confpassword.onkeyup = validatePassword;
 </script>



</body>
</html>