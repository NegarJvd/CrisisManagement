<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuggestRequest;
use App\Models\Design;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class CrisisStrickenController extends Controller
{
    public function show(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('crisis_stricken.index');
    }
    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000): float|int
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
    private function is_in_range($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $radius): bool
    {
        $distance = $this->haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
        return $distance <= floatval($radius);
    }
    public function suggest(SuggestRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
//        $crisis_lat = 19.820332;
//        $crisis_lon = 19.820332;
//        $number_of_households = 2;

        $crisis_lat = $request->get('latitude');
        $crisis_lon = $request->get('longitude');
        $number_of_households = $request->get('number_of_households');

        $designs = Design::query()
                            ->where('number_of_households', $number_of_households) //
                            ->get();

        $accepted_designs = [];
        foreach ($designs as $design)
        {
            //timbers
            $timbers = $design->timbers();
            $timber_in_range = [];
            foreach ($timbers as $timber)
            {
                $is_in_range = $this->is_in_range($timber->latitude, $timber->longitude, $crisis_lat, $crisis_lon, $timber->radius);
                if ($is_in_range)
                    $timber_in_range[] = $timber;
            }

            if (count($timber_in_range) == 0)
                continue;

            //cnc
            $cnc = $design->cnc();
            $cnc_in_range = [];
            foreach ($cnc as $c)
            {
                $is_in_range = $this->is_in_range($c->latitude, $c->longitude, $crisis_lat, $crisis_lon, $c->radius);
                if ($is_in_range)
                    $cnc_in_range[] = $c;
            }

            if (count($cnc_in_range) == 0)
                continue;

            //if all these steps pass, design is accepted
            $accepted_designs[] = $design;
        }

        return view('crisis_stricken.index', [
            'status' => 'success',
            'designs' => $accepted_designs,
            'latitude' => $crisis_lat,
            'longitude' => $crisis_lon,
            'number_of_households' => $number_of_households
        ]);
    }
}
