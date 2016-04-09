<?php
//Constants
$GLOBALS['MAX_NAME']=5;
$GLOBALS['NUM_RESULT_PAGE']=20; //Also in stylesheet.php

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

//Set the default sort
if (!isset($_POST['sort'])){
    $_POST['sort']="dec-views";
}

if (isset($_POST['rating'])){
    include 'setrating.php';
}

$numberOfPages = 1;

$sortPSQL = "ORDER BY numberRating DESC";
if ($_POST['sort']==='inc-views'){
    $sortPSQL="ORDER BY numberRating ASC";
} elseif ($_POST['sort']==='dec-rating') {
    $sortPSQL="ORDER BY avg DESC";
} elseif ($_POST['sort']==='inc-rating') {
    $sortPSQL="ORDER BY avg ASC";
} elseif ($_POST['sort']==='dec-date') {
    $sortPSQL="ORDER BY releaseDate DESC";
} elseif ($_POST['sort']==='inc-date') {
    $sortPSQL="ORDER BY releaseDate DESC";
}

$currentPage = 1;
if (isset($_GET['page'])){
    $currentPage = $_GET['page'];
}

$resultRangePSQL = "LIMIT ".$GLOBALS['NUM_RESULT_PAGE'];
if ($currentPage !== 1){
    $numberToSkip = ($currentPage-1)*$GLOBALS['NUM_RESULT_PAGE'];
    $resultRangePSQL = "LIMIT ".$GLOBALS['NUM_RESULT_PAGE']." OFFSET ".$numberToSkip;
}

$searchPSQL = "";
if ($_POST['constraint']==="actor"){
    $searchPSQL = "WHERE EXISTS (SELECT * FROM moviedb.actor
                                INNER JOIN moviedb.role
                                ON role.actorId=actor.actorId
                                INNER JOIN moviedb.RolePlaysIn
                                ON RolePlaysIn.roleId=role.roleId
                                WHERE RolePlaysIn.movieId=movie.movieId AND
                                (LOWER(actor.fname) LIKE LOWER('%".$_POST['search_text']."%') OR
                                 LOWER(actor.lname) LIKE LOWER('%".$_POST['search_text']."%')))";
} elseif ($_POST['constraint']==="title"){
    $searchPSQL = "WHERE LOWER(movie.movieName) LIKE LOWER('%".$_POST['search_text']."%')";
} elseif ($_POST['constraint']==="director"){
    $searchPSQL = "WHERE EXISTS (SELECT * FROM moviedb.director
                                 INNER JOIN moviedb.directs
                                 ON directs.directorid=director.directorid
                                 WHERE directs.movieid=movie.movieId AND
                                 (LOWER(director.fname) LIKE LOWER('%".$_POST['search_text']."%') OR
                                  LOWER(director.lname) LIKE LOWER('%".$_POST['search_text']."%')))";
} elseif ($_POST['constraint']==="topic"){
    $searchPSQL = "WHERE EXISTS (SELECT * FROM moviedb.topic
                                 INNER JOIN moviedb.MovieTopic
                                 ON MovieTopic.topicId=topic.topicId
                                 WHERE MovieTopic.movieId=movie.movieId AND
                                 LOWER(topic.description) LIKE LOWER('%".$_POST['search_text']."%')))";
} elseif ($_POST['constraint']==="studio"){
    $searchPSQL = "WHERE EXISTS (SELECT * FROM moviedb.Studio
                                 INNER JOIN moviedb.Sponsors
                                 ON Sponsors.studioId=Studio.studioId
                                 WHERE Sponsors.movieId=movie.movieId AND
                                 LOWER(studio.name) LIKE LOWER('%".$_POST['search_text']."%')))";
}
?>

