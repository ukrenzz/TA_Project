import cv2
import numpy as np
import sys

def get_mean_rgb(img):
  avg_color_per_row = np.average(img, axis=0)
  return np.average(avg_color_per_row, axis=0)

imgInput = sys.argv[1]
img = cv2.imread(imgInput)
res = get_mean_rgb(img)
converted_list = [str(element) for element in res]
print(";".join(converted_list))