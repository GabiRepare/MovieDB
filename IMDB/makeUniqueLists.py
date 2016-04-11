#!/usr/bin/python
import csv

with open('directors.list','w') as outputFile:
    with open ('top250directors', 'r') as inputFile:
        inputReader = csv.reader(inputFile, delimiter='\t')
        writer = csv.writer(outputFile,delimiter='\t',quotechar='',quoting=csv.QUOTE_NONE)
        directors=[]
        count=1
        for entry in inputReader:
            if [entry[1],entry[2]] in directors:
                continue
            else:
                directors.append([entry[1],entry[2]])
                writer.writerow(['dir%04d'%(count),entry[1],entry[2]])
                count+=1
    inputFile.close()
outputFile.close()

with open('actors.list','w') as outputFile:
    with open ('top250actors', 'r') as inputFile:
        inputReader = csv.reader(inputFile, delimiter='\t')
        writer = csv.writer(outputFile,delimiter='\t',quotechar='',quoting=csv.QUOTE_NONE)
        actors=[]
        count=1
        for entry in inputReader:
            if [entry[1],entry[2]] in actors:
                continue
            else:
                actors.append([entry[1],entry[2]])
                writer.writerow(['act%04d'%(count),entry[1],entry[2]])
                count+=1
    inputFile.close()
outputFile.close()

with open('genres.list','w') as outputFile:
    with open ('top250genres', 'r') as inputFile:
        inputReader = csv.reader(inputFile, delimiter='\t')
        writer = csv.writer(outputFile,delimiter='\t',quotechar='',quoting=csv.QUOTE_NONE)
        genres=[]
        count=1
        for entry in inputReader:
            if entry[1] in genres:
                continue
            else:
                genres.append(entry[1])
                writer.writerow(['top%03d'%(count),entry[1]])
                count+=1
    inputFile.close()
outputFile.close()

with open('studios.list','w') as outputFile:
    with open ('top250studio', 'r') as inputFile:
        inputReader = csv.reader(inputFile, delimiter='\t')
        writer = csv.writer(outputFile,delimiter='\t',quotechar='',quoting=csv.QUOTE_NONE)
        studios=[]
        count=1
        for entry in inputReader:
            if entry[1] in studios:
                continue
            else:
                studios.append(entry[1])
                writer.writerow(['stu%03d'%(count),entry[1]])
                count+=1
    inputFile.close()
outputFile.close()
