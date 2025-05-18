<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Place;
use App\Models\Schedule;
use Illuminate\Support\Facades\Cache;

class PlaceController extends Controller
{

     function placePage($slug, Request $request)
     {
        $place = Place::where('slug', $slug)->firstOrFail();
        $days = config('days');

        $mas = array();
        $mas[] = array('title' => 'Главная', 'link' => '/');
        $mas[] = array('title' => $place->name, 'link' => '/');

        $placeImages = $place->images;


        return View('places.place-page', ['breads' => $mas, 'place' => $place, 'days' => $days, 'images' => $placeImages]);  
    }

}
