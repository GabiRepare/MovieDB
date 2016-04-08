<!Doctype html>
<html>
    <header>
        <title>Movie Information</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
    </header>
    <body>
<?php
    session_start();

    if (!isset($_GET['movieid'])){
        header("Location:http://www2.movieexchange.xyz:8080/browse.php");
        die("No movie argument");
    }

    if(isset($_SESSION['username'])){

      $usname=$_SESSION['username'];

      //database connection string
      $conn_string="host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";

      //Connect to database
      $dbconn=pg_connect($conn_string) or die("Connection Failed");

      $msg="You are logged in, Welcome!";


    }else{
    	header("Location:index.php");
        die("Not logged in");
    }

    $query = "SELECT movieId, movieName, description, country, releaseDate, numberRating,
            ROUND(1.0*sumRating/numberRating,3) AS avg FROM moviedb.movie
            WHERE movie.movieId='".$_GET['movieid']."';";
    $result = pg_query($dbconn, $query);
    $query2 = "SELECT fName||' '||lName AS name FROM moviedb.director
               INNER JOIN moviedb.directs
               ON directs.directorid=director.directorid
               WHERE directs.movieid='".$_GET['movieid']."';";
    $result2 = pg_query($dbconn, $query2);
    $query3 = "SELECT DISTINCT actor.fName||' '||actor.lName AS name FROM moviedb.actor
               INNER JOIN moviedb.role
               ON role.actorId=actor.actorId
               INNER JOIN moviedb.RolePlaysIn
               ON RolePlaysIn.roleId=role.roleId
               WHERE RolePlaysIn.movieId='".$_GET['movieid']."';";
    $result3 = pg_query($dbconn, $query3);
    $query4 = "SELECT topic.description FROM moviedb.topic
               INNER JOIN moviedb.MovieTopic
               ON MovieTopic.topicId=topic.topicId
               WHERE MovieTopic.movieId='".$_GET['movieid']."';";
    $result4 = pg_query($dbconn, $query4);

    if(!$result){
       die("Error in movie query".pg_last_error());
   } elseif (!$result2) {
       die("Error in movie director query".pg_last_error());
   } elseif (!$result3) {
       die("Error in movie actor query".pg_last_error());
   } elseif (!$result4) {
       die("Error in movie topic query".pg_last_error());
   }

    while($row = pg_fetch_array($result)) {?>
        <h1><?php echo $row[1]?></h1>
        <h2>Actor number: <?php echo max(pg_num_rows($result3,1))?></h2>
        <img src="/images/<?php echo $row[0]?>.jpg">
        <table>
            <tr><td><strong>Country:</strong></td>
                <td><?php echo $row[3]?></td></tr>
            <tr><td><strong>Release Date:</strong></td>
                <td><?php echo $row[4]?></td></tr>
            <tr><td><strong>Average Rating:</strong></td>
                <td><?php echo $row[6]?>/5 ( <?php echo $row[5]?> ratings)</td></tr>
            <tr><td><strong>Description:</strong></td>
                <td><?php echo $row[2]?></td></tr>
            <tr><td rowspan="<?php echo max(pg_num_rows($result2,1))?>"><strong>Director(s):</strong></td>
                <td><?php if ($row2 = pg_fetch_array($result2)){
                                echo $row2[0];
                            } ?></dt></tr>
            <?php while ($row2 = pg_fetch_array($result2)){?>
            <tr><td><?php echo $row2[0]?></td></tr><?php } ?>
            <tr><td rowspan="<?php echo max(pg_num_rows($result3,1))?>"><strong>Actors:</strong></td>
                <td><?php if ($row3 = pg_fetch_array($result3)){
                                echo $row3[0];
                            } ?></dt></tr>
            <?php while ($row3 = pg_fetch_array($result3)){?>
            <tr><td><?php echo $row3[0]?></td></tr><?php } ?>
            <tr><td rowspan="<?php echo max(pg_num_rows($result4,1))?>"><strong>Topic(s):</strong></td>
                <td><?php if ($row4 = pg_fetch_array($result4)){
                                echo $row4[0];
                            } ?></dt></tr>
            <?php while ($row4 = pg_fetch_array($result4)){?>
            <tr><td><?php echo $row4[0]?></td></tr><?php } ?>
        </table>
<?php }
 ?>
 </body>
 </html>
