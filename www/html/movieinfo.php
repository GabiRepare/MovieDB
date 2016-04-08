<!Doctype html>
<html>
    <header>
        <title>Movie Information</title>
    </header>
    <body>
<?php
    if (!isset($_GET['movieid'])){
        header("Location: browse.php");
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
    	header("Location: index.php");
        die("Not logged in");
    }

    $query = "SELECT movieId, movieName, description, country, releaseDate, numberRating,
            ROUND(1.0*sumRating/numberRating,3) AS avg FROM moviedb.movie ORDER BY avg DESC
            LIMIT ".(string)$GLOBALS['NUM_RESULT_PAGE'].";";
    $result = pg_query($dbconn, $query);
    $query2 = "SELECT fName||' '||lName AS name FROM moviedb.director
               INNER JOIN moviedb.directs
               ON directs.directorid=director.directorid
               WHERE directs.movieid='$row[0]';";
    $result2 = pg_query($dbconn, $query2);
    $query3 = "SELECT DISTINCT actor.fName||' '||actor.lName AS name FROM moviedb.actor
               INNER JOIN moviedb.role
               ON role.actorId=actor.actorId
               INNER JOIN moviedb.RolePlaysIn
               ON RolePlaysIn.roleId=role.roleId
               WHERE RolePlaysIn.movieId='$row[0]';";
    $result3 = pg_query($dbconn, $query3);
    $query4 = "SELECT topic.description FROM moviedb.topic
               INNER JOIN moviedb.MovieTopic
               ON MovieTopic.topicId=topic.topicId
               WHERE MovieTopic.movieId='$row[0]';";
    $result4 = pg_query($dbconn, $query4);

    if(!$result or !$result2 or !$result3 or !$result4){
       die("KABOOM".pg_last_error());
    }
    while($row = pg_fetch_array($result)) {?>
        <h1><?php echo $row[1]?></h1>
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
        </table>
<?php }
 ?>
 </body>
 </html>