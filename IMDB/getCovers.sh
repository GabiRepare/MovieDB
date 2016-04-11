#!/bin/bash
a=1
cat top250imgURL | while read line
do
	wget $line -O $(printf "image/mov%03d.jpg" "$a")
	let a=a+1
done
