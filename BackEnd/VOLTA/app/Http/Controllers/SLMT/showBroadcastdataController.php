<?php

namespace App\Http\Controllers\SLMT;

use Illuminate\Http\Request;
use App\Models\BroadcastData;
use App\Models\SolarSystemInfo;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ShowBroadcastDataController extends Controller
{

    public function getBroadcastDataForClient(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'solar_sys_info_id' => 'required|exists:solar_system_infos,solar_sys_info_id',
            ]);
        } catch (ValidationException $e) {
            return response()->json(["msg" => $e->validator->errors()->first()], 422, [], JSON_PRETTY_PRINT);
        }

        try {

            $solarSystem = SolarSystemInfo::find($validatedData['solar_sys_info_id']);

            // التأكد من وجود broadcast_device_id في النظام الشمسي
            if (!$solarSystem || !$solarSystem->broadcast_device_id) {
                return response()->json([
                    "msg" => "No broadcast device associated with this solar system."
                ], 404, [], JSON_PRETTY_PRINT);
            }

            // جلب بيانات البث بناءً على broadcast_device_id
            $broadcastData = BroadcastData::where('broadcast_device_id', $solarSystem->broadcast_device_id)
                ->select(
                    'broadcast_data_id',
                    'battery_voltage',
                    'solar_power_generation(w)',
                    'power_consumption(w)',
                    'battery_percentage',
                    'electric',
                    'status'
                )
                ->latest()
                ->first();

            if (!$broadcastData) {
                return response()->json([
                    "msg" => "No broadcast data found for this Solar System."
                ], 404, [], JSON_PRETTY_PRINT);
            }

            return response()->json([
                "msg" => "Broadcast data retrieved successfully",
                "Broadcast Data" => $broadcastData
            ], 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            return response()->json(["msg" => $e->getMessage()], 500, [], JSON_PRETTY_PRINT);
        }
    }
}
