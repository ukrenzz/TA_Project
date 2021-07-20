import cv2
import numpy as np
import sys
import json

def get_mean_rgb(img):
  avg_color_per_row = np.average(img, axis=0)
  return np.average(avg_color_per_row, axis=0)

def get_stdev(img):
  sdv_color_per_row = np.std(img, axis=0)
  return np.std(sdv_color_per_row, axis=0)

imgInput = sys.argv[1]

img = cv2.imread(imgInput)
resized_img = cv2.resize(img, (576, 576))

mean_rgb = get_mean_rgb(resized_img)
stdev_rgb = get_stdev(resized_img)

HT = [0]*3
LT = [0]*3

for i in range(3):
  HT[i] = mean_rgb[i] + stdev_rgb[i]
  LT[i] = mean_rgb[i] - stdev_rgb[i]

jsonOutput = {"htR" : HT[0], "htG" : HT[1], "htB" : HT[2], "ltR" : LT[0], "ltG" : LT[1], "ltB" : LT[1]}
print(json.dumps(jsonOutput))