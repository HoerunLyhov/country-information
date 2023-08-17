<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    //get data from API
    public function index() {
      $response = Http::get('https://restcountries.com/v3.1/all');
      $data['countries'] = json_decode($response->body());
      return view('country', $data);
    }
}
