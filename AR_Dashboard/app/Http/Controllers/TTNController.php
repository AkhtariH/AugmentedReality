<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\UpstreamEvent;
use App\Events\SensorThresholdExceeded;

use App\Models\Device;
use App\Models\Sensor;
use App\Models\SensorData;
use App\Models\Bridge;


class TTNController extends Controller
{

    public function index(Request $request) {
        $device = Device::where('ttn_dev_id', $request->id)->first();
        if ($device === null) {
            $bridge = Bridge::where('bridgeHash', $request->bridge)
                ->first();
            $newDev = Device::create([
                'ttn_dev_id' => $request->id,
                'bridge_id' => $bridge->id
            ]);
            

            foreach($request->sensors as $sensor) {
                $type = 0;
                switch($sensor['type']) {
                    case 'Humidity':
                        $type = 1;
                        break;
                    case 'Color':
                        $type = 2;
                        break;
                    case 'Temperature':
                        $type = 3;
                        break;
                    default:
                        $type = 1;
                }

                $newSensor = Sensor::create([
                    'sensor_type_id' => $type,
                    'name' => $sensor['name'],
                    'active' => 1,
                    'threshold_value' => 0,
                    'device_id' => $newDev->id,
                    'ttn_sensor_id' => $sensor['id'],
                ]);

                $sensorData = '';
                if ($sensor['type'] == 'Color') {
                    $rgb = $sensor['data']['r'] + $sensor['data']['g'] + $sensor['data']['b']; // CHANGE THIS
                    $sensorData = $rgb;
                } else {
                    $sensorData = $sensor['data'];
                }

                SensorData::create([
                    'sensor_id' => $newSensor->id,
                    'data' => $sensorData,
                    'error' => 0,
                    'threshold_value' => 0,
                ]);
            }
        } else {
            foreach ($request->sensors as $sensor) {
                $sensorDB = Sensor::where('ttn_sensor_id', $sensor['id'])->first();
                $sensorData = '';
                if ($sensor['type'] == 'Color') {
                    $rgb = $sensor['data']['r'] + $sensor['data']['g'] + $sensor['data']['b']; // CHANGE THIS
                    $sensorData = $rgb;
                } else {
                    $sensorData = $sensor['data'];
                }

                $error = 0;
                if ($sensor['data'] >= $sensorDB->threshold_value) {
                    $error = 1;
                    
                    $sensorDB->data = $sensor['data'];
                    //event(new SensorThresholdExceeded($sensorDB));
                }   
    
                SensorData::create([
                    'sensor_id' => $sensorDB->id,
                    'data' => $sensorData,
                    'error' => $error,
                    'threshold_value' => $sensorDB->threshold_value,
                ]);

                
            }
        }   
        
        event(new UpstreamEvent($request->id, $request->sensors));

        return 'Event fired!';
    }
}
