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




}
