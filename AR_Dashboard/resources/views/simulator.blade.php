@extends('layout.app')

@section('title', 'Simulator')
@section('subtitle', '...')

@section('content')
@if($errors->any()) 

<div class="alert alert-danger">{{$errors->first()}}</div>
@endif

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
      <div id="unity-container" class="unity-desktop">
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
          <div id="unity-fullscreen-button"></div>
          <div id="unity-build-title">AR Simulator</div>
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
        var fullscreenButton = document.querySelector("#unity-fullscreen-button");
        var mobileWarning = document.querySelector("#unity-mobile-warning");
  
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
            unityInstance.SendMessage('User_ModelLoader', 'Execute', 5);
            loadingBar.style.display = "none";
            fullscreenButton.onclick = () => {
              unityInstance.SetFullscreen(1);
            };
          }).catch((message) => {
            alert(message);
          });
        };
        document.body.appendChild(script);
      </script>
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