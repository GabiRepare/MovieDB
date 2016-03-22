/*
Willem Kowal-7741241
CSI 2132
Winter 2016
Final project

The SQL code to populate the database with a basic set of test data.
*/

set search_path = "moviedb";

--DELETE FROM Users
--SELECT * FROM Users


INSERT INTO Users(userId, lName, fName, email, city, province, country, gender, agerange, yearborn, occupation, deviceused)
VALUES
('user0001',
'Posey',
'Samson',
'samson.posey@gmail.com',
'Clint',
'Walker',
'USA',
'male',
26,
1918,
'Private',
'M3 Grease Gun'),

('user0002',
'Franko',
'Victor',
'victor.franco@gmail.com',
'John',
'Cassavetes',
'USA',
'male',
38,
1906,
'Private',
'M3 Grease Gun'),

('user0003',
'Reisman',
'Posey',
'posey.reisman@gmail.com',
'Lee',
'Marvion',
'USA',
'male',
34,
1910,
'Major',
'MP40'),

('user0004',
'Worden',
'Sam',
'sam.worden@rogers.com',
'Ernest',
'Borgnine',
'USA',
'male',
44,
1900,
'Major General',
'none'),

('user0005',
'Denton',
'Samus',
'samus.denton@hotmail.com',
'Robert',
'Webber',
'USA',
'male',
43,
1901,
'Brigadier General',
'his wits');

--DELETE FROM Movie
--SELECT * FROM Movie

INSERT INTO Movie(movieid, moviename, releasedate, description, country)
VALUES 
('mov001',
'The Avengers',
'2012-05-04',
$$Earths mightiest heroes must come together and learn to fight as a team if they are to stop the mischievous Loki and his alien army from enslaving humanity.$$,
'USA'),

('mov002',
'Avengers: Age of Ultron',
'2015-05-01',
$$When Tony Stark and Bruce Banner try to jump-start a dormant peacekeeping program called Ultron, things go horribly wrong and it's up to Earth's Mightiest Heroes to stop the villainous Ultron from enacting his terrible plans.$$,
'USA'),
('mov003',
'Captain America: The First Avenger',
'2011-06-22',
$$Steve Rogers, a rejected military soldier transforms into Captain America after taking a dose of a "Super-Soldier serum". But being Captain America comes at a price as he attempts to take down a war monger and a terrorist organization.$$,
'USA'),

('mov004',
'Captain America: The Winter Soldier',
'2014-04-04',
$$As Steve Rogers struggles to embrace his role in the modern world, he teams up with a fellow Avenger and Shield agent, the Black Widow, to battle a new threat from history: an assassin known as the Winter Soldier.$$,
'USA'),

('mov005',
'The Dirty Dozen',
'1967-06-15',
$$A US Army Major is assigned a dozen convicted murderers to train and lead them into a mass assassination mission of German officers in World War II.$$,
'USA');

--DELETE FROM Topic
--SELECT * FROM Topic

INSERT INTO Topic (topicId, description)
VALUES
('top001',
'Action'),

('top002',
'Adventure'),

('top003',
'Sci-Fi'),

('top004',
'Thriller'),

('top005',
'War');


--DELETE FROM Watches
--SELECT * FROM Watches

INSERT INTO Watches(userId,movieId, watchDate, rating)
VALUES
('user0001', 'mov002', '2013-03-19', null),
('user0002', 'mov002', '2016-01-13', 4),
('user0002', 'mov004', '2015-12-22',3),
('user0002', 'mov005', '1998-09-17',5),
('user0003', 'mov001', '2013-04-14', 2),
('user0003', 'mov003', '2011-07-04', 4),
('user0004', 'mov001', '2014-11-03', 4),
('user0005', 'mov005', '2010-05-16', 3 );

--DELETE FROM MovieTopic
--SELECT * FROM MovieTopic

