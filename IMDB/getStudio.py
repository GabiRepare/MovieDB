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

with open('top250studio','w') as output, open('errors','w') as errorLog:
    with open ('top250id', 'r') as movieFile:
        movieReader = csv.reader(movieFile, delimiter='\t')
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

            studios = find_between(the_page, '<h4 class="inline">Production Co:</h4>', '<span class="see-more inline">')

            while True:
                studio = find_between_inc(studios,'<span class="itemprop" itemprop="name">','</span>')
                if (studio == ""):
                    break
                writer.writerow([title,studio])

movieFile.close()
output.close()
