#!/bin/bash

if [ ! -d vga ]
then
	mkdir vga
fi

for i in *.jpg
	do
		echo -n "$i "
		resized_filename="vga/$i.png"
		resize_start=`date +%s.%N`
		if [ -f vga/$i.png ]; then
			echo -n "(file already exists) "
		else
			jpegtopnm $i 2>/dev/null | pamscale -width 640 | pnmtopng -force > vga/$i.png
		fi		
		resize_finish=`date +%s.%N`
		total_time=`echo "$resize_finish - $resize_start" | bc`
		echo "(took $total_time seconds)"
	done

rename .jpg.png .png vga/*.jpg.png
