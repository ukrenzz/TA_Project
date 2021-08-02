import cv2
import numpy as np
import time
import base64
import flask
from flask import request, jsonify
from flask_cors import CORS, cross_origin


app = flask.Flask(__name__)
app.config["DEBUG"] = True
CORS(app, support_credentials=True)

def process2(imgB64):
    CONFIDENCE_THRESHOLD = 0.2
    NMS_THRESHOLD = 0.5
    COLORS = [(0, 255, 255), (255, 255, 0), (0, 255, 0), (255, 0, 0)]

    class_names = []
    with open("yolov4.txt", "r") as f:
     class_names = [cname.strip() for cname in f.readlines()]

    net = cv2.dnn.readNet("yolov4.weights", "yolov4.cfg")
    net.setPreferableBackend(cv2.dnn.DNN_BACKEND_CUDA)
    net.setPreferableTarget(cv2.dnn.DNN_TARGET_CUDA_FP16)

    model = cv2.dnn_DetectionModel(net)
    model.setInputParams(size=(416, 416), scale=1/255, swapRB=True)
    decode = base64.b64decode(imgB64)
    npimg = np.frombuffer(decode, dtype=np.uint8)
    img = cv2.imdecode(npimg, 1)

    start = time.time()
    classes, scores, boxes = model.detect(img, CONFIDENCE_THRESHOLD, NMS_THRESHOLD)
    end = time.time()

    res = {}

    start_drawing = time.time()
    i = 0
    for (classid, score, box) in zip(classes, scores, boxes):
     color = COLORS[int(classid) % len(COLORS)]
     label = "%s : %f" % (class_names[classid[0]], score)
     res[i] = {'x' : str(box[0]), 'y' : str(box[1]), 'w' : str(box[2]), 'h' : str(box[3]), 'label': label, 'confi': str(score[0])}
     i+=1
    end_drawing = time.time()
    print(res)
    return res

@app.route('/api/v1/yolo', methods=['POST'])
# @cross_origin(supports_credentials=True)

def api_all():
  image = request.get_json()
  image = image['imgBase64']
  res = process2(image)
  return jsonify(res)

app.run('neko.project', 5000)
