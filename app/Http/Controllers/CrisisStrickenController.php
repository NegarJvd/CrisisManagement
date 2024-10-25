<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuggestRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;

class CrisisStrickenController extends Controller
{
    public function show(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('crisis_stricken.index');
    }
    public function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000): float|int
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return ($angle * $earthRadius) / 1000; //km
    }
    public function is_in_range($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $radius): bool
    {
        $distance = $this->haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
        return $distance <= floatval($radius);
    }
    public function providers_list(SuggestRequest $request): JsonResponse
    {
        $crisis_lat = $request->get('latitude');
        $crisis_lon = $request->get('longitude');

        //timber_providers
        $timber_providers = User::query()
                        ->whereHas('timber_supplies')
                        ->get();

        $timber_providers_in_range = [];
        foreach ($timber_providers as $provider)
        {
            $in_range_supply_points = [];
            foreach ($provider->timber_supplies as $supply_point){
                $is_in_range = $this->is_in_range($supply_point->latitude, $supply_point->longitude, $crisis_lat, $crisis_lon, $supply_point->radius);
                if ($is_in_range)
                    $in_range_supply_points[] = $supply_point;
            }

            if (count($in_range_supply_points) > 0){
                $timber_providers_in_range[] = [
                    'provider' => [
                        'id' => $provider->id,
                        'name' => $provider->name,
                        'email' => $provider->email
                    ],
                    'supply_points' => $in_range_supply_points];
            }
        }

        //CNC providers
        $CNC_providers = User::query()
            ->whereHas('cnc_supplies')
            ->get();

        $CNC_providers_in_range = [];
        foreach ($CNC_providers as $provider)
        {
            $in_range_supply_points = [];
            foreach ($provider->cnc_supplies as $supply_point){
                $is_in_range = $this->is_in_range($supply_point->latitude, $supply_point->longitude, $crisis_lat, $crisis_lon, $supply_point->radius);
                if ($is_in_range)
                    $in_range_supply_points[] = $supply_point;
            }

            if (count($in_range_supply_points) > 0){
                $CNC_providers_in_range[] = [
                    'provider' => [
                        'id' => $provider->id,
                        'name' => $provider->name,
                        'email' => $provider->email
                    ],
                    'supply_points' => $in_range_supply_points];
            }
        }

        return response()->json([
            'timber_providers' => $timber_providers_in_range,
            'cnc_providers' => $CNC_providers_in_range
        ]);
    }
}
