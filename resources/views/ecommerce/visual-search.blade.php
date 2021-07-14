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
            <video id="videoInput" width="400" height="400"></video>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <canvas id="canvasOutput" style="visibility: hidden;" width="400" height="400"></canvas>
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



  </script>
@endsection
