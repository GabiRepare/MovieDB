<?php
session_start();
session_destroy();
if(isset($_SESSION['username'])){
  $msg="You are now logged out";
}else{
  $msg="Could not log you out";
}

?>

<html>
<head>
<meta charset="UTF-8">
<Title>Logout</title>
</head>

<body>
<?php echo $msg; ?><br>
<a href="index.php">Click here to return to login screen</a>


</body>
</html>