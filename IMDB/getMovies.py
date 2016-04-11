#!/usr/bin/python
import csv
import urllib2
import time

def find_between( s, first, last ):
    try:
        start = s.index( first ) + len( first )
        end = s.index( last, start )
        return s[start:end]
    except ValueError:
        return ""

with open('top250movies','w') as output, open('errors','w') as errorLog:
    with open ('top250aka.txt', 'r') as movieFile:
        movieReader = csv.reader(movieFile, delimiter='\t')
        writer = csv.writer(output,delimiter='\t',quotechar='',quoting=csv.QUOTE_NONE)
        writerError = csv.writer(errorLog,delimiter='\t',quotechar='',quoting=csv.QUOTE_NONE)
        count = 1
        for movie in movieReader:
            movieId = 'mov%03d'%(count)
            count+=1
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
            else:
                shortPlot = find_between(the_page, 'Plot":"','","Language')
                country = find_between(the_page, 'Country":"','","Awards')
                rawDate = find_between(the_page, 'Released":"','","Runtime')
                if title=='Vertigo':
                    releaseDate='1958-07-21'
                elif title=='The Gold Rush':
                    releaseDate='1925-01-01'
                else:
                    struct_time = time.strptime(rawDate,"%d %b %Y")
                    releaseDate = time.strftime("%Y-%m-%d",struct_time)
                print title

                writer.writerow([title, movieId, shortPlot, country, releaseDate])

movieFile.close()
output.close()
