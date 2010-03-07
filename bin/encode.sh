#!/bin/bash

for i in *
	do
		if [ -d $i ]
		then
			jpeg_file_count=`ls $i/*.jpg 2>/dev/null | wc -l`
			if [ $jpeg_file_count -gt 0 ]
			then
				digits=${#jpeg_file_count}
				input_filename=$i/%0"$digits"d.jpg
				#echo "Input filename is $input_filename"
				time ffmpeg -y -r 24 -i $input_filename -s vga -vcodec ffv1 $i-vga-24fps.mkv
			fi
		fi
	done;
