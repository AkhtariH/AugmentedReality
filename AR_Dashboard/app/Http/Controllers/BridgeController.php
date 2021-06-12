<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bridge;
use App\Models\Sensor;
use App\Models\User;
use App\Models\UserBridge;
use App\Models\SensorData;
use App\Models\Device;
use Validator,Redirect,Response;

use App\Http\Requests\BridgeStoreRequest;
use App\Http\Requests\BridgeUpdateRequest;

class BridgeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bridges = Bridge::latest()->paginate(9);
        foreach($bridges as $bridge) {
            $sensors = $this->getSensorsOfBridge($bridge->id);
            
            foreach($sensors as $sensor) {
                if (count($sensor->data_collection) > 0) {
                    if ($sensor->data_collection[0]->error == true) {
                        $bridge->error = true;
                        break;
                    }
                }
                $bridge->error = false;
            }
        }
        

        return view('admin.bridge.index', compact('bridges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bridge.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BridgeStoreRequest $request)
    {
        $request->validated();

        $data = $request->all();
        Bridge::create($data);

        return redirect()->route('admin.bridge.index')->with('success', 'Bridge has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $device = Device::where('bridge_id', $id);
        if ($device->first()) {
            $bridge = Bridge::join('devices', 'bridges.id', '=', 'devices.bridge_id')
            ->where('bridges.id', $id)
            ->select('bridges.*', 'devices.ttn_dev_id')
            ->get()
            ->first();
        } else {
            $bridge = Bridge::where('id', $id)
                ->first();
        }


        $sensors = $this->getSensorsOfBridge($id);

        if (Auth()->user()->isAdmin()) {
            $users = User::all()->sortByDesc('type');

            foreach ($users as $user) {
                $userBridge = UserBridge::where([
                    ['user_id', '=', $user->id], 
                    ['bridge_id', '=', $id]
                ])->get();

                if (!$userBridge->isEmpty()) {
                    $user->checked = true;
                } else {
                    $user->checked = false;
                }
            }

            
            return view('admin.bridge.show', compact('bridge', 'sensors', 'users'));
        }

        return view('admin.bridge.show', compact('bridge', 'sensors'));
    }

    public function getSensorsOfBridge($id) {
        $sensors = Sensor::join('sensor_type', 'sensors.sensor_type_id', '=', 'sensor_type.id')
            ->join('devices', 'sensors.device_id', '=', 'devices.id')
            ->where('devices.bridge_id', $id)
            ->select('sensors.*', 'sensor_type.type', 'sensor_type.data_attribute', 'devices.ttn_dev_id')
            ->get();


        foreach ($sensors as $sensor) {
            $sensorData = SensorData::where('sensor_id', $sensor->id)
                                ->select('data', 'error', 'created_at', 'threshold_value')
                                ->latest()
                                ->get();
            $dataArr = [];
            foreach ($sensorData as $data) {
                array_push($dataArr, $data);
            }
            $sensor->data_collection = $dataArr;
        }

        return $sensors;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bridge = Bridge::findOrFail($id);
        return view('admin.bridge.edit', compact('bridge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BridgeUpdateRequest $request, $id)
    {
        $request->validated();

        $data = $request->all();

        $bridge = Bridge::findOrFail($id);
        $bridge->update($data);

        return redirect()->route('admin.bridge.index')->with('success', 'Bridge has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bridge = Bridge::findOrFail($id);
        $bridge->delete();

        return redirect()->route('admin.bridge.index')->with('success', 'Bridge has been deleted!');
    }
}
