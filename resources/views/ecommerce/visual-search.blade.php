@extends('layouts.ecommerce')

@section('title', "Neko eCommerce - Best solution for Accessories")

@section('user_defined_style')
<link href="{{ asset('ecommerce/css/listing.css') }}" rel="stylesheet">
<link href="{{ asset('ecommerce/css/custom.css') }}" rel="stylesheet">
@endsection


@section('content')
<main>
  <div class="container margin_30">
    <div class="page_header">
      <div class="breadcrumbs">
        <ul>
          <li><a href="#">Home</a></li>
          <li>Visual Search</li>
        </ul>
      </div>
      <h1>Search Result</h1>
    </div>
    <div class="row">
      <!-- /col -->
      <div class="col-lg-6">
        <div class="row">
          <div class="col-12 mb-3">
            <button id="startAndStop" class="btn_1"><i class="ri-live-line"></i> Start Video</button>
          </div>
          <div class="col-12">
            <video id="videoInput" width="320" height="240"></video>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <canvas id="canvasOutput" style="visibility: hidden;" width="320" height="240"></canvas>
      </div>
      <!-- /col -->
    </div>
    <!-- /row -->
  </div>
  <!-- /container -->
</main>
<!-- /main -->
@endsection


@section('user_defined_script')
  {{-- <script src="{{ asset('ecommerce/js/sticky_sidebar.min.js') }}"></script> --}}
  {{-- <script src="{{ asset('ecommerce/js/specific_listing.js') }}"></script> --}}
  <script src="{{ asset('vendors/opencv/opencv.js') }}"></script>
  <script src="{{ asset('vendors/opencv/utils.js') }}"></script>

  <script type="text/javascript">

    let utils = new Utils('errorMessage');

    let videoInput = document.getElementById('videoInput');
    let streaming = false;
    let startAndStop = document.getElementById('startAndStop');

    inputSize = [640, 480];
    mean = [127.5, 127.5, 127.5];
    std = 0.007843;
    swapRB = false;
    confThreshold = 0.5;
    nmsThreshold = 0.4;

    // the type of output, can be YOLO or SSD
    outType = "YOLO";

    // url for label file, can from local or Internet
    labelsUrl = "{{ asset('yolo/yolov4.txt') }}";
    modelPath = "{{ asset('yolo/yolov4.weights') }}";
    configPath = "{{ asset('yolo/yolov4.cfg') }}";

    cv['onRuntimeInitialized']=()=>{
      let videoInput = document.getElementById('videoInput');
      let frame = new cv.Mat(videoInput.height, videoInput.width, cv.CV_8UC4);
      let startAndStop = document.getElementById('startAndStop');
      let cap = new cv.VideoCapture(videoInput);
      let utils = new Utils('errorMessage');

      main = async function(frame) {
          const labels = await loadLables(labelsUrl);
          const input = getBlobFromImage(inputSize, mean, std, swapRB, frame);
          let net = cv.readNet(configPath, modelPath);
          net.setInput(input);
          const start = performance.now();
          const result = net.forward();
          const time  = performance.now()-start;
          const output = postProcess(result, labels, frame);

          updateResult(output, time);
          setTimeout(processVideo, 0);
          input.delete();
          net.delete();
          result.delete();
      }

      function processVideo() {
        try {
            if (!streaming) {
                return;
            }
            cap.read(frame);
            main(frame);
        } catch (err) {
            // utils.printError(err);
            console.error(err);
        }
      }

      setTimeout(processVideo, 0);

      loadLables = async function(labelsUrl) {
        let response = await fetch(labelsUrl);
        let label = await response.text();
        label = label.split('\n');
        return label;
      }

      getBlobFromImage = function(inputSize, mean, std, swapRB, image) {
        let mat;
        if (typeof(image) === 'string') {
            mat = cv.imread(image);
        } else {
            mat = image;
        }

        let matC3 = new cv.Mat(mat.matSize[0], mat.matSize[1], cv.CV_8UC3);
        cv.cvtColor(mat, matC3, cv.COLOR_RGBA2BGR);
        let input = cv.blobFromImage(matC3, std, new cv.Size(inputSize[0], inputSize[1]),
                                    new cv.Scalar(mean[0], mean[1], mean[2]), swapRB);

        matC3.delete();
        return input;
      }

      loadModel = async function(e) {
        return new Promise((resolve) => {
        let file = e.target.files[0];
        let path = file.name;
        let reader = new FileReader();
        reader.readAsArrayBuffer(file);
        reader.onload = function(ev) {
          if (reader.readyState === 2) {
            let buffer = reader.result;
            let data = new Uint8Array(buffer);
            cv.FS_createDataFile('/', path, data, true, false, false);
            resolve(path);
          }
        }
        });
      }

      postProcess = function(result, labels, frame) {
        let canvasOutput = document.getElementById('canvasOutput');
        const outputWidth = canvasOutput.width;
        const outputHeight = canvasOutput.height;
        const resultData = result.data32F;

        // Get the boxes(with class and confidence) from the output
        let boxes = [];
        const vecNum = result.matSize[0];
        const vecLength = result.matSize[1];
        const classNum = vecLength - 5;

        for (let i = 0; i < vecNum; ++i) {
          let vector = resultData.slice(i*vecLength, (i+1)*vecLength);
          let scores = vector.slice(5, vecLength);
          let classId = scores.indexOf(Math.max(...scores));
          let confidence = scores[classId];
          if (confidence > confThreshold) {
            let center_x = Math.round(vector[0] * outputWidth);
            let center_y = Math.round(vector[1] * outputHeight);
            let width = Math.round(vector[2] * outputWidth);
            let height = Math.round(vector[3] * outputHeight);
            let left = Math.round(center_x - width / 2);
            let top = Math.round(center_y - height / 2);

            let box = {
                scores: scores,
                classId: classId,
                confidence: confidence,
                bounding: [left, top, width, height],
                toDraw: true
            }
            boxes.push(box);
          }
        }

        // NMS(Non Maximum Suppression) algorithm
        let boxNum = boxes.length;
        let tmp_boxes = [];
        let sorted_boxes = [];
        for (let c = 0; c < classNum; ++c) {
          for (let i = 0; i < boxes.length; ++i) {
            tmp_boxes[i] = [boxes[i], i];
          }
          sorted_boxes = tmp_boxes.sort((a, b) => { return (b[0].scores[c] - a[0].scores[c]); });
          for (let i = 0; i < boxNum; ++i) {
            if (sorted_boxes[i][0].scores[c] === 0) continue;
            else {
              for (let j = i + 1; j < boxNum; ++j) {
                if (IOU(sorted_boxes[i][0], sorted_boxes[j][0]) >= nmsThreshold) {
                  boxes[sorted_boxes[j][1]].toDraw = false;
                }
              }
            }
          }
        }        

        // Draw the saved box into the image
        let output = new cv.Mat(outputWidth, outputHeight, cv.CV_8UC3);
        cv.cvtColor(frame, output, cv.COLOR_RGBA2RGB);
        for (let i = 0; i < boxNum; ++i) {
            if (boxes[i].toDraw) {
                drawBox(boxes[i]);
            }
        }

        return output;


        // Calculate the IOU(Intersection over Union) of two boxes
        function IOU(box1, box2) {
          let bounding1 = box1.bounding;
          let bounding2 = box2.bounding;
          let s1 = bounding1[2] * bounding1[3];
          let s2 = bounding2[2] * bounding2[3];

          let left1 = bounding1[0];
          let right1 = left1 + bounding1[2];
          let left2 = bounding2[0];
          let right2 = left2 + bounding2[2];
          let overlapW = calOverlap([left1, right1], [left2, right2]);

          let top1 = bounding2[1];
          let bottom1 = top1 + bounding1[3];
          let top2 = bounding2[1];
          let bottom2 = top2 + bounding2[3];
          let overlapH = calOverlap([top1, bottom1], [top2, bottom2]);

          let overlapS = overlapW * overlapH;
          return overlapS / (s1 + s2 + overlapS);
        }

        // Calculate the overlap range of two vector
        function calOverlap(range1, range2) {
          let min1 = range1[0];
          let max1 = range1[1];
          let min2 = range2[0];
          let max2 = range2[1];

          if (min2 > min1 && min2 < max1) {
            return max1 - min2;
          } else if (max2 > min1 && max2 < max1) {
            return max2 - min1;
          } else {
            return 0;
          }
        }

        // Draw one predict box into the origin image
        function drawBox(box) {
          let bounding = box.bounding;
          let left = bounding[0];
          let top = bounding[1];
          let width = bounding[2];
          let height = bounding[3];

          cv.rectangle(output, new cv.Point(left, top), new cv.Point(left + width, top + height),
                              new cv.Scalar(0, 255, 0));
          cv.rectangle(output, new cv.Point(left, top), new cv.Point(left + width, top + 15),
                              new cv.Scalar(255, 255, 255), cv.FILLED);
          let text = `${labels[box.classId]}: ${box.confidence.toFixed(4)}`;
          cv.putText(output, text, new cv.Point(left, top + 10), cv.FONT_HERSHEY_SIMPLEX, 0.3,
                                  new cv.Scalar(0, 0, 0));
        }
      }

      startAndStop.addEventListener('click', () => {
          if (!streaming) {
              // utils.clearError();
              utils.startCamera('qvga', onVideoStarted, 'videoInput');
          } else {
              utils.stopCamera();
              onVideoStopped();
          }
      });

      function onVideoStarted() {
          streaming = true;
          startAndStop.innerHTML = '<i class="ri-stop-fill"></i> Stop';
          videoInput.width = videoInput.videoWidth;
          videoInput.height = videoInput.videoHeight;
          // processVideo();
      }

      function onVideoStopped() {
          streaming = false;
          startAndStop.innerHTML = '<i class="ri-live-line"></i> Start Video';
          initStatus();
      }

      function initStatus() {
          document.getElementById('status').innerHTML = '';
          document.getElementById('canvasOutput').style.visibility = "hidden";
          utils.clearError();
      }
    }
  </script>
@endsection
