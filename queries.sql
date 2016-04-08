/*
Willem Kowal-7741241
CSI 2132
Winter 2016
Final project

List of the queries to be implemented.
*/

set search_path = "moviedb";

--***Movies, Actors, Directors, Studios, and Topics***
--A Select all information about a given movie (specify movieId)
SELECT * From Movie
WHERE movieId='mov001'

--B Select all information about all actors in a given movie (specify movie)
SELECT A.fName, A.lName, A.dOB, A.gender, A.country, R.fName, R.lName
FROM Movie M, Actor A, Role R, RolePlaysIn RPI
WHERE M.movieId = 'mov001'
AND RPI.movieId = M.movieId
AND RPI.roleId = R.roleId
AND R.actorId = A.actorId;

--C  Select the director's info and the studio's info for a given movie (specify movie)
SELECT D.fName, D.lName, D.country, D.gender, M.releaseDate, S.name, S.country
FROM Movie M, Director D, Studio S, Sponsors SP, Directs DI
WHERE S.studioId = SP.studioId
AND M.movieId = SP.movieid
AND  M.movieId = DI.movieId
AND D.directorId = DI.directorId
AND M.movieId='mov001'

--D Select the most popular actor (apears in most films), the directors that actor has worked with, and the studios that actor has worked for ***in 3 part3***


--Actor
SELECT A.actorId, counts.count, A.fName, A.lName, A.dOB, A.gender, A.country
FROM(
	SELECT COUNT(M.movieId) AS count, A.actorId AS act
	FROM Actor A, Movie M, Role R, RolePlaysIn RPI
	WHERE R.roleId=RPI.roleId
	AND A.actorId=R.actorId
	AND M.movieId = RPI.movieId
	GROUP BY A.actorId
	LIMIT 1
)counts, Actor A, Director D, Directs DIR, Studio S, Sponsors SPO
WHERE A.actorId=counts.act
GROUP BY counts.count,counts.act, A.fName, A.lName, A.dOB, A.gender, A.country, A.actorId
ORDER BY counts.count DESC


--Directors (specify actor)
SELECT DISTINCT  D.fName, D.lName, D.country, D.gender
FROM Actor A, Director D, Directs DIR, Role R, RolePlaysIn RPI, Movie M
WHERE A.actorId = 'act0001'
AND R.actorId = A.actorId
AND RPI.roleId = R.roleId
AND M.movieId = RPI.movieId
AND DIR.movieId = M.movieId
AND D.directorId = DIR.directorId

--Studios (specify actor)
SELECT DISTINCT S.name, S.country
FROM Actor A, Studio S, Sponsors SP, Role R, RolePlaysIn RPI, Movie M
WHERE A.actorId = 'act0001'
AND R.actorId = A.actorId
AND RPI.roleId = R.roleId
AND M.movieId = RPI.movieId
AND SP.movieId=M.movieId
AND SP.studioId = S.studioId

--E--no idea how to implement

--***Ratings of movies***
--f  Select the top 10 rated movies (as an average of ratings)
SELECT M.movieId, M.movieName, M.sumrating / M.numberRating AS avgRating
FROM Movie M
ORDER BY avgRating DESC
LIMIT 10

--G top 10 movies and their tags
SELECT M.movieName, M.description, M.releaseDate, Best.avgRating, T.description
FROM(
SELECT M.movieId, M.movieName, M.sumrating - M.numberRating AS avgRating
FROM Movie M
ORDER BY avgRating DESC
LIMIT 10) BEST, movie M, movieTopic MT, topic T
WHERE M.movieId = BEST.movieId
AND MT.movieId = M.movieId
AND MT.TopicId=T.topicId

--H this actually makes no sense

--I Select movies that have not been rated since jan 1, 2016
SELECT mov.movieId, M.movieName, M.releaseDate, M.description
FROM (
	SELECT MAX(W.watchDate)AS watchDate, W.movieId
	FROM watches W
	GROUP BY W.movieId
	ORDER BY W.movieID DESC)mov,
	Movie M
WHERE NOT(mov.watchDate>'2016-1-1')
AND M.movieId=mov.MovieId
GROUP BY mov.movieId, M.movieName, M.releaseDate, M.description

--J Select all movies and their directors name that recieved any rating below any rating given by user X (specify user)
SELECT D.lName, D.fName, M.releaseDate, M.movieName, M.movieId
FROM Director D, Directs DIR, Movie M, Watches W,
	(SELECT MAX(W.rating) AS rating
	FROM watches W
	WHERE W.userId='user0001'
	LIMIT 1
	)maxRating
WHERE W.rating < maxRating.rating
AND W.movieId = M.movieId
AND DIR.movieId = M.movieId
AND DIR.directorId=D.directorId
GROUP BY D.lName,D.fName, M.releaseDate, M.movieName, M.movieId
ORDER BY M.movieId

--K  Gets the movieId of the highest rated movie in a given category (specify topic)
SELECT mov.movieId, mov.S/mov.C AS avg
FROM(
	SELECT movies.sumRating AS S, movies.numberRating AS C, movies.movieId
	FROM(
		SELECT M.movieId, M.sumRating, M.numberRating
		FROM Movie M, MovieTopic MT
		WHERE MT.topicId = 'top001'
		AND M.movieId = MT.movieId
		)movies
	)mov
ORDER BY avg DESC
LIMIT 1
--L

--Get the highest rated topic
SELECT counts. topicId, counts.S/counts.C AS result
FROM(
SELECT T.topicId, SUM(M.sumRating)AS S, SUM(M.numberRating)AS C
FROM Movie M, MovieTopic MT, Topic T
WHERE MT.movieId=M.movieId
AND MT.topicId = T.topicId
GROUP BY T.topicId
ORDER BY T.topicId)AS counts
GROUP BY counts.topicId, result
ORDER BY result DESC
LIMIT 1

--***Users and their ratings***
--M The top 5 users that give the highest ratings
SELECT U.*, AVG(W.rating) AS ratings
FROM Users U, Watches W
WHERE U.userId=W.userId
GROUP BY U.userId
ORDER BY ratings DESC
LIMIT 5

--N Select the user that watches a given movie the most often (specify movie)
--This is redundant as users only watch a movie once....

SELECT U.userId, COUNT (W.userId) AS numWatches
FROM Users U, Watches W
WHERE U.userId=W.userId
AND W.movieId = 'mov001'
GROUP BY U.userId
ORDER BY numWatches DESC
LIMIT 1

--O Select the users that gave lower ratings than the highest rating of a given user (specify userId)
SELECT U.userId, U.email
FROM Users U,(
	SELECT MIN(W1.rating)AS min1, Max(W2.rating)AS max2, W1.userId
	FROM Watches W1, Watches W2
	WHERE NOT(W1.userId = W2.userId)
	AND W2.userId = 'user0002'
	GROUP BY W1.userId
	)numbers
WHERE U.userId=numbers.userId
AND numbers.min1 < numbers.max2
GROUP BY U.userId, U.email

--P select the user that gives the most varied ratings within a specified category

SELECT MAX(ratings.big-ratings.small)AS diversities, ratings.userId
FROM
	(SELECT  MAX(W.rating)AS big, MIN(W.rating)AS small, U.userId
	FROM MovieTopic MT, Movie M, Watches W, Users U
	WHERE MT.topicId='top001'
	AND M.movieId=MT.movieId
	AND W.movieId=M.movieId
	AND U.userId=W.userId
	GROUP BY  U.userId)ratings
GROUP BY ratings.userId
ORDER BY diversities DESC
LIMIT 1