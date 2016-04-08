<?php
//Constants
$GLOBALS['MAX_NAME']=5;
$GLOBALS['NUM_RESULT_PAGE']=20;

session_start();

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
?>

<!Doctype html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
        <title>Browse MovieExchange</title>
        <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js'>
        </script>
    </head>
    <body>
        <div id="header">
            <h1>MovieExchange</h1>
            <a href="logout.php">Logout</a>
            <a href="settings.php">Account Settings</a>
            <p>Logged as <?php echo $usname ?></p>
        </div>
        <div id="top_pane">
            <a href="" class="button" id="browse_btn">Rate Movies</a>
            <a href="" class="button" id="suggestions">Suggestions</a>
        </div>
        <div id="browse_pane">
            <div id="left_pane"></div>
            <div id="right_pane">
                <div id="top_search">
                    <div id="search_tool">
                        <p>Keywords:</p>
                        <input type="text" name="search_text">
                        <a class="button" href="">Search</a>
                    </div>
                </div>
                <table id="result_table">
                    <?php
                        $query = "SELECT movieId, movieName, EXTRACT(YEAR FROM releaseDate) AS year, numberRating, ROUND(1.0*sumRating/numberRating,1) AS avg FROM moviedb.movie ORDER BY avg DESC LIMIT ".(string)$GLOBALS['NUM_RESULT_PAGE'].";";
                         $result = pg_query($dbconn, $query);
                         if(!$result){
                         	die("KABOOM".pg_last_error());
                         }
                         while($row = pg_fetch_array($result)) { ?>

                    <tr><td><table class="result_entry">
                        <tr class="first_entry_row">
                            <td class="movie_img" rowspan="4"><a href="movieinfo.php?movieid=<?php echo $row[0];?>" target="_blank" title="Click for more info">
                                <img src="/images/<?php echo $row[0]?>.jpg">
                            </a></td>
                            <td class="movie_title_line">
                                <p><?php echo $row[1]?></p>
                                <p class="movie_year">(<?php echo $row[2]?>)</p>
                            </td>
                            <td class="rating_stars" rowspan="2">
                                <fieldset class="rating">
                                    <input onchange='this.form.submit();' type="radio" id="star5" name="rating1" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star4half" name="rating1" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star4" name="rating1" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star3half" name="rating1" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star3" name="rating1" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star2half" name="rating1" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star2" name="rating1" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star1half" name="rating1" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star1" name="rating1" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                    <input onchange='this.form.submit();' type="radio" id="starhalf" name="rating1" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td class="movie_directors">Director(s): <?php
                                                                        $query2 = "SELECT fName||' '||lName AS name FROM moviedb.director
                                                                                   INNER JOIN moviedb.directs
                                                                                   ON directs.directorid=director.directorid
                                                                                   WHERE directs.movieid='$row[0]';";
                                                                         $result2 = pg_query($dbconn, $query2);
                                                                         if(!$result2){
                                                                            die("KABOOM".pg_last_error());
                                                                        } else {
                                                                             if($row2 = pg_fetch_array($result2)){
                                                                                 echo $row2[0];
                                                                             }
                                                                             $count = 1;
                                                                             while($count < $GLOBALS['MAX_NAME'] and $row2 = pg_fetch_array($result2)) {
                                                                                 echo ', '.$row2[0];
                                                                                 $count++;
                                                                             }
                                                                             if ($row2 = pg_fetch_array($result2)){
                                                                                 echo ', ...';
                                                                             }
                                                                         }
                                                                        ?></td>
                        </tr>
                        <tr>
                            <td class="movie_actors">Actor(s): <?php
                                                                    $query2 = "SELECT DISTINCT actor.fName||' '||actor.lName AS name FROM moviedb.actor
                                                                               INNER JOIN moviedb.role
                                                                               ON role.actorId=actor.actorId
                                                                               INNER JOIN moviedb.RolePlaysIn
                                                                               ON RolePlaysIn.roleId=role.roleId
                                                                               WHERE RolePlaysIn.movieId='$row[0]';";
                                                                     $result2 = pg_query($dbconn, $query2);
                                                                     if(!$result2){
                                                                        die("KABOOM".pg_last_error());
                                                                    } else {
                                                                         if($row2 = pg_fetch_array($result2)){
                                                                             echo $row2[0];
                                                                         }
                                                                         $count = 1;
                                                                         while($count < $GLOBALS['MAX_NAME'] and $row2 = pg_fetch_array($result2)) {
                                                                             echo ', '.$row2[0];
                                                                             $count++;
                                                                         }
                                                                         if ($row2 = pg_fetch_array($result2)){
                                                                             echo ', ...';
                                                                         }
                                                                     }
                                                                ?></td>
                            <td class="movie_avg"><?php echo $row[4]?>/5</td>
                        </tr>
                        <tr>
                            <td class="movie_topics">Topics: <?php
                                                                $query2 = "SELECT topic.description FROM moviedb.topic
                                                                           INNER JOIN moviedb.MovieTopic
                                                                           ON MovieTopic.topicId=topic.topicId
                                                                           WHERE MovieTopic.movieId='$row[0]';";
                                                                 $result2 = pg_query($dbconn, $query2);
                                                                 if(!$result2){
                                                                    die("KABOOM".pg_last_error());
                                                                } else {
                                                                     if($row2 = pg_fetch_array($result2)){
                                                                         echo $row2[0];
                                                                     }
                                                                     $count = 1;
                                                                     while($count < $GLOBALS['MAX_NAME'] and $row2 = pg_fetch_array($result2)) {
                                                                         echo ', '.$row2[0];
                                                                         $count++;
                                                                     }
                                                                     if ($row2 = pg_fetch_array($result2)){
                                                                         echo ', ...';
                                                                     }
                                                                 }
                                                             ?></td>
                            <td class="movie_nrating">(<?php echo $row[3]?> ratings)</td>
                        </tr>
                    </table></td></tr>
                    <?php }?>
                </table>
            </div>
        </div>
    </body>
</html>
