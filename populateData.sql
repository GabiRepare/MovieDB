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


INSERT INTO Users(userId, lName, fName, email, gender, ageRangeId)
VALUES
('user0001',
'Posey',
'Samson',
'samson.posey@gmail.com',
'm',
5),

('user0002',
'Franko',
'Victor',
'victor.franco@gmail.com',
'm',
6),

('user0003',
'Reisman',
'Posey',
'posey.reisman@gmail.com',
'm',
6),

('user0004',
'Worden',
'Sam',
'sam.worden@rogers.com',
'm',
6),

('user0005',
'Denton',
'Samus',
'samus.denton@hotmail.com',
'm',
6);

--DELETE FROM Movie
--SELECT * FROM Movie

INSERT INTO Movie(movieid, moviename, releasedate, description, country)
VALUES

('mov001',
'The Avengers',
'2012-5-4',
$$As Steve Rogers struggles to embrace his role in the modern world, he teams up with a fellow Avenger and Shield agent, the Black Widow, to battle a new threat from history: an assassin known as the Winter Soldier.    $$,
'Canada'),

('mov002',
'Avengers: Age of Ultron',
'2015-5-1',
$$Earth's mightiest heroes must come together and learn to fight as a team if they are to stop the mischievous Loki and his alien army from enslaving humanity.    $$,
'Canada'),

('mov003',
'Captain America: The First Avenger',
'2011-7-22',
$$The powerful but arrogant god Thor is cast out of Asgard to live amongst humans in Midgard (Earth), where he soon becomes one of their finest defenders.    $$,
'Canada'),

('mov004',
'Captain America: The Winter Soldier',
'2014-4-4',
$$Earth's mightiest heroes must come together and learn to fight as a team if they are to stop the mischievous Loki and his alien army from enslaving humanity.    $$,
'Canada'),

('mov005',
'The Dirty Dozen',
'1967-6-15',
$$A group of U.S. soldiers sneaks across enemy lines to get their hands on a secret stash of Nazi treasure.    $$,
'USA'),

('mov006',
'Jaws',
'1975-6-20',
$$During a preview tour, a theme park suffers a major power breakdown that allows its cloned dinosaur exhibits to run amok.    $$,
'USA'),

('mov007',
'ng">The Lord of the Rings: The Fellowship of the Ring',
'2001-12-9',
$$While Frodo and Sam edge closer to Mordor with the help of the shifty Gollum, the divided fellowship makes a stand against Sauron's new ally, Saruman, and his hordes of Isengard.    $$,
'Canada'),

('mov008',
'The Hobbit: An Unexpected Journey',
'2012-12-4',
$$The dwarves, along with Bilbo Baggins and Gandalf the Grey, continue their quest to reclaim Erebor, their homeland, from Smaug. Bilbo Baggins is in possession of a mysterious and magical ring.    $$,
'Canada'),

('mov009',
'Pirates of the Caribbean: On Stranger Tides',
'2011-5-20',
$$Blacksmith Will Turner teams up with eccentric pirate "Captain" Jack Sparrow to save his love, the governor's daughter, from Jack's former pirate allies, who are now undead.    $$,
'Canada'),

('mov010',
'Avatar',
'2009-12-8',
$$A reluctant hobbit, Bilbo Baggins, sets out to the Lonely Mountain with a spirited group of dwarves to reclaim their mountain home - and the gold within it - from the dragon Smaug.    $$,
'Canada'),

('mov011',
'Titanic',
'1997-12-9',
$$A paraplegic marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.    $$,
'Canada'),

('mov012',
'Gladiator',
'2000-5-5',
$$When his secret bride is executed for assaulting an English soldier who tried to rape her, William Wallace begins a revolt against King Edward I of England.    $$,
'USA'),

('mov013',
'The Matrix',
'1999-3-31',
$$While Frodo and Sam edge closer to Mordor with the help of the shifty Gollum, the divided fellowship makes a stand against Sauron's new ally, Saruman, and his hordes of Isengard.    $$,
'USA'),

('mov014',
'Forrest Gump',
'1994-7-6',
$$An insomniac office worker, looking for a way to change his life, crosses paths with a devil-may-care soap maker, forming an underground fight club that evolves into something much, much more...    $$,
'USA'),

('mov015',
'Inception',
'2010-7-16',
$$A team of explorers travel through a wormhole in space in an attempt to ensure humanity's survival.    $$,
'Canada'),

('mov016',
'Django Unchained',
'2012-12-5',
$$In Nazi-occupied France during World War II, a plan to assassinate Nazi leaders by a group of Jewish U.S. soldiers coincides with a theatre owner's vengeful plans for the same.    $$,
'Canada'),

('mov017',
'Inglourious Basterds',
'2009-8-21',
$$With the help of a German bounty hunter, a freed slave sets out to rescue his wife from a brutal Mississippi plantation owner.    $$,
'Canada'),

('mov018',
'The Wolf of Wall Street',
'2013-12-5',
$$With the help of a German bounty hunter, a freed slave sets out to rescue his wife from a brutal Mississippi plantation owner.    $$,
'Canada'),

('mov019',
'Interstellar',
'2014-11-7',
$$A thief, who steals corporate secrets through use of dream-sharing technology, is given the inverse task of planting an idea into the mind of a CEO.    $$,
'Canada'),

('mov020',
'Guardians of the Galaxy',
'2014-8-1',
$$Earth's mightiest heroes must come together and learn to fight as a team if they are to stop the mischievous Loki and his alien army from enslaving humanity.    $$,
'Canada'),

