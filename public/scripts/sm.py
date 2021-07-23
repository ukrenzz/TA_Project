import mysql.connector
import cv2
import numpy as np
from multiprocessing import Pool
import sys
from ast import literal_eval
import json

def get_mean_rgb(img):
  avg_color_per_row = np.average(img, axis=0)
  return np.average(avg_color_per_row, axis=0)

def get_stdev(img):
  sdv_color_per_row = np.std(img, axis=0)
  return np.std(sdv_color_per_row, axis=0)

def get_ht_lt(img):
	mean_rgb = get_mean_rgb(resized_img)
	stdev_rgb = get_stdev(resized_img)

	HT = [0]*3
	LT = [0]*3

	for i in range(3):
		HT[i] = mean_rgb[i] + stdev_rgb[i]
		LT[i] = mean_rgb[i] - stdev_rgb[i]
	return HT+LT

def getColorThreshold(img, cat, db): 
	#Get HT and LT
	color_feat = get_ht_lt(img)

	dbCur = db.cursor()
	dbCur.execute("select images.product_id, images.shape_feature, images.edge_feature, images.id FROM `product_images` as images WHERE (images.color_feat_r >= {1} and images.color_feat_r <= {2}) or (images.color_feat_g >= {3} and images.color_feat_g <= {4}) or (images.color_feat_b >= {5} and images.color_feat_b <= {6}) and product_id in (select id from `products` where category_id = (select id from `categories` where name = '{0}'))".format(cat, color_feat[3], color_feat[0], color_feat[4], color_feat[1], color_feat[5], color_feat[2]))

	return dbCur.fetchall()

def getData(db):
	dbCur = db.cursor()
	dbCur.execute("select images.product_id, images.shape_feature, images.edge_feature, images.id FROM `product_images` as images WHERE product_id in (select id from `products` where category_id = (select id from `categories` where name = '{0}'))".format(cat))

	return dbCur.fetchall()

def get_pixel(img, center, x, y):
	
	new_value = 0
	
	try:
		if img[x][y] >= center:
			new_value = 1
			
	except:
		pass
	
	return new_value

# Function for calculating LBP
def lbp_calculated_pixel(img, x, y):

	center = img[x][y]

	val_ar = []
	
	# top_left
	val_ar.append(get_pixel(img, center, x-1, y-1))
	
	# top
	val_ar.append(get_pixel(img, center, x-1, y))
	
	# top_right
	val_ar.append(get_pixel(img, center, x-1, y + 1))
	
	# right
	val_ar.append(get_pixel(img, center, x, y + 1))
	
	# bottom_right
	val_ar.append(get_pixel(img, center, x + 1, y + 1))
	
	# bottom
	val_ar.append(get_pixel(img, center, x + 1, y))
	
	# bottom_left
	val_ar.append(get_pixel(img, center, x + 1, y-1))
	
	# left
	val_ar.append(get_pixel(img, center, x, y-1))
	
	# Now, we need to convert binary
	# values to decimal
	power_val = [1, 2, 4, 8, 16, 32, 64, 128]

	val = 0
	
	for i in range(len(val_ar)):
		val += val_ar[i] * power_val[i]
		
	return val

def generate_lbp(img_lbp, width, height):
	for i in range(0, height):
		for j in range(0, width):
			img_lbp[i, j] = lbp_calculated_pixel(img_gray, i, j)
	return img_lbp

def sm_lbp(img_lbp, queries):
	for query in queries:
		query = list(query)
		query[1] = literal_eval(query[1])
		query[1] = np.absolute(np.array(img_lbp) - np.array(query[1]))
	# print(len(queries))
	return queries

def norm_sm_lbp(queries):
	for query in queries:
		query = list(query)
		query[1] = np.array(literal_eval(query[1]))
		query[1] = (query[1] - query[1].min()) / (query[1].max() - query[1].min())
	return queries

