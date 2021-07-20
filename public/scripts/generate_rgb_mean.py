import cv2
import numpy as np
import sys
import json

def get_mean_rgb(img):
  avg_color_per_row = np.average(img, axis=0)
  return np.average(avg_color_per_row, axis=0)

def convert(img):
    # convert to graky
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

    # threshold input image as mask
    mask = cv2.threshold(gray, 250, 255, cv2.THRESH_BINARY)[1]

    # negate mask
    mask = 255 - mask

    # apply morphology to remove isolated extraneous noise
    # use borderconstant of black since foreground touches the edges
    kernel = np.ones((3,3), np.uint8)
    mask = cv2.morphologyEx(mask, cv2.MORPH_OPEN, kernel)
    mask = cv2.morphologyEx(mask, cv2.MORPH_CLOSE, kernel)

    # anti-alias the mask -- blur then stretch
    # blur alpha channel
    mask = cv2.GaussianBlur(mask, (0,0), sigmaX=2, sigmaY=2, borderType = cv2.BORDER_DEFAULT)

    # linear stretch so that 127.5 goes to 0, but 255 stays 255
    mask = (2*(mask.astype(np.float32))-255.0).clip(0,255).astype(np.uint8)

    # put mask into alpha channel
    result = img.copy()
    result = cv2.cvtColor(result, cv2.COLOR_BGR2BGRA)
    result[:, :, 3] = mask

    # display result, though it won't show transparency
    return result

imgInput = sys.argv[1]
img = cv2.imread(imgInput)
img_clear = convert(img)
res = get_mean_rgb(img_clear)
res[0] = abs(res[0] - res[3])
res[1] = abs(res[1] - res[3])
res[2] = abs(res[2] - res[3])
jsonOutput = {"r" : res[0], "g" : res[1], "b" : res[2]}
print(json.dumps(jsonOutput))
