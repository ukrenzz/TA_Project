console.log("Test")

cv['onRuntimeInitialized']=()=>{
  let frame = new cv.Mat(videoInput.height, videoInput.width, cv.CV_8UC4);
      let cap = new cv.VideoCapture(videoInput);
      let configPath = ("{{ asset('yolo/yolov4.cfg') }}");
      let modelPath = ("{{ asset('yolo/yolov4.weights') }}");
      let load = 0;
      let label = "";

      init = async function() {
        try{
          if(load == 0){
            configPath = await loadModel("{{ asset('yolo/yolov4.cfg') }}");
            modelPath = await loadModel("{{ asset('yolo/yolov4.weights') }}");
            labels = await loadLables(labelsUrl);
            console.log(configPath);
            console.log(modelPath);
            startAndStop.enabled = false;
            load = 1;
          } 
        } catch (e){
          console.error(e);
        }               
      }

      init();
}