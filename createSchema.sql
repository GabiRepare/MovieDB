/*
Willem Kowal-7741241
CSI 2132
Winter 2016
Final project

Creates the schema for the movie database.
*/

CREATE SCHEMA moviedb;
set search_path = "moviedb";

CREATE TABLE Users(
userId varchar(20),
lName varchar(20),
fName varchar(20),
email varchar(40),
city varchar(40),
province varchar(40),
country varchar(40),
gender varchar(6),
ageRange integer,
yearBorn integer,
occupation varchar(40),
deviceUsed varchar(40),
CONSTRAINT UserPKey PRIMARY KEY (userId),
CONSTRAINT UserEmail CHECK (email LIKE '%@%.@'),
CONSTRAINT UserGender CHECK (gender = 'male' OR gender = 'female'),
CONSTRAINT UserYearBorn CHECK (yearBorn > 0 AND yearBorn < 2016)
);

CREATE TABLE Topic(
topicId varchar(20),
description text,
CONSTRAINT TopicPKey PRIMARY KEY (topicId)
);


CREATE TABLE Movie(
movieId varchar(20),
movieName varchar(40),
releaseDate DATE,
description TEXT,
country varchar(40),
CONSTRAINT MoviePKey PRIMARY KEY (movieId)
);


CREATE TABLE Watches(
userId varchar(20),
movieId varchar(20),
watchDate DATE,
rating integer,
CONSTRAINT WatchesPKey PRIMARY KEY (userId, movieId),
CONSTRAINT WathcesRating CHECK (rating >=0 AND rating <=5),
FOREIGN KEY (userId) REFERENCES Users,
FOREIGN KEY (movieId) REFERENCES Movie
);


CREATE TABLE MovieTopic(
topicId varchar(20),
movieId varchar(20),
subtitles boolean,
CONSTRAINT MovieTopicPKey PRIMARY KEY (topicId, movieId),
FOREIGN KEY (topicId) REFERENCES Topic,
FOREIGN KEY (movieId) REFERENCES Movie
);

CREATE TABLE Actor(
actorId varchar(20),
lName varchar(20),
fName varchar(20),
dOB DATE,
country varchar(40),
gender varchar(6),
CONSTRAINT ActorPKey PRIMARY KEY (actorId),
CONSTRAINT ActorGender CHECK (gender = 'male' OR gender = 'female')
);

CREATE TABLE Role(
roleId varchar(20),
actorId varchar(20),
lName varchar(20),
fName varchar(20),
gender varchar(6),
CONSTRAINT RolePKey PRIMARY KEY (roleId),
CONSTRAINT RoleGender CHECK (gender = 'male' OR gender = 'female'),
FOREIGN KEY (actorId) REFERENCES Actor
);

CREATE TABLE ActorPlays(
movieId varchar(20),
actorId varchar(20),
CONSTRAINT ActorPlaysPKey PRIMARY KEY (movieId, actorId),
FOREIGN KEY (movieId) REFERENCES Movie,
FOREIGN KEY(actorId) REFERENCES Actor
);


CREATE TABLE Director(
directorId varchar(20),
lName varchar(20),
fName varchar(20),
country varchar(40),
gender varchar(6),
dOB DATE,
CONSTRAINT DirectorPKey PRIMARY KEY (directorId),
CONSTRAINT DirectorGender CHECK (gender = 'male' OR gender = 'female')
);

CREATE TABLE Directs(
directorId varchar(20),
movieId varchar(20),
CONSTRAINT DirectsPKey PRIMARY KEY (directorId, movieId),
FOREIGN KEY (directorId) REFERENCES Director,
FOREIGN KEY (movieId) REFERENCES Movie
);

CREATE TABLE Studio(
studioId varchar(20),
name varchar(20),
country varchar(40),
CONSTRAINT StudioPKey PRIMArY KEY (studioId)
);

CREATE TABLE Sponsors(
studioId varchar(20),
movieId varchar(20),
PRIMARY KEY (studioId, movieId),
FOREIGN KEY (studioId) REFERENCES Studio,
FOREIGN KEY (movieId) REFERENCES Movie
);