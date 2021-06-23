<!DOCTYPE html>
<!-- https://github.com/petarjs/js-canny-edge-detector -->
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>CTEBIR Playground</title>
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.min.css">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      padding: 20px;
    }

    .js_controls {
      display: none;
    }

    .js_status {
      display: none;
    }

    .controls--blocked .column *:not(.cancel) {
      opacity: 0.5;
      user-select: none;
    }

    .cancel {
      display: none;
    }

    .input--file {
      width: 0.1px;
      height: 0.1px;
      opacity: 0;
      overflow: hidden;
      position: absolute;
      z-index: -1;
    }

    .input--file+label {
      font-size: 1.25em;
      font-weight: 700;
      display: inline-block;
      cursor: pointer;
      color: #FFFFFF;
      white-space: nowrap;
      display: inline-block;
      overflow: hidden;
      padding: 0.625rem 1.25rem;
      font-size: 1.1rem;
      height: 3.8rem;
      letter-spacing: .1rem;
      line-height: 3.8rem;
      padding: 0 3.0rem;
      font-weight: 700;
      border-radius: .4rem;
      background-color: #9b4dca;
      border: 0.1rem solid #9b4dca;
      text-transform: uppercase;
    }

    .input--file:focus+label,
    .input--file+label:hover {
      background-color: #606c76;
      border-color: #606c76;
      color: #fff;
      outline: 0;
    }

    .ta-c {
      text-align: center;
    }

    .pb-md {
      padding-bottom: 1rem;
    }

    .controls {
      margin: 0 auto;
    }

    .result {
      position: relative;
      height: 400px;
    }

    .result>section {
      position: absolute;
      width: 100%;
      display: none;
      text-align: center;
    }

    .image-nav {
      margin-top: 2rem;
      display: none;
    }

    .image-nav--active {
      display: inline-block;
    }

    .image-nav>ul {
      display: inline-block;
      list-style-type: none;
      margin: 0;
    }

    .image-nav__item {
      margin: 0;
      display: inline-block;
      width: 2rem;
      height: 2rem;
      cursor: pointer;
      background: #DADADA;
      border-radius: 50%;
    }

    .image-nav__item--active {
      background: #9b4dca;
    }

    .result {
      padding: 0;
    }

    .result .image--active {
      display: inline-block;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="column ta-c">
        <a href="https://github.com/petarjs/js-canny-edge-detector">Back to GitHub</a>
        <h1 class="ta-c pb-md">Canny Edge Detector</h1>
      </div>
    </div>

    <div class="row">
      <div class="column">
        <div class="upload-image ta-c pb-md">
          <input type="file" id="image" class="input--file js_image">
          <label for="image">Choose Image</label>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="column ta-c">
        <div class="js_controls controls">
          <div class="row">
            <div class="column">
              <input type="text" class="js_lt" placeholder="Lower Treshold (0-1)">
              <input type="text" class="js_ut" placeholder="Upper Treshold (0-1)">
            </div>
          </div>

          <div class="row">
            <div class="column">
              <button class="button js_submit">Find Edges</button>
              <button class="button cancel js_cancel">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="column ta-c">
        <div class="js_status"></div>
      </div>
    </div>

    <div class="row">
      <div class="column ta-c">
        <div class="image-nav js_image-nav">
          <ul>
            <li data-target="js_image--from" class="image-nav__item" title="Start"></li>
            <li data-target="js_image--grayscale" class="image-nav__item" title="Grayscale"></li>
            <li data-target="js_image--blurred" class="image-nav__item" title="Blurred"></li>
            <li data-target="js_image--x-derived" class="image-nav__item" title="X derived"></li>
            <li data-target="js_image--y-derived" class="image-nav__item" title="Y derived"></li>
            <li data-target="js_image--result" class="image-nav__item" title="Result"></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="column result">
        <section class="js_image--from">
          <canvas class="image--from"></canvas>
        </section>

        <section class="js_image--grayscale">
          <canvas class="image--grayscale"></canvas>
        </section>

        <section class="js_image--blurred">
          <canvas class="image--blurred"></canvas>
        </section>

        <section class="js_image--x-derived">
          <canvas class="image--x-derived"></canvas>
        </section>

        <section class="js_image--y-derived">
          <canvas class="image--y-derived"></canvas>
        </section>

        <section class="js_image--result">
          <canvas class="image--result"></canvas>
        </section>
      </div>
    </div>
  </div>

</body>

</html>

<script src="{{URL::asset('vendors/ctebir/main.js')}}"></script>
<script src="{{URL::asset('vendors/ctebir/index.js')}}"></script>
<script>
  let worker = new Worker("URL::asset('vendors/ctebir/worker.js')")
  worker.postMessage({
    cmd: 'appData',
    data: {
      width: window.appData.width,
      height: window.appData.height,
      ut: window.appData.ut,
      lt: window.appData.lt
    }
  })
  worker.postMessage({
    cmd: 'imgData',
    data: pixels
  })
  const imgd = canvasFrom
    .getContext('2d')
    .getImageData(0, 0, width, height)

  const imageData = imgd.data
</script>