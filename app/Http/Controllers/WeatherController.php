<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class WeatherController extends Controller
{
    public function getTemperature(Request $request)
    {

        $latitude = $request->input("latitude");
        $longitude = $request->input("longitude");
        date_default_timezone_set('Europe/Berlin');
        $response = Http::get('http://www.7timer.info/bin/api.pl?lon=' . $longitude . '&lat=' . $latitude . '&product=civil&output=json');
        $response_json = json_decode($response->body());
        $last_updated_time = substr($response_json->init, -2);
        $hour = date('H');
        $timepoint_value = ceil(($hour - $last_updated_time) / 3);
        $temperature=$response_json->dataseries[$timepoint_value-1]->temp2m;
        return view('result',compact('temperature'));
        }

}
