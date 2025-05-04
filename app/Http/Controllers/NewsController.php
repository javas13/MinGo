<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\News;
use App\Models\NewsletterSubscription;
use App\Mail\MassMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMassMail;

class NewsController extends Controller
{
    public function NewsList(Request $request)
    {
        $mas = array();
		$mas[] = array('title' => 'Главная', 'link' => '/');
		$mas[] = array('title' => 'Новости', 'link' => '/');

        $newsByMonth = News::query()
        ->select(
            DB::raw('YEAR(created_at) as year'), // Извлекаем год
            DB::raw('MONTH(created_at) as month'), // Извлекаем месяц
            DB::raw('COUNT(*) as total_posts'), // Считаем количество записей
            DB::raw('MAX(id) as max_id')
        )
        ->groupBy('year', 'month') // Группируем по году и месяцу
        ->orderBy('year', 'desc') // Сортируем по году
        ->orderBy('month', 'desc') // Сортируем по месяцу
        ->get();

        $monthList = array();

        $lastMonthNumber = 0;
        $lastMonthYear = 0;
        $iteratNumber = 0;
        foreach ($newsByMonth as $elem) {
            $date = Carbon::create(null, $elem['month'], 1);
            $monthName = $date->translatedFormat('F'); // "октябрь"
            $monthAndYear = $monthName .' ' .$elem['year'];
            $monthList[] = array('date' => $monthAndYear, 'id' => $elem['max_id'], 'month' => $elem['month'], 'year' => $elem['year']);
            if($iteratNumber == 0){
                $lastMonthNumber = $elem['month'];
                $lastMonthYear = $elem['year'];
            }
            $iteratNumber++;
        }

        $lastMonth = $monthList[0];
        $lastMonthNews = News::whereYear('created_at', $lastMonthYear)
        ->whereMonth('created_at', $lastMonthNumber)
        ->orderByDesc('created_at')
        ->get();
        array_shift($monthList);
        return View('news.news-list', ['breads' => $mas, 'months' => $monthList, 'lastMonth' => $lastMonth, 'lastMonthNews' => $lastMonthNews]);
    }

    public function NewsElem($id)
    {
        $news = News::find($id);

        $mas = array();
		$mas[] = array('title' => 'Главная', 'link' => '/');
		$mas[] = array('title' => 'Новости', 'link' => route('news'));
        $mas[] = array('title' => $news->name, 'link' => '/');

        return View('news.news-elem', ['breads' => $mas, 'news' => $news]);
    }

    public function NewsForMonth(Request $request)
    {
        $news = News::whereYear('created_at', $request->input('year'))
        ->whereMonth('created_at', $request->input('month'))
        ->orderByDesc('created_at')
        ->get();
        return response()->json([
            'html' => view('partials.news_list', compact('news'))->render(),
            'success' => true
        ]);
    }

    public function subscribeToTheNewsletter(Request $request)
    {
        parse_str($request->input('dataForm'), $formData);
        $clientMail = $formData['mail'];
        $equalMail = NewsletterSubscription::where('email', $clientMail)->first();
        if($equalMail == null){
            $newsletterSub = new NewsletterSubscription();
            $newsletterSub->email = $clientMail;
            $newsletterSub->save();

            // SendMassMail::dispatch($emails, $content);

            Mail::to($clientMail)->send(new MassMail('Вы успешно подписались на рассылку!'));
            return response()->json([
                'success' => true
            ]);
        }
        else{
            return response()->json([
                'mailExist' => true
            ]);
        }
    }


}
