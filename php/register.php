<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/style1.css/>
<title>Register</title>
</head>
<?php
$conn_string="host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";
$dbconn=pg_connect($conn_string) or die("Connection to the Server Failed");

	
	

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
	$yearborn=$_POST['yearborn'];
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
	
	if($row_count<1){
		echo "Username already exists, try again";
		pg_free_result($result1);
	}else{
	
	$query="INSERT INTO moviedb.USERS(userid, lname, fname, email, city, province, country, gender, agerange,
	yearborn, occupation, deviceused, password) VALUES ('$userid',$lname','$fname', $email, $city, $province, $country, $gender, $agerange, 
	$yearborn, $occupation, $deviceused, $password)";
	$result=pg_query($dbconn, $query);
	
	if(!$result){
		die("Error in SQL entry: ".pg_last_error());
	}
	echo "Registration Completed Successfully  "."<a href='moviedb/index.php'>Click here to login</a>";
	
	pg_free_result($result);
	pg_close($dbconn);
	}
}



?>

<body>
<div id="header">User Registration Form</div>
<form id="mainform" name="mainform" method="post" action="">
<p><label for="userid">Create a User ID: </label><br>
<input name="userid" type="text" id="userid" required/>
</p>
<p><label for="fname">First Name: </label><br>
<input name="fname" type="text" id="fname" required/>
</p>
<p><label for="lname">Last Name: </label><br>
<input name="lname" type="text" id="lname" required/>
</p>
<p><label for="email">Email: </label><br>
<input name="email" type="email" id="email" required/>
</p>
<p><label for="city">City: </label><br>
<input name="city" type="text" id="city" required/>
</p>
<p><label for="province">Province: </label><br>
<input name="province" type="text" id="province" required/>
</p>
<p><label for="country">Country: </label><br>
<input name="country" type="text" id="country" required/>
</p>
<p><label for "gender">Gender: </label><br>
<select name="gender" required>
	<option value="male">Male</option>
	<option value="female">Female</option>
	<option value="other">Other</option>
</select>
</p>

<p><label for="age">Age: </label><br>
<input name="age" type="number" id="age" maxlength="2" required/>
</p>
<p><label for="yearborn">Year Born: </label><br>
<input name="yearborn" type="number" id="yearborn" required/>
</p>
<p><label for="occupation">Occupation: </label><br>
<input name="occupation" type="text" id="occupation"/>
</p>
<p><label for="deviceused">What Type of device are you using?: </label><br>
<input name="deviceused" type="text" id="deviceused"/>
</p>
<p><label for="password">Create Password (4-20 characters) </label><br>
<input name="password" type="password" id="password" required/>
</p>
<p><label for="confpassword">Confirm Password (4-20 characters) </label><br>
<input name="confpassword" type="password" id="confpassword" required/>
</p>
<p>
<input type="submit" name="save" value="Register"/>
</p>
</form>
</body>
</html>