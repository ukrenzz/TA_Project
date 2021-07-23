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

# def process(imgB64):
#   net = cv2.dnn.readNetFromDarknet('yolov4-tiny.cfg','yolov4-tiny.weights')
#   net.setPreferableBackend(cv2.dnn.DNN_BACKEND_CUDA)
#   net.setPreferableTarget(cv2.dnn.DNN_TARGET_CUDA)
#   classes = []
#   with open('yolov4.txt','r') as f:
#     classes = f.read().splitlines()
#   decode = base64.b64decode(imgB64)
#   npimg = np.frombuffer(decode, dtype=np.uint8)
#   img = cv2.imdecode(npimg, 1)
#   height, width, _ = img.shape
#   blob = cv2.dnn.blobFromImage(img, 1/255, (416,416), (0,0,0), swapRB = True, crop = False)
#   net.setInput(blob)
#   output_layers_names = net.getUnconnectedOutLayersNames()
#   layersOutputs = net.forward(output_layers_names)
#   boxes = []
#   confidences = []
#   class_ids = []
#   for output in layersOutputs:
#     for detection in output:
#       scores = detection[5:]
#       class_id = np.argmax(scores)
#       confidence = scores[class_id]
#       if confidence > 0.5:
#         center_x = int(detection[0]*width)
#         center_y = int(detection[1]*height)
#         w = int(detection[2]*width)
#         h = int(detection[3]*height)
#         x = int(center_x - w/2)
#         y = int(center_y - h/2)
#         boxes.append([x, y, w, h])
#         class_ids.append(class_id)
#         confidences.append((float(confidence)))
#     print(len(boxes))
#     indexes = cv2.dnn.NMSBoxes(boxes, confidences, 0.5, 0.6)
#     colors = np.random.uniform(0, 255, size = (len(boxes), 3))

#     for i in range(len(boxes)):
#       if i in indexes:
#         x, y , w, h = boxes[i]
#         label = str(classes[class_ids[i]])
#         confidence = str(round(confidences[i],2))
#         color = colors[i]
#         cv2.rectangle(img, (x,y), (x+w,y+h), color, 8)
#         cv2.putText(img, label + " " + confidence, (x, y+20), font, 1, (255,255,255) , 2)
#   cv2.imshow('Output',cv2.resize(img,(700, 500)))
#   cv2.waitKey()
#   cv2.destroyAllWindows()

def process(imgB64):
  net = cv2.dnn.readNetFromDarknet('yolov4.cfg','yolov4.weights')
  net.setPreferableBackend(cv2.dnn.DNN_BACKEND_CUDA)
  net.setPreferableTarget(cv2.dnn.DNN_TARGET_CUDA)
  classes = []
  with open('yolov4.txt','r') as f:
    classes = f.read().splitlines()
  decode = base64.b64decode(imgB64)
  npimg = np.frombuffer(decode, dtype=np.uint8)
  img = cv2.imdecode(npimg, 1)
  # img = cv2.imread('mouse_ex4.jpeg')
  #get layers of the network
  layer_names = net.getLayerNames()
  #Determine the output layer names from the YOLO model
  output_layers = [layer_names[i[0] - 1] for i in net.getUnconnectedOutLayers()]
  height, width, channels = img.shape
  # Using blob function of opencv to preprocess image
  blob = cv2.dnn.blobFromImage(img, 1 / 255.0, (512, 512), (0,0,0),
    swapRB=True, crop=False)
  #Detecting objects
  net.setInput(blob)
  outs = net.forward(output_layers)

  # Showing informations on the screen
  class_ids = []
  confidences = []
  boxes = []
  res = {}
  for out in outs:
      for detection in out:
          scores = detection[5:]
          class_id = np.argmax(scores)
          confidence = scores[class_id]
          if confidence > 0.5:
              # Object detected
              center_x = int(detection[0] * width)
              center_y = int(detection[1] * height)
              w = int(detection[2] * width)
              h = int(detection[3] * height)

              # Rectangle coordinates
              x = int(center_x - w / 2)
              y = int(center_y - h / 2)

              boxes.append([x, y, w, h])
              confidences.append(float(confidence))
              class_ids.append(class_id)

  #We use NMS function in opencv to perform Non-maximum Suppression
  #we give it score threshold and nms threshold as arguments.
  indexes = cv2.dnn.NMSBoxes(boxes, confidences, 0.2, 0.7)
  colors = np.random.uniform(0, 255, size=(len(classes), 3))
  print('idx :', indexes)
  for i in range(len(boxes)):
      if i in indexes:
          x, y, w, h = boxes[i]
          label = str(classes[class_ids[i]])
          color = colors[class_ids[i]]
          confidence = str(round(confidences[i],2))
          res[i] = {'x' : x, 'y' : y, 'w' : w, 'h' : h, 'label': label, 'confi': confidence}
          # print(i, res)
    #       cv2.rectangle(img, (x, y), (x + w, y + h), color, 2)
    #       cv2.putText(img, label, (x, y -5),cv2.FONT_HERSHEY_SIMPLEX,
    # 1/2, color, 2)

  # cv2.imshow("Image",img)
  # cv2.waitKey(0)
  # cv2.destroyAllWindows()
  return res

def process2(imgB64):
    CONFIDENCE_THRESHOLD = 0.2
    NMS_THRESHOLD = 0.4
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

app.run()
# process("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")
