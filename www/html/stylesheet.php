<?php header("Content-type: text/css; charset: UTF-8");
session_start();
$GLOBALS['NUM_RESULT_PAGE']=20;?>
@import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
body {
    font-family: Calibri, sans-serif;
    margin: 0px;
    background-color: white;
    display: inline-block;
    text-align: center;
}

#header h1 {
    color: blue;
    font-size: 40px;
    padding-top: 30px;
    margin: 0px;
    font-weight: normal;
    float: left;
}

td {
    /*border: 1px solid;*/
}

#header {
    background-color: black;
    height: 80px;
    margin: 0px;
    color: white;
}

#header p {
    float: right;
    display: inline;
    margin: 5px;
}

#header a {
    float: right;
    display: inline;
    margin: 5px;
    color: white;
}

#top_pane {
    padding-top: 10px;
    padding-left: 10px;
    padding-right: 10px;
    display: inline-flex;
    text-align: center;
    width: 52em;
}

#top_pane_filler {
    width: 30em;
    height: 3em;
}

#left_pane {
    float: left;
    padding-left: 10px;
    padding-bottom: 10px;
    box-sizing: border-box;
}

#right_pane {
    display: inline-block;
    text-align: left;
}

#browse_pane {
    background-color: #DDDDDD;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 10px;
    overflow: hidden;
    width: 50em;
    display: inline-block;
    padding-right: 1em;
    padding-left: 1em;
    padding-bottom: 1em;
}

#top_search {
    width: 100%;
    text-align: center;
}

#search_tool {
    width: 70%;
    text-align: center;
    display: inline-flex;
    height: 2em;
    line-height: 2em;
    margin: 0 auto;
    padding-top: 0.5em;
    padding-bottom: 0.5em;
}



#search_tool * {
    margin-top: 0;
    margin-bottom: 0;
    margin-left: 0.5em;
    margin-right: 0.5em;
    font-size: 1.25em;
}

#search_tool input {
    font-size: 1em;
    width: 60%;
}



.button {
    background-color: white;
    border: 1px solid;
    font-size: 1.25em;
    display: block;
    text-decoration: none;
    text-align: center;
    color: Black;
    vertical-align: middle;
    height: 1.5em;
    line-height: 1.5em;
    padding-left: 0.5em;
    padding-right: 0.5em;
    float: left;
}

.button:hover {
    background-color: grey;
}

#browse_btn {
    font-size: 1.5em;
    background-color: #DDDDDD;
    border: none;
    width: 10em;
    height: 3em;
    line-height: 3em;
}

#suggestions {
    font-size: 1.5em;
    background-color: #666666;
    border: none;
    color: white;
    width: 10em;
    height: 3em;
    line-height: 3em;
}

#suggestions:hover {
    background-color: blue;
}

#result_table {
    border-spacing: 0;
    margin: 5px;
    /*border: 1px dashed;*/
    /*border: none;*/
}

.result_entry {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
    border: 1px solid;
}

.movie_img {
    width: 5em;
}

.movie_img img{
    max-width:5em;
    width: auto;
    height: auto;
    margin: 0;
    padding: 0;
    float: left;
}

.movie_title_line {
    font-size: 1.25em;
    display: inline-flex;
}

.movie_title_line * {
    margin-top: 0.25em;
    margin-bottom: 0.25em;
}

.movie_year {
    padding-left: 0.5em;
    padding-right: 0.5em;
    color: #666666;
}

.rating_stars {
    border-collapse: collapse;
    padding: 0;
    width: 13em;
}

.movie_avg {
    text-align: right;
    font-size: 1.25em;
    font-weight: bold;
    padding-right: 1em;
}

.movie_nrating {
    text-align: right;
}

.page_link {
    margin: 0.5em;
}

#currentPage {
    font-size: 1.5em;
}

#page_links {
    text-align: center;
}

.bodyMovieInfo {
    text-align: left;
}

fieldset, label { margin: 0; padding: 0; }

/****** Style Star Rating Widget **************************************************************/
<?php

for ($i = 1; $i <= $GLOBALS['NUM_RESULT_PAGE']; $i++) { ?>
#rating<?php echo $i?> {
  border: none;
  float: right;
  text-align: right;
}

#rating<?php echo $i?> > input { display: none; }
#rating<?php echo $i?> > label:before {
  margin: 5px;
  font-size: 2em;
  font-family: FontAwesome;
  display: inline-block;
  content: "\f005";
}

#rating<?php echo $i?> > .half:before {
  content: "\f089";
  position: absolute;
}

#rating<?php echo $i?> > label {
  color: #FFF;
 float: right;
}

/***** CSS Magic to Highlight Stars on Hover *****/

#rating<?php echo $i?> > input:checked ~ label, /* show gold star when clicked */
#rating<?php echo $i?>:not(:checked) > label:hover, /* hover current star */
#rating<?php echo $i?>:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

#rating<?php echo $i?> > input:checked + label:hover, /* hover current star when changing rating */
#rating<?php echo $i?> > input:checked ~ label:hover,
#rating<?php echo $i?> > label:hover ~ input:checked ~ label, /* lighten current selection */
#rating<?php echo $i?> > input:checked ~ label:hover ~ label { color: #FFED85;  }
<?php }?>