def Canny_detector(img, weak_th = None, strong_th = None):
		
	# Noise reduction step
	img = cv2.GaussianBlur(img, (5, 5), 1.4)
	
	# Calculating the gradients
	gx = cv2.Sobel(np.float32(img), cv2.CV_64F, 1, 0, 3)
	gy = cv2.Sobel(np.float32(img), cv2.CV_64F, 0, 1, 3)
	
	# Conversion of Cartesian coordinates to polar
	mag, ang = cv2.cartToPolar(gx, gy, angleInDegrees = True)
	
	# setting the minimum and maximum thresholds
	# for double thresholding
	mag_max = np.max(mag)
	if not weak_th:weak_th = mag_max * 0.1
	if not strong_th:strong_th = mag_max * 0.5
	
	# getting the dimensions of the input image
	height, width = img.shape
	
	# Looping through every pixel of the grayscale
	# image
	for i_x in range(width):
		for i_y in range(height):
			
			grad_ang = ang[i_y, i_x]
			grad_ang = abs(grad_ang-180) if abs(grad_ang)>180 else abs(grad_ang)
			
			# selecting the neighbours of the target pixel
			# according to the gradient direction
			# In the x axis direction
			if grad_ang<= 22.5:
				neighb_1_x, neighb_1_y = i_x-1, i_y
				neighb_2_x, neighb_2_y = i_x + 1, i_y
			
			# top right (diagnol-1) direction
			elif grad_ang>22.5 and grad_ang<=(22.5 + 45):
				neighb_1_x, neighb_1_y = i_x-1, i_y-1
				neighb_2_x, neighb_2_y = i_x + 1, i_y + 1
			
			# In y-axis direction
			elif grad_ang>(22.5 + 45) and grad_ang<=(22.5 + 90):
				neighb_1_x, neighb_1_y = i_x, i_y-1
				neighb_2_x, neighb_2_y = i_x, i_y + 1
			
			# top left (diagnol-2) direction
			elif grad_ang>(22.5 + 90) and grad_ang<=(22.5 + 135):
				neighb_1_x, neighb_1_y = i_x-1, i_y + 1
				neighb_2_x, neighb_2_y = i_x + 1, i_y-1
			
			# Now it restarts the cycle
			elif grad_ang>(22.5 + 135) and grad_ang<=(22.5 + 180):
				neighb_1_x, neighb_1_y = i_x-1, i_y
				neighb_2_x, neighb_2_y = i_x + 1, i_y
			
			# Non-maximum suppression step
			if width>neighb_1_x>= 0 and height>neighb_1_y>= 0:
				if mag[i_y, i_x]<mag[neighb_1_y, neighb_1_x]:
					mag[i_y, i_x]= 0
					continue

			if width>neighb_2_x>= 0 and height>neighb_2_y>= 0:
				if mag[i_y, i_x]<mag[neighb_2_y, neighb_2_x]:
					mag[i_y, i_x]= 0

	weak_ids = np.zeros_like(img)
	strong_ids = np.zeros_like(img)			
	ids = np.zeros_like(img)
	
	# double thresholding step
	for i_x in range(width):
		for i_y in range(height):
			
			grad_mag = mag[i_y, i_x]
			
			if grad_mag<weak_th:
				mag[i_y, i_x]= 0
			elif strong_th>grad_mag>= weak_th:
				ids[i_y, i_x]= 1
			else:
				ids[i_y, i_x]= 2

	return mag

def sm_edge(img_edgeR, img_edgeG, img_edgeB, queries):
	i = 0
	# try:
	for idx in range(len(queries)):
		edge_sm = np.empty(576)
		queries[idx] = list(queries[idx])
		edge = literal_eval(queries[idx][2])
		edge_sm = np.absolute(img_edgeR - np.array(edge[0]).astype(np.float64)) + np.absolute(img_edgeR - np.array(edge[1]).astype(np.float64)) + np.absolute(img_edgeR - np.array(edge[2]).astype(np.float64)) 
		queries[idx][2] = edge_sm
	# 		i+=1
	# except:
	# 	print(i)
	# print(queries[0][2])
	# print(queries[0][2].dtype)
	return queries

def norm_sm_edge(queries):
	for idx in range(len(queries)):
		queries[idx] = list(queries[idx])
		queries[idx][2] = np.array(queries[idx][2]).astype(np.float64)
		queries[idx][2] = (queries[idx][2] - queries[idx][2].min()) / (queries[idx][2].max() - queries[idx][2].min())
	# print(queries[0][2])
	return queries

def result(queries):
	res = {}
	for idx in range(len(queries)):
		queries[idx][1] = literal_eval(queries[idx][1])
		queries[idx][1] = np.array(queries[idx][1]).astype(np.float64)
		queries[idx][2] = np.array(queries[idx][2]).astype(np.float64)
		# print(idx, queries[idx][0])
		if((queries[idx][0]) in res):
			tmp = np.sum(queries[idx][1] + queries[idx][2])
			if(tmp > res[queries[idx][0]]):
				res[queries[idx][0]] = tmp			
		else:
			res[queries[idx][0]] = (np.sum(queries[idx][1] + queries[idx][2]))
	return res

imgInput = sys.argv[1]
cat = sys.argv[2]
img = cv2.imread(imgInput, 1)
resized_img = cv2.resize(img, (576, 576))

db = mysql.connector.connect (
		host="localhost",
		user="root",
		password="",
		database="db_neko_project"
)

height, width, _ = resized_img.shape

img_gray = cv2.cvtColor(resized_img,cv2.COLOR_BGR2GRAY)

img_lbp = np.zeros((height, width),np.uint8)

p = Pool()
args = [(img_lbp, width, height)]
img_lbp = p.starmap(generate_lbp, args)
queries = getData(db)
color_queries = getColorThreshold(img, cat, db)
sm_lbp_args = [(img_lbp, queries)]
queries = p.starmap(sm_lbp, sm_lbp_args)[0]
sm_norm_args = [queries]
queries = p.map(norm_sm_lbp, sm_norm_args)[0]

imgR, imgG, imgB = cv2.split(resized_img)
args = (imgR, imgG, imgB)
with Pool() as pool:
	res = pool.map(Canny_detector, args)
imgR = res[0]
imgG = res[1]
imgB = res[2]
queries = sm_edge(imgR, imgG, imgB, queries)
queries = norm_sm_edge(queries)
res = result(queries)
res = dict(sorted(res.items(), key=lambda item: item[1]))
if(len(color_queries) > 0):
	for idx in range(len(color_queries)):
		if(color_queries[idx][0] in res):
			res[color_queries[idx][0]] *= 10
	res = dict(sorted(res.items(), key=lambda item: item[1]))
print(json.dumps(res))


