<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ThresholdRequest;
use App\Models\Sensor;

class ThresholdController extends Controller
{
    public function threshold(ThresholdRequest $request) {
        $request->validated();
        
        $data = collect(['threshold_value' => $request->input('threshold_value')]);

        $sensor = Sensor::findOrFail($request->input('id'));
        $sensor->update($data->toArray());

        return response()->json(array('msg', 'Success!'), 200);
    }
}
