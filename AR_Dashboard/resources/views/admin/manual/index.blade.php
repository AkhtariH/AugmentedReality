@extends('layout.app')

@section('title', 'Help')

@section('content')
    <h1>Manual</h1>
    <hr/>
    <ul class="list-group list-group-flush">
        <a href="#1"><li class="list-group-item">1. Register a new device/microcontroller</li></a>
        <a href="#2"><li class="list-group-item">2. Install libraries for device/microcontroller</li></a>
        <a href="#3"><li class="list-group-item">3. Set up sensors for a new device/microcontroller</li></a>
        <a href="#4"><li class="list-group-item">4. Set up code for a new device/microcontroller</li></a>
        <a href="#5"><li class="list-group-item">5. Add/register a new bridge</li></a>
    </ul>

    <br>
    <br>
    <h4 class="inline" id="1" style="margin-top: 15px;">1. Register a new device/microcontroller</h4>
    <hr/>
    <div class="mt-1 mb-5 button-container">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="glider-contain" style="width: 80%;">
                    <div class="glider" id="glider1" style="margin: 0 auto;height: 500px;text-align:center;line-height: 25px;">
                      <div style="">
                        <p>
                            <h3 style="color: #dc3545;"><b>Step 1</b></h3><br>Go to: thethingsnetwork.org
                            <br><br>
                            <img src="{{ asset('/img/help/photo0.png') }}" alt="LOGIN" width="400px"/>
                        </p>
                      </div>
                      <div>
                        <p>
                            <h3 style="color: #dc3545;"><b>Step 2</b></h3><br>Login to your The Things Network account and go to the console subpage.
                            <br><br>
                            <img src="{{ asset('/img/help/photo1.png') }}" alt="LOGIN" width="500px"/>
                        </p>
                      </div>
                      <div>
                        <p>
                            <h3 style="color: #dc3545;"><b>Step 3</b></h3>
                            <br>
                            Go to The Things Network console and click on ‘Application’ and choose the desired application.
                            <br>
                            <img src="{{ asset('/img/help/photo2.png') }}" alt="APPLICATION" width="500px"/>
                        </p>
                      </div>
                      <div>
                        <p>
                            <h3 style="color: #dc3545;"><b>Step 4</b></h3>
                            <br>
                            Scroll down to the ‘DEVICES’ tab and click on ‘register device’.
                            <br>
                            <img src="{{ asset('/img/help/photo3.png') }}" alt="DEVICES" width="500px"/>
                        </p>
                      </div>
                        <div>
                            <p>
                                <h3 style="color: #dc3545;"><b>Step 5</b></h3>
                                <br>
                                The menu below will now be displayed. Enter the desired device ID here. Click on the crossed arrows icon on the left of the 'Device EUI'. This will make the Device EUI generate automatically. Then click on 'Register'. 
                                <br>
                                <img src="{{ asset('/img/help/photo4.png') }}" alt="DEVICES" width="500px"/>
                            </p>
                        </div>
                        <div>
                            <p>
                                <h3 style="color: #dc3545;"><b>Step 6</b></h3>
                                <br>
                                You have now added a new device. You will now be redirected to the device overview. Here you can see that the activation method is 'OTAA'. Adjust this in the settings of the device to 'ABP' and save your adjustment. After this you will return to the device overview. 5 different codes are shown, but only these 3 are of importance: Device Address, Network Session Key and App Session Key. These codes are required to link a physical microcontroller board to The Things Network.
                                <br>
                                <img src="{{ asset('/img/help/photo5.png') }}" alt="DEVICE OVERVIEW" width="500px"/>
                                <img src="{{ asset('/img/help/ABP.png') }}" alt="DEVICE OVERVIEW" width="250px"/>
                            </p>
                        </div>
                    </div>
                  
                    <button aria-label="Previous" class="glider-prev"><i class="fas fa-chevron-left"></i></button>
                    <button aria-label="Next" class="glider-next"><i class="fas fa-chevron-right"></i></button>
                    <div role="tablist" class="dots"></div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="inline" id="2" style="margin-top: 15px;">2. Install libraries for device/microcontroller</h4>
    <hr/>
    <div class="mt-1 mb-5 button-container">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="glider-contain" style="width: 80%;">
                    <div class="glider" id="glider2" style="margin: 0 auto;height: 500px;text-align:center;line-height: 25px;">
                        <div>
                            <h3 style="color: #dc3545;"><b>Step 1</b></h3><br>On the Arduino IDE click on <br>
                                             Sketch -> Include Library -> Add .ZIP Library…
                            <br>
                            <img src="{{ asset('/img/help/photo21.png') }}" alt="LOGIN" width="500px"/>
                        </div>
                        <div>
                            <h3 style="color: #dc3545;"><b>Step 2</b></h3></h3><br>This will open a file explorer. Select your .zip library file, click the choose button and then the library will install.
                            <br>
                            <img src="{{ asset('/img/help/photo22.png') }}" alt="LOGIN" width="500px"/>
                        </div>
                    </div>
                  
                    <button aria-label="Previous" class="glider-prev" id="glider-prev2"><i class="fas fa-chevron-left"></i></button>
                    <button aria-label="Next" class="glider-next" id="glider-next2"><i class="fas fa-chevron-right"></i></button>
                    <div role="tablist" class="dots" id="dots2"></div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="inline" id="3" style="margin-top: 15px;">3. Set up sensors for a new device/microcontroller</h4>
    <hr/>
    <div class="mt-1 mb-5 button-container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Heltec ESP32 Lora Wifi Kit (V2) Pinout mapping:</h5>
                <img src="{{ asset('/img/help/ESP32.png') }}" alt="LOGIN" width="500px" height="325px" />
                <br>
                <br>
                <img src="{{ asset('/img/help/DHT22.jpg') }}" alt="LOGIN" width="250px" height="200px" />
                <p>
                    <b>Step 1</b><br>Connect 1. VCC to 3V3 pin
                    <br>
                </p>
                <br>
                <p>
                    <b>Step 2</b><br>Connect 4. GND to GND
                    <br>
                </p>
                <br>
                <p>
                    <b>Step 3</b><br>Connect 2. DATA to pin 33
                    <br>
                </p>
                <br>
                <br>
                <img src="{{ asset('/img/help/TCS3200.png') }}" alt="LOGIN" width="500px"/>
                <p>
                    <b>Step 1</b><br>Connect VCC to 5v
                    <br>
                </p>
                <br>
                <p>
                    <b>Step 2</b><br>Connect GND to GND
                    <br>
                </p>
                <br>
                <p>
                    <b>Step 3</b><br>Connect S0 to pin 37
                    <br>
                </p>
                <br>
                <p>
                    <b>Step 4</b><br>Connect S1 to pin 36
                    <br>
                </p>
                <br>
                <p>
                    <b>Step 5</b><br>Connect S2 to pin 39
                    <br>
                </p>
                <br>
                <p>
                    <b>Step 6</b><br>Connect S3 to pin 38
                    <br>
                </p>
                <br>
                <p>
                    <b>Step 7</b><br>Connect Output to pin 32
                    <br>
                </p>
            </div>
        </div>
    </div>

    <h4 class="inline" id="4" style="margin-top: 15px;">4. Set up code for a new device/microcontroller</h4>
    <hr/>
    <div class="mt-1 mb-5 button-container">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="glider-contain" style="width: 80%;">
                    <div class="glider" id="glider3" style="margin: 0 auto;height: 500px;text-align:center;line-height: 25px;">
                        <div>
                            <h3 style="color: #dc3545;"><b>Step 1</b></h3><br>If you have installed all the libraries, open: HOBO.ino
                            <br>
                        </div>
                        <div>
                            <h3 style="color: #dc3545;"><b>Step 2</b></h3><br>These 3 values must be changed according to The Things Network.
                            <br>
                            <img src="{{ asset('/img/help/photo41.png') }}" alt="LOGIN" width="500px"/>
                        </div>
                        <div>
                            <h3 style="color: #dc3545;"><b>Step 3</b></h3><br>
                            NWSKEY = Network Session Key<br>
                            APPSKEY = App Session Key<br>
                            DEVADDR = Device Address
                            <br>
                        </div>
                        <div>
                            <h3 style="color: #dc3545;"><b>Step 4</b></h3><br>Open TTN Console and go to the device you wish to register and go to the Device Overview page. <br>
                            Press these buttons:
                            <br>
                            <img src="{{ asset('/img/help/photo42_1.png') }}" alt="LOGIN" width="500px"/>
                            <img src="{{ asset('/img/help/photo42_2.png') }}" alt="LOGIN" width="500px"/>
                        </div>
                        <div>
                            <h3 style="color: #dc3545;"><b>Step 5</b></h3><br>Copy the keys from the TTN console and copy them into the code, it should look something like this:
                            <br>
                            <img src="{{ asset('/img/help/photo43.png') }}" alt="LOGIN" width="500px"/>
                            <br>
                            <br>
                            <u><b>IMPORTANT:</b></u> DEVADDR is 0x + Device Address, as can be seen above.
                        </div>
                        <div style="padding: 20px !important;">
                            <h3 style="color: #dc3545;"><b>Step 6</b></h3><br>Besides the keys you must also fill in the hash keys as can be seen below:
                            <br>
                            <img src="{{ asset('/img/help/photo61.png') }}" alt="LOGIN" width="250px"/>
                            <img src="{{ asset('/img/help/photo62.png') }}" alt="LOGIN" width="250px"/>
                            <br>
                            <br>
                            <u><b>IMPORTANT:</b></u> Each hash is unique, DHT is from 1000-1999, TCS230 is from 2000-2999 and Bridge is from 100-199. Each bridge and sensor has its own unique key. This key is used to match a sensor to a bridge. The bridge hash is required when creating a new bridge on the website, this explained in: “Add/Register a new bridge”.
                        </div>
                    </div>
                  
                    <button aria-label="Previous" class="glider-prev" id="glider-prev3"><i class="fas fa-chevron-left"></i></button>
                    <button aria-label="Next" class="glider-next" id="glider-next3"><i class="fas fa-chevron-right"></i></button>
                    <div role="tablist" class="dots" id="dots3"></div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="inline" id="5" style="margin-top: 15px;">5. Add/register a new bridge</h4>
    <hr/>
    <div class="mt-1 mb-5 button-container">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="glider-contain" style="width: 80%;">
                    <div class="glider" id="glider4" style="margin: 0 auto;height: 500px;text-align:center;line-height: 25px;">
                        <div>
                            <h3 style="color: #dc3545;"><b>Step 1</b></h3><br>Click on "Manage bridges".
                            <br>
                            <img src="{{ asset('/img/help/photo51.png') }}" alt="LOGIN" width="500px"/>
                        </div>
                        <div>
                            <h3 style="color: #dc3545;"><b>Step 2</b></h3><br>Click on "+Add bridge".
                            <br>
                            <img src="{{ asset('/img/help/photo52.png') }}" alt="LOGIN" width="500px"/>
                        </div>
                        <div>
                            <h3 style="color: #dc3545;"><b>Step 3</b></h3><br>Fill in all the fields, the bridge hash must match the bridge hash that you entered in the code.
                            <br>
                            <img src="{{ asset('/img/help/photo53.png') }}" alt="LOGIN" width="500px"/>
                        </div>
                    </div>
                  
                    <button aria-label="Previous" class="glider-prev" id="glider-prev4"><i class="fas fa-chevron-left"></i></button>
                    <button aria-label="Next" class="glider-next" id="glider-next4"><i class="fas fa-chevron-right"></i></button>
                    <div role="tablist" class="dots" id="dots4"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('inclusions')
    @parent
    <script src="{{ asset('/js/glider.min.js') }}"></script>
    <script>
        window.addEventListener('load', function(){
            new Glider(document.querySelector('#glider1'), {
                dots: '.dots',
                arrows: {
                    prev: '.glider-prev',
                    next: '.glider-next'
                },
                scrollLock: true,
                scrollLockDelay: 50
            });

            new Glider(document.querySelector('#glider2'), {
                dots: '#dots2',
                arrows: {
                    prev: '#glider-prev2',
                    next: '#glider-next2'
                },
                scrollLock: true,
                scrollLockDelay: 50
            });

            new Glider(document.querySelector('#glider3'), {
                dots: '#dots3',
                arrows: {
                    prev: '#glider-prev3',
                    next: '#glider-next3'
                },
                scrollLock: true,
                scrollLockDelay: 50
            });

            new Glider(document.querySelector('#glider4'), {
                dots: '#dots4',
                arrows: {
                    prev: '#glider-prev4',
                    next: '#glider-next4'
                },
                scrollLock: true,
                scrollLockDelay: 50
            });
        });
    </script>
@endsection