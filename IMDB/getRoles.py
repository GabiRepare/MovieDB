#!/usr/bin/python
import csv
import urllib2

searchLocation = 0

def find_between_inc( s, first, last ):
    global searchLocation
    try:
        start = s.index( first, searchLocation ) + len( first )
        end = s.index( last, start )
        #print('searchLocation was: '+str(searchLocation)+' and end is: '+str(end))
        searchLocation = end + len(last)
        #print('searchLocation is now: '+str(searchLocation))
        return s[start:end]
    except ValueError:
        return ""

def find_between( s, first, last ):
    try:
        start = s.index( first) + len( first )
        end = s.index( last, start )
        return s[start:end]
    except ValueError:
        return ""

def reset_index():
    global searchLocation
    searchLocation = 0

with open('top250roles','w') as output, open('errors','w') as errorLog:
    with open ('top250id', 'r') as movieFile, open ('top250actors','r') as actorFile:
        countId = 0
        movieReader = csv.reader(movieFile, delimiter='\t')
        actorReader = csv.reader(actorFile, delimiter='\t')
        writer = csv.writer(output,delimiter='\t',quotechar='',quoting=csv.QUOTE_NONE)
        writerError = csv.writer(errorLog,delimiter='\t',quotechar='',quoting=csv.QUOTE_NONE)
        count = 0
        total=len(movieFile.readlines())
        movieFile.seek(0)
        for movie in movieReader:
            count += 1
            print "Fetching Movie "+str(count)+" of "+str(total)
            reset_index()
            title=movie[0]
            movieId=movie[1]
            url="http://www.imdb.com/title/"+movieId
            req = urllib2.Request(url)
            response = urllib2.urlopen(req)
            the_page = response.read()

            while True:
                row = find_between_inc(the_page, '<td class="primary_photo">', '</tr>')
                if (row == ""):
                    break
                name=find_between(row,'itemprop="name">','</span>')
                if len(name.split(' ',1)) ==  2:
                    fname = name.split(' ',1)[0]
                    lname = name.split(' ',1)[1]
                elif len(name.split(' ',1)) ==  1:
                    fname = name
                    lname = ''
                else:
                    print 'Empty name webpage for '+title
                character = find_between(row,'<td class="character">\n              <div>','/a>')
                character = find_between(character,'>', '<')
                actorFound = False
                actorFile.seek(0)
                for actor in actorReader:
                    #print "Comparing "+name+" with "+actor[1]+" "+actor[2]+" Search index is: "+str(searchLocation)
                    if (fname in actor[1]+actor[2] and lname in actor[1]+actor[2]) or (actor[1] in name and actor[2] in name):
                        print 'Found '+name+' playing '+character+'in '+title
                        actorFound=True
                        if len(character.split(' ',1)) ==  2:
                            roleFName = character.split(' ',1)[0]
                            roleLName = character.split(' ',1)[1]
                        elif len(character.split(' ',1)) ==  1:
                            roleFName = character
                            roleLName = ''
                        else:
                            print ("Exception with movie: "+title+" Character empty")
                        roleId = 'rol%04d'%countId
                        countId += 1
                        writer.writerow([roleId,title,actor[1],actor[2],roleFName,roleLName])
                        break


movieFile.close()
output.close()
