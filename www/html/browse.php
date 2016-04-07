<?php
session_start();

if(isset($_SESSION['username'])){

  $usname=$_SESSION['username'];

  //database connection string
  $conn_string="host=www2.movieexchange.xyz port=5432 dbname=moviedb user=guest password=20160411Due";

  //Connect to database
  $dbconn=pg_connect($conn_string) or die("Connection Failed");

  $msg="You are logged in, Welcome!";


}else{
	header("Location: index.php");
}
?>

<!Doctype html>
<html>
    <header>
        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
        <title>Browse MovieExchange</title>
    </header>
    <body>
        <div id="header">
            <h1>MovieExchange</h1>
            <a href="logout.php">Logout</a>
            <a href="">Account Settings</a>
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
                    <tr><td><table class="result_entry">
                        <tr class="first_entry_row">
                            <td class="movie_img" rowspan="4"><img src="http://ia.media-imdb.com/images/M/MV5BOTAzODEzNDAzMl5BMl5BanBnXkFtZTgwMDU1MTgzNzE@._V1_UX182_CR0,0,182,268_AL_.jpg"</td>
                            <td class="movie_title_line">
                                <p>Star Wars Episode VII - The Force Awakens</p>
                                <p class="movie_year">(2015)</p>
                            </td>
                            <td class="rating_stars" rowspan="2">
                                <fieldset class="rating">
                                    <input type="radio" id="star5" name="rating1" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                    <input type="radio" id="star4half" name="rating1" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                    <input type="radio" id="star4" name="rating1" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                    <input type="radio" id="star3half" name="rating1" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                    <input type="radio" id="star3" name="rating1" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                    <input type="radio" id="star2half" name="rating1" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                    <input type="radio" id="star2" name="rating1" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                    <input type="radio" id="star1half" name="rating1" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                    <input type="radio" id="star1" name="rating1" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                    <input type="radio" id="starhalf" name="rating1" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td class="movie_directors">Director(s): Dude1, Dude2</td>
                        </tr>
                        <tr>
                            <td class="movie_actors">Actor(s): Actor1, Actor2, Actor3, ...</td>
                            <td class="movie_avg">3.4/5</td>
                        </tr>
                        <tr>
                            <td class="movie_topics">Topics: topic1, topic2, topic3, ...</td>
                            <td class="movie_nrating">(2342 ratings)</td>
                        </tr>
                    </table></td></tr>
                    <tr><td><table class="result_entry">
                        <tr class="first_entry_row">
                            <td class="movie_img" rowspan="4"><img src="http://ia.media-imdb.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_UX182_CR0,0,182,268_AL_.jpg"</td>
                            <td class="movie_title_line">
                                <p>Inception</p>
                                <p class="movie_year">(2010)</p>
                            </td>
                            <td class="rating_stars" rowspan="2">
                                <fieldset class="rating">
                                    <input type="radio" class="star5" name="rating2" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                    <input type="radio" class="star4half" name="rating2" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                    <input type="radio" class="star4" name="rating2" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                    <input type="radio" class="star3half" name="rating2" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                    <input type="radio" class="star3" name="rating2" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                    <input type="radio" class="star2half" name="rating2" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                    <input type="radio" class="star2" name="rating2" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                    <input type="radio" class="star1half" name="rating2" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                    <input type="radio" class="star1" name="rating2" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                    <input type="radio" class="starhalf" name="rating2" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td class="movie_directors">Director(s): Dude1, Dude2</td>
                        </tr>
                        <tr>
                            <td class="movie_actors">Actor(s): Actor1, Actor2, Actor3, ...</td>
                            <td class="movie_avg">4.4/5</td>
                        </tr>
                        <tr>
                            <td class="movie_topics">Topics: topic1, topic2, topic3, ...</td>
                            <td class="movie_nrating">(5344 ratings)</td>
                        </tr>
                    </table></td></tr>
                </table>
            </div>
        </div>
    </body>
</html>