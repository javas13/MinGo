<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Place;
use Illuminate\Support\Facades\Cache;

class KvizController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            'mood' => ['required', 'in:sad,normal,happy'],
            'company' => ['required', 'in:alone,family,date,friends'],
            'activity' => ['required', 'in:eat,walk,rest'],
            'budget' => ['required', 'in:1000,1500,2000,3000,3000+'],
            'atmosphere' => ['required', 'in:quiet,noisy,any']
        ]);

        // $query = Place::select('id', 'name', 'average_bill', 'thumb_image_src', 'address');
        $query = Place::select('id');

        $searchValuesMood = $validated['mood'];
        $query->whereJsonContains('mood', $searchValuesMood);

        $searchValuesCompany = $validated['company'];
        $query->whereJsonContains('company', $searchValuesCompany);

        $searchValuesActivity = $validated['activity'];
        $query->whereJsonContains('activity', $searchValuesActivity);

        $searchValuesBudget = $validated['budget'];
        $query->whereJsonContains('budget', $searchValuesBudget);

        $searchValuesAtmosphere = $validated['atmosphere'];
        if($searchValuesAtmosphere != 'any'){
            $query->whereJsonContains('atmosphere', $searchValuesAtmosphere);
        }
        
        // $places = $query->paginate(24);
        $placesIds = $query->get()->modelKeys();

        $cacheKey = 'filtered_places_' . uniqid();

        // Сохраняем в кэш на 60 минут
        Cache::put($cacheKey, $placesIds, now()->addMinutes(60));

        $urlKey = str_replace('filtered_places_', '', $cacheKey);
        $temporaryUrl = route('temporary.results', ['key' => $urlKey]);

        return response()->json(['data' => $temporaryUrl]);

        // return redirect()->route('temporary.results', ['key' => $urlKey]);

        // dd($places);
        
    }

     function kvizResults(Request $request)
    {
        $mas = array();
		$mas[] = array('title' => 'Главная', 'link' => '/');
		$mas[] = array('title' => 'Каталог баз', 'link' => '/');

        $places = Place::All();

        return View('kviz.results', ['breads' => $mas, 'places' => $places]);  
    }

}