INSERT INTO MovieTopic(movieId, topicId)
VALUES
('mov001', 'top001'),
('mov001', 'top002'),
('mov001', 'top003'),
('mov002', 'top001'),
('mov002', 'top002'),
('mov002', 'top003'),
('mov003', 'top001'),
('mov003', 'top002'),
('mov003', 'top003'),
('mov004', 'top001'),
('mov004', 'top002'),
('mov004', 'top003'),
('mov005', 'top001'),
('mov005', 'top002'),
('mov005', 'top004'),
('mov005', 'top005');

--DELETE FROM Actor
--SELECT * FROM Actor

INSERT INTO Actor(actorId, lName, fName, dOB, country, gender)
VALUES
('act0001', 'Downey','Robert', '1965-04-04', 'USA', 'male'),
('act0002', 'Evans', 'Chris', '1981-06-13', 'USA', 'male'),
('act0003', 'Ruffalo', 'Mark', '1967-11-22', 'USA', 'male'),
('act0004', 'Johansson', 'Scarlett', '1984-11-22', 'USA', 'female');

--DELETE FROM Role
--SELECT * FROM Role

INSERT INTO Role(roleId, actorId, lName, fName, gender)
VALUES 
('rol0001', 'act0001', 'Stark', 'Tony', 'male'),
('rol0002', 'act0002', 'Rogers', 'Steve', 'male'),
('rol0003', 'act0003', 'Banner', 'Bruce', 'male'),
('rol0004', 'act0004', 'Romanoff', 'Natasha', 'female'),
('rol0005', 'act0001', '', 'Iron Man', 'male'),
('rol0006', 'act0002', '', 'Captain America','male'),
('rol0007', 'act0003', '', 'Hulk', 'male'),
('rol0008', 'act0004', '', 'Black Widow', 'female');

--DELETE FROM RolePlaysIn
--SELECT * FROM RolePlaysIn

INSERT INTO RolePlaysIn(movieId, roleId)
VALUES
('mov001','rol0001'),
('mov001','rol0002'),
('mov001','rol0003'),
('mov001','rol0004'),
('mov001','rol0005'),
('mov001','rol0006'),
('mov001','rol0007'),
('mov001','rol0008'),
('mov002','rol0001'),
('mov002','rol0002'),
('mov002','rol0003'),
('mov002','rol0004'),
('mov002','rol0005'),
('mov002','rol0006'),
('mov002','rol0007'),
('mov002','rol0008'),
('mov003','rol0002'),
('mov003','rol0006'),
('mov004','rol0002'),
('mov003','rol0004'),
('mov004','rol0006'),
('mov003','rol0008');


--DELETE FROM Director
--SELECT * FROM Director

INSERT INTO Director(directorId, lName, fName, country, gender, dOB)
VALUES
('dir0001', 'Whedon', 'Joss', 'USA', 'male', '1964-06-23'),--aveng x2
('dir0002', 'Johnston', 'Joe', 'USA', 'male', '1950-05-13'), --capt 1
('dir0003', 'Russo', 'Joe', 'USA', 'male', '1976-12-18'),
('dir0004', 'Russo', 'Anthony', 'USA', 'male',null),
('dir0005', 'Aldrich', 'Robert', 'USA', 'male', '1918-08-09');

--DELETE FROM Directs
--SELECT * FROM Directs

INSERT INTO Directs(directorId, movieId)
VALUES
('dir0001', 'mov001'),
('dir0001', 'mov002'),
('dir0002', 'mov003'),
('dir0003', 'mov004'),
('dir0004', 'mov004'),
('dir0005', 'mov005');


--DELETE FROM Studio
--SELECT * FROM Studio

INSERT INTO Studio(studioId, name, country)
VALUES
('stu001', 'MGM', 'USA'),
('stu002', 'Marvel Studios', 'USA');

--DELETE FROM Sponsors
--SELECT * FROM Sponsors

INSERT INTO Sponsors(studioId, movieId)
VALUES
('stu001', 'mov001'),
('stu001', 'mov002'),
('stu001', 'mov003'),
('stu001', 'mov004'),
('stu002', 'mov005');

