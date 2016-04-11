#!/usr/bin/python
import csv

def convertGas (a):
    c = "%.1f" % (235.214/getFloat(a)[0])
    return ' {0} litre/100 km'.format(c)

def convertVol (a):
    c = "%.3f" % (getFloat(a)[0]/35.515)
    return ' {0} m^3'.format(c)

def getFloat(str):
    l = []
    for t in str.split():
        try:
            l.append(float(t))
        except ValueError:
            pass
    return l

with open('top250genres','w') as output:
    with open ('top250.txt', 'r') as movieFile:
        movieReader = csv.reader(movieFile)
        writer = csv.writer(output,delimiter='\t',quotechar='"',quoting=csv.QUOTE_NONE)
        for movie in movieReader:
            with open('/home/gabriel/Downloads/IMDB database/genres.list','r') as genresFiles:
                genreReader = csv.reader(genresFiles,delimiter='\t')
                for genre in genreReader:
                    if len(genre) >= 2:
                        title = genre[0]
                        genreFound = 'none'
                        del genre[0]
                        for cell in genre:
                            if cell != '':
                                genreFound = cell

                        if genreFound != 'none' and title == movie[0]:
                            print 'Found: '+title+'\t'+genreFound
                            writer.writerow([title,genreFound])
genresFiles.close()
movieFile.close()
output.close()
