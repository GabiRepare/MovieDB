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

with open('top250genres','w') as output, open('errors','w') as errorLog:
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
            else:
                genres = find_between(the_page, 'Genre":"','","Director').split(', ')
                for genre in genres:
                    writer.writerow([title,genre])
                    #print ("Found "+genre+" directing "+title)

movieFile.close()
output.close()
