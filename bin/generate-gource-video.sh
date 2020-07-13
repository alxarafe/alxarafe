#!/bin/bash

# Generate a video based on commits

gource --title "Alxarafe" --logo .git/avatar/Alxarafe.png --user-image-dir .git/avatar/ --seconds-per-day 1 -1280x720 -o - | ffmpeg -y -r 60 -f image2pipe -vcodec ppm -i - -vcodec libx264 -preset ultrafast -pix_fmt yuv420p -crf 1 -threads 0 -bf 0 gource.mp4