('mov021',
'Iron Man',
'2008-5-2',
$$With the world now aware of his identity as Iron Man, Tony Stark must contend with both his declining health and a vengeful mad man with ties to his father's legacy.    $$,
'Canada'),

('mov022',
'The Dark Knight',
'2008-7-18',
$$Eight years after the Joker's reign of anarchy, the Dark Knight, with the help of the enigmatic Selina, is forced from his imposed exile to save Gotham City, now on the edge of total annihilation, from the brutal guerrilla terrorist Bane.    $$,
'Canada'),

('mov023',
'The Dark Knight Rises',
'2012-7-20',
$$After training with his mentor, Batman begins his war on crime to free the crime-ridden Gotham City from corruption that the Scarecrow and the League of Shadows have cast upon it.    $$,
'Canada'),

('mov024',
'X-Men: Days of Future Past',
'2014-5-23',
$$As Steve Rogers struggles to embrace his role in the modern world, he teams up with a fellow Avenger and Shield agent, the Black Widow, to battle a new threat from history: an assassin known as the Winter Soldier.    $$,
'Canada'),

('mov025',
'Transformers',
'2007-7-2',
$$Sam Witwicky leaves the Autobots behind for a normal life. But when his mind is filled with cryptic symbols, the Decepticons target him and he is dragged back into the Transformers' war.    $$,
'Canada'),

('mov026',
'I Am Legend',
'2007-12-4',
$$In 2035, a technophobic cop investigates a crime that may have been perpetrated by a robot, which leads to a larger threat to humanity.    $$,
'Canada'),

('mov027',
'I, Robot',
'2004-7-16',
$$Years after a plague kills most of humanity and transforms the rest into monsters, the sole survivor in New York City struggles valiantly to find a cure.    $$,
'USA'),

('mov028',
'Men in Black',
'1997-7-2',
$$Agent J needs help so he is sent to find Agent K and restore his memory.    $$,
'Canada'),

('mov029',
'Men in Black II',
'2002-7-3',
$$Agent J travels in time to M.I.B.'s early days in 1969 to stop an alien from assassinating his friend Agent K and changing history.    $$,
'USA'),

('mov030',
'Independence Day',
'1996-7-2',
$$A police officer joins a secret organization that polices and monitors extra terrestrial interactions on planet earth.    $$,
'Canada'),

('mov031',
'The Day After Tomorrow',
'2004-5-28',
$$The aliens are coming and their goal is to invade and destroy Earth. Fighting superior technology, mankind's best weapon is the will to survive.    $$,
'Canada'),

('mov032',
'2012',
'2009-11-3',
$$Jack Hall, paleoclimatologist, must make a daring trek across America to reach his son, trapped in the cross-hairs of a sudden international storm which plunges the planet into a new Ice Age.    $$,
'Canada'),

('mov033',
'War of the Worlds',
'2005-6-29',
$$In a future where a special police unit is able to arrest murderers before they commit their crimes, an officer from that unit is himself accused of a future murder.    $$,
'Canada'),

('mov034',
'The Mummy',
'1999-5-7',
$$The mummified body of Imhotep is shipped to a museum in London, where he once again wakes and begins his campaign of rage and terror.    $$,
'USA'),

('mov035',
'Hellboy',
'2004-4-2',
$$The mythical world starts a rebellion against humanity in order to rule the Earth, so Hellboy and his team must save the world from the rebellious creatures.    $$,
'Canada');


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
'War'),

('top006',
'Adventure'),

('top007',
'Crime'),

('top008',
'History'),

('top009',
'Fantasy'),

('top010',
'Music'),

('top011',
'Horror'),

('top012',
'Romance'),

('top013',
'Comedy'),

('top014',
'Musical'),

('top015',
'Sport'),

('top016',
'Family'),

('top017',
'Western'),

('top018',
'Documentary'),

('top019',
'Biography'),

('top020',
'Heist'),

('top021',
'Mockumantary');


--DELETE FROM Watches
--SELECT * FROM Watches

INSERT INTO Rates(userId,movieId, watchDate, rating)
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

('act0001',
'Downey',
'Robert',
'1965-4-4',
'USA',
'male'),

('act0002',
'Evans',
'Chris',
'1981-6-13',
'USA',
'male'),

('act0003',
'Ruffalo',
'Mark',
'1967-11-22',
'USA',
'male'),

('act0004',
'Smulders',
'Cobie',
'1982-4-3',
'Canada',
'male'),

('act0005',
'Johansson',
'Scarlett',
'1984-11-22',
'USA',
'male'),

('act0006',
'Hemsworth',
'Chris',
'1983-8-11',
'Australia',
'male'),

('act0007',
'Renner',
'Jeremy',
'1971-1-7',
'USA',
'male'),

('act0008',
'Hiddleston',
'Tom',
'1981-2-9',
'UK',
'male'),

('act0009',
'Gregg',
'Clark',
'1962-4-2',
'USA',
'male');




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
('rol0008', 'act0004', '', 'Black Widow', 'female'),
('rol0009', 'act0005', 'Hill','Maria','female');
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
('mov001','rol0009'),
('mov002','rol0001'),
('mov002','rol0002'),
('mov002','rol0003'),
('mov002','rol0004'),
('mov002','rol0005'),
('mov002','rol0006'),
('mov002','rol0007'),
('mov002','rol0008'),
('mov002','rol0009'),
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
