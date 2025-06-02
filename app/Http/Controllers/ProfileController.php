<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $mas = array();
		$mas[] = array('title' => 'Главная', 'link' => '/');
		$mas[] = array('title' => 'Настройки профиля', 'link' => '/');

        $user = $request->user();
        return View('profile.index', ['breads' => $mas, 'user' => $user]);
    }

    public function autoUpdate(Request $request)
    {
        $validated = $request->validate([
            'field' => 'required|string|in:name', // Разрешенные поля
            'value' => 'required|string|max:255',          // Правила валидации
        ]);

        $user = auth()->user();
        $user->update([$validated['field'] => $validated['value']]);

        return response()->json(['message' => 'Данные обновлены!']);
    }




}
