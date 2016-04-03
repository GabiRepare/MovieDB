<!DOCTYPE html>
<html>
<head>
<title>Movie Exchange Home</title>
</head>
<?php
    $conn_string = "host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";
    $dbconn = pg_connect($conn_string) or die("Connection failed");
    

    $query = "SELECT movieName FROM moviedb.movie";

    $result = pg_query($dbconn, $query);
    if(!$result){
    	die("KABOOM".pg_last_error());
    }
echo $result;
?>
<body>
<div id="Header">Something</div>
<table>
<tr>
<th>Movie Name</th>
</tr>
<?php while($row = pg_fetch_array($result)) { ?>
<tr>
<td>
<?php echo $row[0]; ?>
</td>
</tr>
 <?php }?>
 </table>
</body>

</html>
