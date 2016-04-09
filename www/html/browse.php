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

//Set the default sort
if (!isset($_POST['sort'])){
    $_POST['sort']="dec-views";
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
    $currentPage = $_POST['page'];
}

$resultRangePSQL = "LIMIT ".$GLOBALS['NUM_RESULT_PAGE'];
if ($currentPage !== 1){
    $numberToSkip = ($currentPage-1)*$GLOBALS['NUM_RESULT_PAGE'];
    $resultRangePSQL = "LIMIT ".$GLOBALS['NUM_RESULT_PAGE']." OFFSET ".$numberToSkip;
}

$searchPSQL = "";
if (isset($_POST['constraint'])==="actor"){
    $searchPSQL = " WHERE EXISTS (SELECT * FROM moviedb.actor
                                 INNER JOIN moviedb.role
                                 ON role.actorId=actor.actorId
                                 INNER JOIN moviedb.RolePlaysIn
                                 ON RolePlaysIn.roleId=role.roleId
                                 WHERE RolePlaysIn.movieId=movie.movieId AND
                                 (actor.fname LIKE '%".$_POST['search_text']."%' OR
                                  actor.lname LIKE '%".$_POST['search_text']."%')";
} elseif (isset($_POST['constraint'])==="title"){
    $searchPSQL = " WHERE movie.movieName LIKE '%".$_POST['search_text']."%'";
} elseif (isset($_POST['constraint'])==="director"){
    $searchPSQL = " WHERE EXISTS (SELECT * FROM moviedb.director
                                  INNER JOIN moviedb.directs
                                  ON directs.directorid=director.directorid
                                  WHERE directs.movieid=movie.movieId AND
                                  (director.fname LIKE '%".$_POST['search_text']."%' OR
                                   director.lname LIKE '%".$_POST['search_text']."%')";
} elseif (isset($_POST['constraint'])==="topic"){
    $searchPSQL = " WHERE EXISTS (SELECT * FROM moviedb.topic
                                  INNER JOIN moviedb.MovieTopic
                                  ON MovieTopic.topicId=topic.topicId
                                  WHERE MovieTopic.movieId=movie.movieId AND
                                  topic.description LIKE '%".$_POST['search_text']."%')";
} elseif (isset($_POST['constraint'])==="studio"){
    $searchPSQL = " WHERE EXISTS (SELECT * FROM moviedb.Studio
                                  INNER JOIN moviedb.Sponsors
                                  ON Sponsors.studioId=Studio.studioId
                                  WHERE Sponsors.movieId=movie.movieId AND
                                  studio.name LIKE '%".$_POST['search_text']."%')";
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
                    <form id="search_tool" method="post">
                        <p>Keywords:</p>
                        <input type="text" name="search_text">
                        <select name="constraint" required>
                            <option value="actor">Actor</option>
                        	<option selected value="title">Title</option>
                        	<option value="director">Director</option>
                        	<option value="topic">Topic</option>
                        	<option value="studio">Studio</option>
                        </select>
                        <input type="submit" clas="button" value="Search"/>
                    </form>
                    <form method="post">
                        <label>Sort: </label>
                        <select name="sort" required onchange="if (this.selectedIndex) this.form.submit();">
                            <option selected value="dec-views">Most seen first</option>
                            <option value="inc-views">Less seen first</option>
                            <option value="dec-rating">Best rated first</option>
                            <option value="inc-rating">Worst rated first</option>
                            <option value="dec-date">Most recent first</option>
                            <option value="inc-date">Oldest first</option>
                        </select>
                    </form>
                </div>
                <table id="result_table">
                    <?php
                        $query0 = "SELECT COUNT(*)
                                  FROM moviedb.movie ".$searchPSQL.";";
                        $result0 = pg_query($dbconn, $query0);
                        if(!$result0){
                            die("Error reading database".pg_last_error());
                        }
                        $numberOfPages=(int)ceil(1.0*pg_fetch_array($result0)[0]/$GLOBALS['NUM_RESULT_PAGE']);
                        $query = "SELECT movieId, movieName, EXTRACT(YEAR FROM releaseDate) AS year, numberRating, ROUND(1.0*sumRating/numberRating,1) AS avg, releaseDate
                                  FROM moviedb.movie ".$sortPSQL." ".$resultRangePSQL.$searchPSQL.";";
                        $result = pg_query($dbconn, $query);
                        if(!$result){
                            die("Error reading database".pg_last_error());
                        }

                         $x = 1;
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
                                <form action="setrating.php" method="post">
                                <fieldset id="rating<?php echo $x?>">
                                    <input onchange='this.form.submit();' type="radio" id="star5" name="rating" value="5.0" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star4" name="rating" value="4.0" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star3" name="rating" value="3.0" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star2" name="rating" value="2.0" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                    <input onchange='this.form.submit();' type="radio" id="star1" name="rating" value="1.0" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                    <input onchange='this.form.submit();' type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
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
                                                             ?></td>
                            <td class="movie_nrating">(<?php echo $row[3]?> ratings)</td>
                        </tr>
                    </table></td></tr>
                    <?php $x++; }?>
                </table>
                <label>Page: </label>
                <?php
                for($y = 1; $y <= $numberOfPages; $y++){
                    ?><a href="browse.php?page=<?php echo $y?>"><?php echo $y ?></a><?php
                }
                ?>
            </div>
        </div>
    </body>
</html>
