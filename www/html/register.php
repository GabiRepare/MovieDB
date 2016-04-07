<?php
$conn_string="host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";
$dbconn=pg_connect($conn_string) or die("Connection to the Server Failed");
$success=0;
	
	

if(array_key_exists('save',$_POST)){
	
	$userid=$_POST['userid'];
	$lname=$_POST['lname'];
	$fname=$_POST['fname'];
	$email=$_POST['email'];
	$city=$_POST['city'];
	$province=$_POST['province'];
	$country=$_POST['country'];
	$gender=$_POST['gender'];
	$agerange=$_POST['age'];
	$occupation=$_POST['occupation'];
	$deviceused=$_POST['deviceused'];
	$password=$_POST['password'];
	
	
	
	
	$checkuserid="SELECT * FROM moviedb.USERS WHERE userid=$1";
	$stmt=pg_prepare($dbconn, "ps", $checkuserid);
	$result1=pg_execute($dbconn,"ps",array($userid));
	
	
	if(!$result1){
		die("Error in SQL: ".pg_last_error());
	}
	
	$row_count=pg_num_rows($result1);
	
	if($row_count>0){
		$success=1;
		pg_free_result($result1);
	}else{
	
	
	$query="INSERT INTO moviedb.USERS(userid, lname, fname, email, city, province, country, gender, agerange,
	occupation, deviceused, password) VALUES ('$userid','$lname','$fname', '$email', '$city', '$province', '$country', '$gender', '$agerange', 
	'$occupation', '$deviceused', '$password')";
	$result=pg_query($dbconn, $query);
	
	if(!$result){
		die("Error in SQL entry: ".pg_last_error());
	}
	$success=2; 
	
	
	pg_free_result($result);
	}
	pg_close($dbconn);
	
}

	
?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/style1.css/>
<title>Register</title>
</head>

<body>
<div id="header"></div>
<center>
User Registration Form<br>
<?php
if($success==2){
	echo "<span style=color:#FF0000;text-align:center;>Registration Completed Successfully  "."<a href='index.php'>Click here to login</a></span>";
}else if($success==1){ 
echo "<span style=color:#FF0000;text-align:center;>Username already exists, try again</span>";
}else{}
  

 
 ?>
 <br>

<form id="mainform" name="mainform" method="post" action="">
<p><label for="userid">Create a User ID: </label><br>
<input  name="userid" type="text" style = "font-size:7pt;" id="userid" required/>
</p>
<p><label for="fname">First Name: </label><br>
<input name="fname" type="text" style = "font-size:7pt;" id="fname" required/>
</p>
<p><label for="lname">Last Name: </label><br>
<input name="lname" type="text" style = "font-size:7pt;" id="lname" required/>
</p>
<p><label for="email">Email: </label><br>
<input name="email" type="email" style = "font-size:7pt;" id="email" required/>
</p>
<p><label for="city">City: </label><br>
<input name="city" type="text" style = "font-size:7pt;" id="city" required/>
</p>
<p><label for="province">Province: </label><br>
<input name="province" type="text" style = "font-size:7pt;" id="province" required/>
</p>
<p><label for="country">Country: </label><br>
<input name="country" type="text" style = "font-size:7pt;" id="country" required/>
</p>
<p><label for "gender">Gender: </label><br>
<select name="gender" required>
	<option value="male">Male</option>
	<option value="female">Female</option>
</select>
</p>
<p><label for "age">Your age: </label><br>
<select name="age" required>
	<option value="1">Under 6</option>
	<option value="2">6-10</option>
	<option value="3">11-15</option>
	<option value="4">16-20</option>
	<option value="5">21-30</option>
	<option value="6">31-60</option>
	<option value="7">60+</option>
</select>
</p>
<p><label for="occupation">Occupation (optional): </label><br>
<input name="occupation" type="text" style = "font-size:7pt;" id="occupation"/>
</p>
<p><label for="deviceused">What Type of device are you using?(optional): </label><br>
<input name="deviceused" type="text" style = "font-size:7pt;" id="deviceused"/>
</p>
<p><label for="password">Create Password (4-20 characters) </label><br>
<input name="password" type="password" style = "font-size:7pt;" id="password" pattern=".{4,20}" required/>
</p>
<p><label for="confpassword">Confirm Password (4-20 characters) </label><br>
<input name="confpassword" type="password" style = "font-size:7pt;" id="confpassword" pattern=".{4,20}" required/>
</p>
<p>
<input type="submit" name="save" value="Register"/>
</p>
</form>
 </center>
 <script>
 var password = document.getElementById("password")
  , confirm_password = document.getElementById("confpassword");

function validatePassword(){
  if(password.value != confpassword.value) {
    confpassword.setCustomValidity("Passwords Don't Match");
  } else {
    confpassword.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confpassword.onkeyup = validatePassword;
 
 </script>
 
 
</body>
</html>