@extends('layout.app')

@section('title', 'Simulator')

@section('header')
<link href="{{ asset('/TemplateData/style.css') }}" rel="stylesheet">
@endsection

@section('content')
@if($errors->any()) 

<div class="alert alert-danger">{{$errors->first()}}</div>
@endif

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
      <div id="unity-container" class="unity-desktop" style="width: 960px;">
        <canvas id="unity-canvas" width=960 height=600></canvas>
        <div id="unity-loading-bar">
          <div id="unity-logo"></div>
          <div id="unity-progress-bar-empty">
            <div id="unity-progress-bar-full"></div>
          </div>
        </div>
        <div id="unity-mobile-warning">
          WebGL builds are not supported on mobile devices.
        </div>
        <div id="unity-footer">
          <div id="unity-webgl-logo"></div>
          <div id="unity-build-title"><strong>{{ $object->name }}</strong></div>
        </div>
      </div>
      <script>
        var buildUrl = "Build";
        var loaderUrl = buildUrl + "/Build.loader.js";
        var config = {
          dataUrl: buildUrl + "/Build.data",
          frameworkUrl: buildUrl + "/Build.framework.js",
          codeUrl: buildUrl + "/Build.wasm",
          streamingAssetsUrl: "StreamingAssets",
          companyName: "AR vanHeekPlein",
          productName: "AR Simulator",
          productVersion: "0.1",
        };
  
        var container = document.querySelector("#unity-container");
        var canvas = document.querySelector("#unity-canvas");
        var loadingBar = document.querySelector("#unity-loading-bar");
        var progressBarFull = document.querySelector("#unity-progress-bar-full");
        var mobileWarning = document.querySelector("#unity-mobile-warning");
        var sessionId = parseInt("{{ $session->id }}");

        // By default Unity keeps WebGL canvas render target size matched with
        // the DOM size of the canvas element (scaled by window.devicePixelRatio)
        // Set this to false if you want to decouple this synchronization from
        // happening inside the engine, and you would instead like to size up
        // the canvas DOM size and WebGL render target sizes yourself.
        // config.matchWebGLToCanvasSize = false;
  
        if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
          container.className = "unity-mobile";
          // Avoid draining fillrate performance on mobile devices,
          // and default/override low DPI mode on mobile browsers.
          config.devicePixelRatio = 1;
          mobileWarning.style.display = "block";
          setTimeout(() => {
            mobileWarning.style.display = "none";
          }, 5000);
        } else {
          canvas.style.width = "960px";
          canvas.style.height = "600px";
        }
        loadingBar.style.display = "block";
  
        var script = document.createElement("script");
        script.src = loaderUrl;
        script.onload = () => {
          createUnityInstance(canvas, config, (progress) => {
            progressBarFull.style.width = 100 * progress + "%";
          }).then((unityInstance) => {
            unityInstance.SendMessage('User_ModelLoader', 'Execute', sessionId);
            loadingBar.style.display = "none";
          }).catch((message) => {
            alert(message);
          });
        };
        document.body.appendChild(script);
      </script>
    </div>
 </div>
<div class="row" style="margin-top: 50px;">
<div class="col-xl-4 col-lg-4">
  <div class="card border-0 pb-0">
      <div class="card-header border-0 pb-0">
          <h4 class="card-title">Controls</h4>
      </div>
      <div class="card-body"> 
          <div id="DZ_W_Todo4" class="widget-media ps ps--active-y">
              <ul class="timeline">
                  <li>
                      <div class="timeline-panel">
                        <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                          <label class="" for="customCheckBox1"><span class="badge bg-secondary" style="color: white;">C</span></label>
                        </div>
                                                <div class="media-body">
                          <h5 class="mb-0">Change Camera to top-down view</h5>
                        </div>
                      </div>
                  </li>
                  <li>
                    <div class="timeline-panel">
                      <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                        <label class="" for="customCheckBox1"><span class="badge bg-secondary" style="color: white;">M</span></label>
                      </div>
                                              <div class="media-body">
                        <h5 class="mb-0">Lock camera while in first person view so you can't move the mouse</h5>
                      </div>
                    </div>
                </li>
                <li>
                  <div class="timeline-panel">
                    <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                      <label class="" for="customCheckBox1"><span class="badge bg-secondary" style="color: white;">R</span></label>
                    </div>
                                            <div class="media-body">
                      <h5 class="mb-0">Rotate object</h5>
                    </div>
                  </div>
              </li>

              <li>
                <div class="timeline-panel">
                  <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                    <label class="" for="customCheckBox1"><span class="badge bg-secondary" style="color: white;">P</span></label>
                  </div>
                                          <div class="media-body">
                    <h5 class="mb-0">Move object up</h5>
                  </div>
                </div>
            </li>
            <li>
              <div class="timeline-panel">
                <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                  <label class="" for="customCheckBox1"><span class="badge bg-secondary" style="color: white;">O</span></label>
                </div>
                                        <div class="media-body">
                  <h5 class="mb-0">Move object down</h5>
                </div>
              </div>
          </li>
          <li>
            <div class="timeline-panel">
              <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                <label class="" for="customCheckBox1"><span class="badge bg-secondary" style="color: white;">Plus</span></label>
              </div>
                                      <div class="media-body">
                <h5 class="mb-0">Increase size of object</h5>
              </div>
            </div>
        </li>
        <li>
          <div class="timeline-panel">
            <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
              <label class="" for="customCheckBox1"><span class="badge bg-secondary" style="color: white;">Minus</span></label>
            </div>
                                    <div class="media-body">
              <h5 class="mb-0">Decrease size of object</h5>
            </div>
          </div>
      </li>

      <li>
        <div class="timeline-panel">
          <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
            <label class="" for="customCheckBox1"><span class="badge bg-secondary" style="color: white;">K, H, U, J</span></label>
          </div>
          <div class="media-body">
            <h5 class="mb-0">Move object right, left, up and down</h5>
          </div>
        </div>
    </li>
              </ul>
          <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 370px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 322px;"></div></div></div>
      </div>
  </div>
</div>
</div>
@endsection
@section('scripts')
    <script>
        var errorMsg = '{{ $errors->first() }}';
        if (errorMsg != '' && errorMsg != null) {
            toastr.error(errorMsg, "Error", {
                timeOut: 20000,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                positionClass: "toast-top-right",
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            }).css({
                "width": "500px",
                "max-width": "500px",
                "font-size": "20px"
            });
        }

        var successMsg = '{{ session("success") }}';
        if (successMsg != '' && successMsg != null) {
            toastr.success(successMsg, "Success", {
                timeOut: 10000,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                positionClass: "toast-top-right",
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            }).css({
                "width": "500px",
                "max-width": "500px",
                "font-size": "20px"
            });
        }
    </script>
@endsection