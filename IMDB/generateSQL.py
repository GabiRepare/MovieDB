#!/usr/bin/python
import csv
import random
import time
from random import randint

def convStr (original):
    original = original.replace('\'','\'\'')
    original = original.replace('\"','\"\"')
    return original

def strTimeProp(start, end, format, prop):
    """Get a time at a proportion of a range of two formatted times.

    start and end should be strings specifying times formated in the
    given format (strftime-style), giving an interval [start, end].
    prop specifies how a proportion of the interval to be taken after
    start.  The returned time will be in the specified format.
    """

    stime = time.mktime(time.strptime(start, format))
    etime = time.mktime(time.strptime(end, format))

    ptime = stime + prop * (etime - stime)

    return time.localtime(ptime)


def randomDate(start, end, prop):
    return strTimeProp(start, end, '%m/%d/%Y %I:%M %p', prop)

with open('createSchema.sql','w') as output:
    output.write('/*'+'\n')
    output.write('Populate the schema for the movie recommandation database'+'\n')
    output.write('whith data on the top 250 movies according to IMDB'+'\n')
    output.write('This file has been generated by a script'+'\n')
    output.write('*/'+'\n\n')
    output.write('set search_path = "moviedb";'+'\n\n')
    output.write('INSERT INTO Movie(movieid, moviename, releasedate, description, country)\n')
    output.write('VALUES\n')
    with open('top250movies','r') as movieList:
        movieListReader = csv.reader(movieList, delimiter='\t')
        index=0
        for movie in movieListReader:
            if index > 0:
                output.write(",")
            output.write('(\''+convStr(movie[1])+'\',\''+convStr(movie[0])+'\',\''+convStr(movie[4])+'\',\''+convStr(movie[2])+'\',\''+convStr(movie[3])+'\')\n')
            index+=1
    output.write(';\n\n')
    movieList.close()

    output.write('INSERT INTO Actor(actorId, fname, lname) VALUES\n')
    with open('actors.list','r') as actorList:
        actorListReader = csv.reader(actorList, delimiter='\t')
        index=0
        for actor in actorListReader:
            if index > 0:
                output.write(",")
            output.write('(\''+convStr(actor[0])+'\',\''+convStr(actor[1])+'\',\''+convStr(actor[2])+'\')\n')
            index+=1
    output.write(';\n\n')
    actorList.close()

    output.write('INSERT INTO Role(roleId, actorId, fname, lname) VALUES\n')
    with open('top250roles','r') as roleList,open('actors.list','r') as actorList:
        actorListReader = csv.reader(actorList, delimiter='\t')
        roleListReader = csv.reader(roleList, delimiter='\t')
        index=0
        for role in roleListReader:
            if index > 0:
                output.write(",")
            actorID = ''
            found=False
            actorList.seek(0)
            for actor in actorListReader:
                if role[2] == actor[1] and role[3] == actor[2]:
                    actorID=actor[0]
                    found = True
                    break
            if found:
                output.write('(\''+convStr(role[0])+'\',\''+convStr(actorID)+'\',\''+convStr(role[4])+'\',\''+convStr(role[5])+'\')\n')
            else:
                print "Error reading role list. "+role[2]+" "+role[3]
            index+=1
    output.write(';\n\n')
    roleList.close()
    actorList.close()

    output.write('INSERT INTO RolePlaysIn(movieId, RoleId) VALUES\n')
    with open('top250roles','r') as roleList,open('top250movies','r') as movieList:
        movieListReader = csv.reader(movieList, delimiter='\t')
        roleListReader = csv.reader(roleList, delimiter='\t')
        index=0
        for role in roleListReader:
            if index > 0:
                output.write(",")
            movieID = ''
            found=False
            movieList.seek(0)
            for movie in movieListReader:
                if role[1] == movie[0]:
                    movieID=movie[1]
                    found = True
                    break
            if found:
                output.write('(\''+convStr(movieID)+'\',\''+convStr(role[0])+'\')\n')
            else:
                print "Error reading role list. "+role[2]+" "+role[3]
            index+=1
    output.write(';\n\n')
    roleList.close()
    movieList.close()

    output.write('INSERT INTO Director(directorId, fname, lname) VALUES\n')
    with open('directors.list','r') as directorList:
        directorListReader = csv.reader(directorList, delimiter='\t')
        index=0
        for director in directorListReader:
            if index > 0:
                output.write(",")
            output.write('(\''+convStr(director[0])+'\',\''+convStr(director[1])+'\',\''+convStr(director[2])+'\')\n')
            index+=1
    output.write(';\n\n')
    directorList.close()

    output.write('INSERT INTO Directs(directorId,movieId) VALUES\n')
    with open('top250directors','r') as directsList,open('directors.list','r') as directorList,open('top250movies','r') as movieList:
        directsListReader = csv.reader(directsList, delimiter='\t')
        movieListReader = csv.reader(movieList, delimiter='\t')
        directorListReader = csv.reader(directorList, delimiter='\t')
        index=0
        for directs in directsListReader:
            if index > 0:
                output.write(",")
            movieId = ''
            foundmovie=False
            movieList.seek(0)
            for movie in movieListReader:
                if directs[0] == movie[0]:
                    movieId=movie[1]
                    foundmovie = True
                    break
            directorId=''
            founddirector=False
            directorList.seek(0)
            for director in directorListReader:
                if directs[1]==director[1] and directs[2]==director[2]:
                    directorId=director[0]
                    founddirector=True
                    break
            if foundmovie and founddirector:
                output.write('(\''+convStr(directorId)+'\',\''+convStr(movieId)+'\')\n')
            else:
                print "Error reading role list. "+directs[1]+" "+directs[2]
            index+=1
    output.write(';\n\n')
    directorList.close()
    movieList.close()
    directsList.close()

    output.write('INSERT INTO Studio(studioId, name) VALUES\n')
    with open('studios.list','r') as studioList:
        studioListReader = csv.reader(studioList, delimiter='\t')
        index=0
        for studio in studioListReader:
            if index > 0:
                output.write(",")
            output.write('(\''+convStr(studio[0])+'\',\''+convStr(studio[1])+'\')\n')
            index+=1
    output.write(';\n\n')
    studioList.close()

    output.write('INSERT INTO Sponsors(studioId,movieId) VALUES\n')
    with open('top250studio','r') as sponsorsList,open('studios.list','r') as studioList,open('top250movies','r') as movieList:
        sponsorsListReader = csv.reader(sponsorsList, delimiter='\t')
        movieListReader = csv.reader(movieList, delimiter='\t')
        studioListReader = csv.reader(studioList, delimiter='\t')
        index=0
        for sponsors in sponsorsListReader:
            if index > 0:
                output.write(",")
            movieId = ''
            foundmovie=False
            movieList.seek(0)
            for movie in movieListReader:
                if sponsors[0] == movie[0]:
                    movieId=movie[1]
                    foundmovie = True
                    break
            studioId=''
            foundstudio=False
            studioList.seek(0)
            for studio in studioListReader:
                if sponsors[1]==studio[1]:
                    studioId=studio[0]
                    foundstudio=True
                    break
            if foundmovie and foundstudio:
                output.write('(\''+convStr(studioId)+'\',\''+convStr(movieId)+'\')\n')
            else:
                print "Error reading role list. "+sponsors[1]
            index+=1
    output.write(';\n\n')
    studioList.close()
    movieList.close()
    sponsorsList.close()

    output.write('INSERT INTO Topic(topicId, description) VALUES\n')
    with open('genres.list','r') as genreList:
        genreListReader = csv.reader(genreList, delimiter='\t')
        index=0
        for genre in genreListReader:
            if index > 0:
                output.write(",")
            output.write('(\''+convStr(genre[0])+'\',\''+convStr(genre[1])+'\')\n')
            index+=1
    output.write(';\n\n')
    studioList.close()

    output.write('INSERT INTO MovieTopic(topicId,movieId) VALUES\n')
    with open('top250genres','r') as istopicList,open('genres.list','r') as topicList,open('top250movies','r') as movieList:
        istopicListReader = csv.reader(istopicList, delimiter='\t')
        movieListReader = csv.reader(movieList, delimiter='\t')
        topicListReader = csv.reader(topicList, delimiter='\t')
        index=0
        for istopic in istopicListReader:
            if index > 0:
                output.write(",")
            movieId = ''
            foundmovie=False
            movieList.seek(0)
            for movie in movieListReader:
                if istopic[0] == movie[0]:
                    movieId=movie[1]
                    foundmovie = True
                    break
            topicId=''
            foundtopic=False
            topicList.seek(0)
            for topic in topicListReader:
                if istopic[1]==topic[1]:
                    topicId=topic[0]
                    foundtopic=True
                    break
            if foundmovie and foundtopic:
                output.write('(\''+convStr(topicId)+'\',\''+convStr(movieId)+'\')\n')
            else:
                print "Error reading role list. "+istopic[1]
            index+=1
    output.write(';\n\n')
    topicList.close()
    movieList.close()
    istopicList.close()

    output.write('INSERT INTO Users(userId, fName, lName, email, gender, ageRangeId, password) VALUES\n')
    with open('MOCK_DATA.csv','r') as userList, open('users.list','w') as userOutputList:
        userListReader = csv.reader(userList, delimiter=',')
        userListWriter = csv.writer(userOutputList,delimiter='\t',quotechar='',quoting=csv.QUOTE_NONE)
        index=0
        count=1
        for user in userListReader:
            if index > 0 :
                userId = 'user%04d'%count
                count+=1
                fname = user[1]
                lname = user[2]
                email = user[3]
                gender = 'm'
                if user[4] == 'Female':
                    gender = 'f'
                ageRangeId = str(randint(1,7))
                if index > 1:
                    output.write(",")
                output.write('(\''+convStr(userId)+'\',\''+convStr(fname)+'\',\''+convStr(lname)+'\',\''+convStr(email)+'\',\''+convStr(gender)+'\',\''+convStr(ageRangeId)+'\',\''+convStr(userId)+'\')\n')
                userListWriter.writerow([userId,fname,lname,email,gender,ageRangeId,userId])
            index+=1
    output.write(';\n\n')
    studioList.close()
    userOutputList.close()

    output.write('INSERT INTO Rates(userId, movieId, rating, RateDate) VALUES\n')
    with open('users.list','r') as userList,open('top250movies','r') as movieList:
        movieListReader = csv.reader(movieList, delimiter='\t')
        userListReader = csv.reader(userList, delimiter='\t')
        index=0
        total = len(movieList.readlines())
        for user in userListReader:
            numberRatings = randint(5,50)
            rated = []
            for i in range(0,numberRatings):
                x = 0
                while True:
                    x = randint(0,total-1)
                    movieList.seek(0)
                    for y in range (0,x):
                        row = movieListReader.next()
                    if not(row[1] in rated):
                        rated.append(row[1])
                        break
                movieId = row[1]
                rating = '%.1f'%(randint(6,10)/2.0)
                date = time.strftime("%Y-%m-%d",randomDate("1/1/2005 1:00 AM","11/4/2016 7:30 AM",random.random()))
                if index > 0:
                    output.write(",")

                output.write('(\''+convStr(user[0])+'\',\''+convStr(movieId)+'\',\''+convStr(rating)+'\',\''+convStr(date)+'\')\n')
                index+=1
    output.write(';\n\n')
    roleList.close()
    movieList.close()

output.close()
