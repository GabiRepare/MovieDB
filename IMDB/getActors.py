#!/usr/bin/python
import csv
import urllib2

def find_between( s, first, last ):
    try:
        start = s.index( first ) + len( first )
        end = s.index( last, start )
        return s[start:end]
    except ValueError:
        return ""

with open('top250actors','w') as output, open('errors','w') as errorLog:
    with open ('top250aka.txt', 'r') as movieFile:
        movieReader = csv.reader(movieFile, delimiter='\t')
        writer = csv.writer(output,delimiter='\t',quotechar='"',quoting=csv.QUOTE_NONE)
        writerError = csv.writer(errorLog,delimiter='\t',quotechar='"',quoting=csv.QUOTE_NONE)
        for movie in movieReader:

            title=movie[0]
            url="http://www.omdbapi.com/?t="+title.replace(" ","+")
            if title == "M":
                url = "http://www.omdbapi.com/?i=tt0022100"
            req = urllib2.Request(url)
            response = urllib2.urlopen(req)
            the_page = response.read()
            if len(the_page) < 100:
                print ("Error with movie request :"+title)
                print ("Request url: "+url)
                writerError.writerow([title,url])
            elif title == "Sunset Boulevard ":
                writer.writerow([title,'William', 'Holden'])
                writer.writerow([title,'Gloria','Swanson'])
                writer.writerow([title,'Erich','von Stroheim'])
                writer.writerow([title,'Nancy','Olson'])
            else:
                actors = find_between(the_page, 'Actors":"','","Plot').split(', ')
                for actor in actors:
                    if len(actor.split(' ',1)) ==  2:
                        fname = actor.split(' ',1)[0]
                        lname = actor.split(' ',1)[1]
                        writer.writerow([title,fname,lname])
                        #print ("Found "+director+" directing "+title)
                    elif len(actor.split(' ',1)) ==  1:
                        fname = actor
                        lname = ''
                    else:
                        print ("Exception with movie: "+title+" Actor: "+actor)

movieFile.close()
output.close()
