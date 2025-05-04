<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function portfolioList(Request $request)
    {
        $mas = array();
		$mas[] = array('title' => 'Главная', 'link' => '/');
		$mas[] = array('title' => 'Портфолио', 'link' => '/');

        return View('portfolio.portfolio-list', ['portfolios' => Portfolio::all()->sortBy('sort_order')], ['breads' => $mas]);
    }

    public function portfolioElem($id, Request $request)
    {
        $portfolio = Portfolio::find($id);

        $mas = array();
		$mas[] = array('title' => 'Главная', 'link' => '/');
		$mas[] = array('title' => 'Портфолио', 'link' => route('portfolio.list'));
        $mas[] = array('title' => $portfolio->name, 'link' => '/');

        $portfolio = Portfolio::find($id);

        return View('portfolio.portfolio-elem', ['portfolio' => $portfolio], ['breads' => $mas]);
    }

}
