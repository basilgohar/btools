#!/bin/bash

for i in *.jpg;	do
	basename=${i%.*}
	width=`gm identify -format '%w' $i`
	height=`gm identify -format '%h' $i`
	let newheight=$width*9/16
	let top=($height-$newheight)/2
	echo "Basename: $basename"
	echo "Original height: $height"
	echo "New height: $newheight"
	echo "Top: $top"
	jpegtopnm -quiet $i | pamcut -height $newheight -top $top | pamscale -xyfit 1920 1080 > hd1080/$basename.ppm
done
