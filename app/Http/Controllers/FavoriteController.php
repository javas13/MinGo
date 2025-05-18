<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Place;
use Illuminate\Support\Facades\Cache;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $mas = array();
		$mas[] = array('title' => 'Главная', 'link' => '/');
		$mas[] = array('title' => 'Избранное', 'link' => '/');

        if (auth()->guest()) {
            // Пользователь не авторизован
            return View('favorites.index', ['breads' => $mas, 'error' => 'Пользователь не авторизован']); 
        }

        $places = auth()->user()->favoritePlaces()->paginate(24);
        
        return View('favorites.index', ['breads' => $mas, 'places' => $places]);  
    }

    public function toggle(Request $request, Place $place)
    {
        if (auth()->guest()) {
            // Пользователь не авторизован
            return response()->json(['status' => 'notauth', 'message' => 'Не авторизован']);
        }
        $user = $request->user();
        
        if ($user->favoritePlaces()->where('place_id', $place->id)->exists()) {
            $user->favoritePlaces()->detach($place->id);
            $userFavCount = $user->favoritePlaces()->count();
            return response()->json(['status' => 'removed', 'favCount' => $userFavCount, 'message' => 'Место удалено из избранного']);
        } else {
            $user->favoritePlaces()->syncWithoutDetaching([$place->id]);
            $userFavCount = $user->favoritePlaces()->count();
            return response()->json(['status' => 'added', 'favCount' => $userFavCount, 'message' => 'Место добавлено в избранное']);
        }
    }

    public function check(Place $place)
    {
        return response()->json([
            'is_favorite' => auth()->user()->favoritePlaces()->where('place_id', $place->id)->exists()
        ]);
    }

}
