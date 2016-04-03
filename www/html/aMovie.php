<!DOCTYPE html>
<html>
<head>
<title>Movie Exchange Movie</title>
</head>
<?php
    $conn_string = "host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";
    $dbconn = pg_connect($conn_string) or die("Connection failed");
    
$movId='mov001';
    $query = "SELECT movieName, releaseDate, description, country FROM moviedb.movie WHERE movieId='mov001'";

    $result = pg_query($dbconn, $query);
    if(!$result){
    	die("KABOOM".pg_last_error());
    }
?>
<body>
<div id="Header"></div>
<table>
<tr>
<th>Movie Name</th>
<th>Release Date</th>
<th>Description</th>
<th>Country</th>
</tr>
<?php while($row = pg_fetch_array($result)) { ?>
<tr>
<td>
<?php echo $row[0]; ?>
<td><?php echo $row[1]; ?></td>
<td><?php echo $row[2]; ?></td>
<td><?php echo $row[3]; ?></td>
</td>
</tr>
 <?php }?>
 </table>
</body>

</html>
