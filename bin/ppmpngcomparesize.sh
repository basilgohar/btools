#!/bin/bash

for i in *; do
    ext=${i#*.}
    echo $ext
done;
