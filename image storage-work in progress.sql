set search_path = "moviedb";

ALTER TABLE Movie ADD COLUMN Image OID;

INSERT INTO Movie (image)
VALUES (lo_import('C:\Users\Willem Kowal\bday.jpg'));

SELECT * FROM Movie;
UPDATE Movie SET Image = ('16518') WHERE movieId ='mov001';


ALTER ROLE wkowa046 SUPERUSER 

SELECT lo_export(Movie.image, '/tmp/outimage.jpg')
FROM Movie
WHERE movieId='mov001';


SELECT image FROM Movie WHERE movieId='mov001';