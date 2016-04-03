/*
Willem Kowal-7741241
CSI 2132
Winter 2016
Final project

Creates the schema for the movie database.
*/

CREATE SCHEMA moviedb;
set search_path = "moviedb";

CREATE TABLE AgeRange(
ageRangeId smallint,
minimum smallint,
maximum smallint,
CONSTRAINT AgeRangePKey PRIMARY KEY (ageRangeId)
);

INSERT INTO AgeRange(ageRangeId, minimum, maximum)
VALUES (1,0,5),(2,6,10),(3,11,15),(4,16,20),(5,21,30),(6,31,60),(7,61,120);

CREATE TABLE Users(
userId varchar(20),
lName varchar(20),
fName varchar(20),
email varchar(40),
gender varchar(6),
ageRangeId smallint,
CONSTRAINT UserPKey PRIMARY KEY (userId),
CONSTRAINT UserEmail CHECK (email LIKE '%@%.%'),
CONSTRAINT UserGender CHECK (gender = 'm' OR gender = 'f'OR gender = 'male' OR gender = 'female'),
FOREIGN KEY (ageRangeId) REFERENCES AgeRange (ageRangeId)
);

CREATE TABLE Topic(
topicId varchar(20),
description text,
CONSTRAINT TopicPKey PRIMARY KEY (topicId)
);


CREATE TABLE Movie(
movieId varchar(20),
movieName varchar(100),
releaseDate DATE,
description TEXT,
country varchar(40),
sumRating integer DEFAULT 0,
numberRating integer DEFAULT 0,
CONSTRAINT MoviePKey PRIMARY KEY (movieId)
);


CREATE TABLE Rates(
userId varchar(20),
movieId varchar(20),
watchDate DATE,
rating integer,
CONSTRAINT RatesPKey PRIMARY KEY (userId, movieId),
CONSTRAINT RatesRating CHECK (rating >=0 AND rating <=5),
FOREIGN KEY (userId) REFERENCES Users,
FOREIGN KEY (movieId) REFERENCES Movie
);

CREATE OR REPLACE FUNCTION movie_rating_update() RETURNS TRIGGER AS $$
    DECLARE
        delta_movieId       varchar(20);
        delta_numberRating  integer;
        delta_sumRating     integer;
    BEGIN
        IF (TG_OP = 'DELETE') THEN
            delta_movieId = old.movieId;
            delta_numberRating = -1;
            delta_sumRating = -1*OLD.rating;
        ELSIF (TG_OP = 'UPDATE') THEN
            delta_movieId = OLD.movieId;
            delta_numberRating = 0;
            delta_sumRating = NEW.rating - OLD.rating;
        ELSIF (TG_OP = 'INSERT') THEN
            delta_movieId = NEW.movieId;
            delta_numberRating = 1;
            delta_sumRating = NEW.rating;
        END IF;
        UPDATE Movie
            SET numberRating = numberRating + delta_numberRating,
                sumRating = sumRating + delta_sumRating
                WHERE movieId = delta_movieId;
        RETURN NULL;
    END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER ratingUpdate
AFTER INSERT OR UPDATE OR DELETE ON Rates
FOR EACH ROW EXECUTE PROCEDURE movie_rating_update();

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
CONSTRAINT ActorGender CHECK (gender = 'm' OR gender = 'f' OR gender = 'male' OR gender = 'female')
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

CREATE TABLE RolePlaysIn(
movieId varchar(20),
RoleId varchar(20),
CONSTRAINT ActorPlaysPKey PRIMARY KEY (movieId, roleId),
FOREIGN KEY (movieId) REFERENCES Movie,
FOREIGN KEY(roleId) REFERENCES Role
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
