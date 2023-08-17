<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    //get data from API
    public function index() {
      $countries = session()->get('countries');
      if ($countries) {
        $data['countries'] = $countries;
      }
      else {
        $response = Http::get('https://restcountries.com/v3.1/all');
        $data['countries'] = json_decode($response->body());
        session()->put('countries', $data['countries']);
      }
      return view('country', $data);
    }
    
    //Modal Popup Country Item
    public function show($index) {
      $data = null;
      $countries = session()->get('countries');
      if (isset($countries[$index]))
      {
        $data = $countries[$index];
      }
      return $data;
    }
}
