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
            <div class="camera">
              <div class="backvideo">
                <div class="bb-box">
                  <div class="boundaryBoxList">
                  </div>
                </div>
                <video id="video" class="videos">Video stream not available.</video>
              </div>
            </div>
            <canvas id="canvas" style="display: none"></canvas>
            <div id="canvasImage" >
              <img alt="" id="imageResult">
            </div>
            <form class="mt-5" action="{{route('search.visual.result')}}" method="POST" id="visual_process">
              {{-- <meta name="csrf-token" content="{{ csrf_token() }}" />   --}}
              @csrf
              <input type="text" name="filename" value="">
              {{-- <input type="text" name="category" value=""> --}}
              <select name="category" id="">
                <option value="Camera" selected>Camera</option>
                <option value="Keyboard">Keyboard</option>
                <option value="Laptop">Laptop</option>
                <option value="Mouse">Mouse</option>
                <option value="Tablet">Tablet</option>
                <option value="Printer">Printer</option>
              </select>
            </form>
            <button id="processed" class="btn_1"> Testing</button>
          </div>
          <div class="col-12">
            <video id="videoInput" width="320" height="240"></video>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <canvas id="canvasOutput" style="display: : none;" width="320" height="240"></canvas>
        <div id="status"></div>
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
  <script src="{{ asset('vendors/opencv/utils.js') }}"></script>
  <script type="text/javascript">
    var width = 800; // We will scale the photo width to this
    var height = 600; // This will be computed based on the input stream
    var streaming = false;
    var rt = "";
    var req = "";
    var video = null;
    var canvas = null;
    var photo = null;
    let utils = new Utils('errorMessage');
    $('.backvideo').width(width);
    $('.backvideo').height(height);
    $('.bb-box').width(width);
    $('.bb-box').height(height);
    $('.boundaryBoxList').width(width);
    $('.boundaryBoxList').height(height);

    function startup() {
      console.log("Ok");
      video = document.getElementById('video');
      canvas = document.getElementById('canvas');
      photo = document.getElementById('photo');

      utils.startCamera('vga', onVideoStarted, 'video');
      var clicked = false;

      function onVideoStarted() {
        runRT();
        rt = setTimeout(() => {
          runRT()
          onVideoStarted()
        }, 3000);
      }

      video.addEventListener('canplay', function (ev) {
        if (!streaming) {
          height = video.videoHeight / (video.videoWidth / width);

          // Firefox currently has a bug where the height can't be read from
          // the video, so we will make assumptions if this happens.

          if (isNaN(height)) {
            height = width / (4 / 3);
          }

          video.setAttribute('width', width);
          video.setAttribute('height', height);
          canvas.setAttribute('width', width);
          canvas.setAttribute('height', height);
          streaming = true;
        }
      }, false);
      clearphoto();
    }

    function bbClick(top, left, width, height) {
      // Stop RT YOLO
      clearTimeout(rt);
      req.abort();
      // Process BBOX from canvas Images
      var primaryCanvas = document.getElementById("canvas");
      var canvas = document.createElement("canvas");
      var context = canvas.getContext("2d");
      var canvasElement = $('#canvasImage');

      canvasElement.empty();
      var imageData = new Image();
      var imageRes = new Image();
      dataUrl = primaryCanvas.toDataURL();
      imageData.src = dataUrl;
      canvas.width = width;
      canvas.height = height;
      imageData.onload = () => {
          context.drawImage(imageData,
            left, top,
            width, height,
            0, 0,
            width, height
          );
          imageRes.src = canvas.toDataURL();
          canvasElement.append(imageRes);
        }
      }

      function clearphoto() {
        var context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);

        var data = canvas.toDataURL('image/png');
      }

      function runRT() {
        video = document.getElementById('video');
        var context = canvas.getContext('2d');
        if (width && height) {
          canvas.width = width;
          canvas.height = height;
          context.drawImage(video, 0, 0, width, height);

          var data = canvas.toDataURL('image/png');
          data = data.replace("data:image/png;base64,", "");

          req = $.ajax({
            type: "POST",
            url: "http://127.0.0.1:5000/api/v1/yolo",
            contentType: 'application/json;charset=UTF-8',
            headers: {
              'Access-Control-Allow-Origin': '*',
            },
            data: JSON.stringify({
              imgBase64: data,
            }),
            cache: false,
            success: (data) => {
              data = JSON.parse(JSON.stringify(data))
              if(!Object.keys(data).length) {
                if($('.boundaryBox').length > 0)
                  clearBoundaryBox($('.boundaryBoxList'));
                return;
              }
              if($('.boundaryBox').length == Object.keys(data).length) {
                for (var i = 0; i < Object.keys(data).length; i++) {
                  bbox = $(`#bbox-${i}`);
                  label = $(`#bbox-${i} > .boundary-box-label`);
                  bbox.css("top", data[i].y + "px");
                  bbox.css("left", data[i].x + "px");
                  bbox.css("width", data[i].w + "px");
                  bbox.css("height", data[i].h + "px");
                  label.text(data[i].label);
                }
              }
              else{
                  clearBoundaryBox($('.boundaryBoxList'));
                  for (var i = 0; i < Object.keys(data).length; i++) {
                    console.log("creating bbox");
                    addBoundaryBox($('.boundaryBoxList'), data[i].label, data[i].y, data[i].x, data[i].w, data[i].h, i);
                    console.log("bbox created");
                  }
              }
            },
            failed: (data) => {
              clearBoundaryBox($('.boundaryBoxList'));
            }
          });
        } else {
          clearphoto();
        }
      }

      function clearBoundaryBox(videoElement){
        videoElement.empty();
      }
      function addBoundaryBox(videoElement, label, top, left, width, height, numbering = 0) {
        var el = document.createElement("div");
        var elTitle = document.createElement("div");
        var classAtt = document.createAttribute("class");
        var onClickAtt = document.createAttribute("onClick");
        var classAttElTittle = document.createAttribute("class");

        classAtt.value = "boundaryBox";
        onClickAtt.value = "bbClick(" + top + "," + left + "," + width + "," + height + ")";
        classAttElTittle.value = "boundary-box-label";

        el.setAttributeNode(classAtt);
        el.setAttributeNode(onClickAtt);
        el.id = "bbox-" + numbering;
        elTitle.setAttributeNode(classAttElTittle);

        // Set attribute
        el.style.top = top + "px";
        el.style.left = left + "px";
        el.style.width = width + "px";
        el.style.height = height + "px";

        elTitle.innerText = label;

        el.append(elTitle);

        videoElement.append(el);
      }
      window.addEventListener('load', startup, false);
  </script>

  <script type="text/javascript">
    $('#processed').click(function(e){
      e.preventDefault();

      var _category = $('select[name="category"]').val();
      var _filename = _category + "\\" + $('input[name="filename"]').val();


      // console.log($('input[name="filename"]').val(), $('input[name="category"]').val())
      // console.log(_category, _filename);
      $('#visual_process').submit();

      // var _token = $("meta[name='csrf-token']").attr("content"");
      // var _filename = "testing-1.png";
      // var _category = "camera";

      // // console.log($('textarea[name="note"]').val());

      // $.ajax({
      //   url: "",
      //   type: 'POST',
      //   data: {
      //     "filename": _filename,
      //     "category": _category,
      //     "_token": _token,
      //   },
      //   success: function(data) {
      //     swal({
      //       title: "Product added to order!",
      //       text: "Check cart for payment.",
      //       icon: "success",
      //       timer: 1300
      //     });

      //     setTimeout(function() {
      //       top.location.href = "{{route('transaction.success')}}";
      //     }, 500);
      //   }
      // });
    });
  </script>
@endsection