<!Doctype html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="stylesheet.php"/>
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
            <div id="top_pane_filler"></div>
        </div>
        <div id="browse_pane">
            <div id="left_pane"></div>
            <div id="right_pane">
                <div id="top_search">
                    <form id="search_tool" method="post">
                        <p>Keywords:</p>
                        <input required type="text" name="search_text">
                        <select name="constraint" required>
                            <option value="actor">Actor</option>
                        	<option selected value="title">Title</option>
                        	<option value="director">Director</option>
                        	<option value="topic">Topic</option>
                        	<option value="studio">Studio</option>
                        </select>
                        <input type="submit" class="button" value="Search"/>
                    </form>
                    <form method="post">
                        <label>Sort: </label>
                        <select name="sort" required onchange=" this.form.submit();">
                            <option <?php echo ($_POST['sort']=='dec-views')?'selected':''?> value="dec-views">Most seen first</option>
                            <option <?php echo ($_POST['sort']=='inc-views')?'selected':''?> value="inc-views">Less seen first</option>
                            <option <?php echo ($_POST['sort']=='dec-rating')?'selected':''?> value="dec-rating">Best rated first</option>
                            <option <?php echo ($_POST['sort']=='inc-rating')?'selected':''?> value="inc-rating">Worst rated first</option>
                            <option <?php echo ($_POST['sort']=='dec-date')?'selected':''?> value="dec-date">Most recent first</option>
                            <option <?php echo ($_POST['sort']=='inc-date')?'selected':''?> value="inc-date">Oldest first</option>
                        </select>
                    </form>
                </div>
                <table id="result_table">
                    <?php
                        $query0 = "SELECT COUNT(*)
                                  FROM moviedb.movie ".$searchPSQL.";";
                        $result0 = pg_query($dbconn, $query0);
                        if(!$result0){
                            die("Error reading database".pg_last_error().$query0);
                        }
                        $numberOfPages=(int)ceil(1.0*pg_fetch_array($result0)[0]/$GLOBALS['NUM_RESULT_PAGE']);
                        pg_free_result($result0);
                        $query = "SELECT movieId, movieName, EXTRACT(YEAR FROM releaseDate) AS year, numberRating, ROUND(1.0*sumRating/numberRating,1) AS avg, releaseDate
                                  FROM moviedb.movie ".$searchPSQL." ".$sortPSQL." ".$resultRangePSQL.";";
                        $result = pg_query($dbconn, $query);
                        if(!$result){
                            die("Error reading database".pg_last_error().$query);
                        }

                         $x = 1;
                         while($row = pg_fetch_array($result)) {
                             $query_rating = "SELECT rating FROM moviedb.rates WHERE rates.movieid='".$row[0]."' AND rates.userid='".$_SESSION['username']."';";
                             $result_rating = pg_query($dbconn, $query_rating);
                             $rating = -1;
                             if ($row_rating = pg_fetch_array($result_rating)){
                                 $rating = $row_rating[0];
                             }
                             pg_free_result($result_rating);
                             ?>

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
                                <form action="" method="post">
                                <fieldset id="rating<?php echo $x?>">
                                    <input onchange='this.form.submit();' type="radio" id="star5<?php echo $x?>" name="rating" value="5.0" <?php echo ($rating==5.0)?'checked':'' ?>/><label class = "full" for="star5<?php echo $x?>" title="Awesome - 5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star4half<?php echo $x?>" name="rating" value="4.5" <?php echo ($rating==4.5)?'checked':'' ?>/><label class="half" for="star4half<?php echo $x?>" title="Pretty good - 4.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star4<?php echo $x?>" name="rating" value="4.0" <?php echo ($rating==4.0)?'checked':'' ?>/><label class = "full" for="star4<?php echo $x?>" title="Pretty good - 4 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star3half<?php echo $x?>" name="rating" value="3.5" <?php echo ($rating==3.5)?'checked':'' ?>/><label class="half" for="star3half<?php echo $x?>" title="Meh - 3.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star3<?php echo $x?>" name="rating" value="3.0" <?php echo ($rating==3.0)?'checked':'' ?>/><label class = "full" for="star3<?php echo $x?>" title="Meh - 3 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star2half<?php echo $x?>" name="rating" value="2.5" <?php echo ($rating==2.5)?'checked':'' ?>/><label class="half" for="star2half<?php echo $x?>" title="Kinda bad - 2.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star2<?php echo $x?>" name="rating" value="2.0" <?php echo ($rating==2.0)?'checked':'' ?>/><label class = "full" for="star2<?php echo $x?>" title="Kinda bad - 2 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star1half<?php echo $x?>" name="rating" value="1.5" <?php echo ($rating==1.5)?'checked':'' ?>/><label class="half" for="star1half<?php echo $x?>" title="Meh - 1.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star1<?php echo $x?>" name="rating" value="1.0" <?php echo ($rating==1.0)?'checked':'' ?>/><label class = "full" for="star1<?php echo $x?>" title="Sucks big time - 1 star"></label>
                                    <input onchange='this.form.submit();' type="radio" id="starhalf<?php echo $x?>" name="rating" value="0.5" <?php echo ($rating==0.5)?'checked':'' ?>/><label class="half" for="starhalf<?php echo $x?>" title="Sucks big time - 0.5 stars"></label>
                                    <input type="hidden" name="movieid" value="<?php echo $row[0];?>">
                                </fieldset>
                            </form>
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
                                                                            die("Error reading database".pg_last_error());
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
                                                                         pg_free_result($result2);
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
                                                                        die("Error reading database".pg_last_error());
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
                                                                     pg_free_result($result2);
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
                                                                    die("Error reading database".pg_last_error());
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
                                                                 pg_free_result($result2);
                                                             ?></td>
                            <td class="movie_nrating">(<?php echo $row[3]?> ratings)</td>
                        </tr>
                    </table></td></tr>
                    <?php $x++; }?>
                </table>
                <div id="page_links">
                <label>Page: </label>
                <?php
                for($y = 1; $y <= $numberOfPages; $y++){
                    if ($y == $currentPage){
                        ?><a href="browse.php?page=<?php echo $y?>" class="page_link" id="currentPage"><strong><?php echo $y ?></strong></a><?php
                    } else {
                        ?><a href="browse.php?page=<?php echo $y?>" class="page_link"><?php echo $y ?></a><?php
                    }
                }
                pg_free_result($result);
                pg_close($dbconn);
                ?>
            </div>
            </div>
        </div>
    </body>
</html>
