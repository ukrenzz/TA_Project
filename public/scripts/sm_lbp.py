import cv2
import numpy as np
import sys
import multiprocessing
import json
from matplotlib import pyplot as plt
from itertools import product
from ast import literal_eval

def sm_lbp(lbpQ, lbpD):
  return np.absolute(np.array(lbpQ) - np.array(lbpD))

lbpQuery = sys.argv[1]
lbpDB = sys.argv[2]

lbpQ = literal_eval(lbpQuery)
lbpD = literal_eval(lbpDB)

p = multiprocessing.Pool()
args = [(lbpQ, lbpD)]
res = p.starmap(sm_lbp, args)

with np.printoptions(threshold=np.inf):
	print(res)