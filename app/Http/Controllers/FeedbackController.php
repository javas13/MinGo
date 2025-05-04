<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Base;
use App\Models\BaseImage;
use App\Models\SportsDisciplinesBase;
use App\Models\SportsDiscipline;
use App\Models\SportsFacility;
use App\Models\SportsFacilitiesBase;
use App\Models\Region;
use Carbon\Carbon;
use App\Models\MedicalSupport;
use App\Models\MedicalSupportsBase;
use Illuminate\Support\Collection;

class FeedbackController extends Controller
{
    public function sendToTelegram(Request $request)
    {
            // Замените <YOUR_BOT_TOKEN> на токен вашего бота Telegram
            $botToken = '7896217760:AAEONh8NVikRYXMADXyCdnCtEFngsyy1oFw';
        
            // Замените <YOUR_CHAT_ID> на ваш идентификатор чата с ботом
            $chatId = '-4532037484';
        
            // Получение данных из формы обратной связи
            parse_str($request->input('dataForm'), $formData);
            $name = $formData['name'];
            $phone = $formData['phone'];
            $content = $formData['descript'];
            $fromWhere = $request->input('fromWhere');
        
        
            // Создание текстового сообщения
            $text = "$fromWhere . \n\n";
            $text .= "Имя: " . $name . "\n";
            $text .= "Телефон: " . $phone . "\n";
            $text .= "Текст: " . $content . "\n";
           
        
            // Отправка сообщения в Telegram
            $telegramUrl = "https://api.telegram.org/bot" . $botToken . "/sendMessage";
            $data = [
                'chat_id' => $chatId,
                'text' => $text,
            ];
        
            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => http_build_query($data),
                ],
            ];
        
            $context = stream_context_create($options);
            $result = file_get_contents($telegramUrl, false, $context);
        
            // Проверка результата отправки сообщения
            if ($result === false) {
                // Обработка ошибки
                echo "Ошибка отправки сообщения в Telegram.";
            } else {
                echo "Сообщение успешно отправлено в Telegram!";
            }
        //return redirect()->route('home');
    }

    public function kvizSendToTelegram(Request $request)
    {
        $baseText = "Пользователь прошёл квиз! \n";
        $basePriceSelectedText = "";

        $baseDateStart = $request->input('sixAnswer')[0]['value'];
        $baseDateEnd = $request->input('sixAnswer')[1]['value'];

        $baseDateStartCarbon = Carbon::parse($baseDateStart);
        $baseDateStartFormatted = $baseDateStartCarbon->format('d.m.Y');

        $baseDateEndCarbon = Carbon::parse($baseDateEnd);
        $baseDateEndFormatted = $baseDateEndCarbon->format('d.m.Y');



        $basePaymentMethod = $request->input('sevenAnswer')[0]['value'];
        $lengthOfStay = $request->input('eightAnswer')[0]['value'];
        $sportsmensCount = $request->input('nineAnswer')[0]['value'];
        $coachCount = $request->input('nineAnswer')[1]['value'];
        $userName = $request->input('tenAnswer')[0]['value'];
        $userPhone = $request->input('tenAnswer')[1]['value'];
        $userCity = $request->input('tenAnswer')[2]['value'];
        $query = Base::select('id', 'name', 'base_type', 'price', 'image_src', 'address');
        $selectedSports = array_column($request->input('firstAnswer'), 'value');
        $selectedRegions = array_column($request->input('secondAnswer'), 'value');
        $selectedSportFacilities = array_column($request->input('thirdAnswer'), 'value');
        $selectedMedicals = array_column($request->input('fourAnswer'), 'value');
        $selectedPrice = array_column($request->input('fiveAnswer'), 'value');
        $selectedPaymentMethod = array_column($request->input('sevenAnswer'), 'value');
        $basesIds = SportsDisciplinesBase::select('base_id')->whereIn('sports_discipline_id', $selectedSports)->groupBy('base_id')->get();
        $query->whereIn('id', $basesIds);
        $query->whereIn('region_id', $selectedRegions);
        $basesIds2 = SportsFacilitiesBase::select('base_id')->whereIn('sports_facility_id', $selectedSportFacilities)->groupBy('base_id')->get();
        $query->whereIn('id', $basesIds2);
        $basesIds3 = MedicalSupportsBase::select('base_id')->whereIn('medical_support_id', $selectedMedicals)->groupBy('base_id')->get();
        $query->whereIn('id', $basesIds3);
        if(in_array(3000, $selectedPrice)){
            $query->where('price', '<', 3000);
            $basePriceSelectedText = "До 3000 ₽";
        }
        else if(in_array(6000, $selectedPrice)){
            $query->whereBetween('price', [3000, 6000]);
            $basePriceSelectedText = "3000–6000 ₽";
        }
        else if(in_array(6001, $selectedPrice)){
            $query->where('price', '>', 6000);
            $basePriceSelectedText = "6000 ₽ и выше";
        }
        $query->when($selectedPaymentMethod, function ($query) use ($selectedPaymentMethod) {
            $query->where(function ($q) use ($selectedPaymentMethod) {
                foreach ($selectedPaymentMethod as $value) {
                    $q->orWhereJsonContains('payment_options', $value); // Ищем каждое значение через OR
                }
            });
        });

        $selectedSportsClient = SportsDiscipline::whereIn('id', $selectedSports)->get();
        $selectedRegionsClient = Region::whereIn('id', $selectedRegions)->get();
        $selectedSportFacilitiesClient = SportsFacility::whereIn('id', $selectedSportFacilities)->get();
        $selectedMedicalsClient = MedicalSupport::whereIn('id', $selectedMedicals)->get();


        $bases = $query->get();
        //Если пользователю не нашло баз
        if($bases->count() == 0){
            $baseText .= "Пользователю нашло 0 баз \n";
        }
        //Если нашло
        else{
            $baseText .= "Пользователю нашло " . $bases->count() . " баз" . "\n";
            $baseText .= "Список баз: \n";
            foreach($bases as $baseElem){
                $baseText .= "https://sportsfera.pro/base/" . $baseElem->id . "\n";
            }
        }


        $baseText .= "<b>Контакты пользователя:</b> \n";
        $baseText .= "Имя: " . $userName . "\n";
        $baseText .= "Номер телефона: " . $userPhone . "\n";
        $baseText .= "Город пользователя: " . $userCity . "\n";
        $baseText .= "<b>Ответы пользователя:</b> \n";
        $baseText .= "<b>1 вопрос:</b> Какой вид спорта вас интересует? \n";
        $baseText .= "Ответ: \n";
        for ($i = 0; $i < $selectedSportsClient->count(); $i++) {
            $sportName = $selectedSportsClient[$i]->name;
            $answerNumb = $i + 1;
            $baseText .= "$answerNumb.$sportName \n";
        }

        $baseText .= "<b>2 вопрос:</b> В каком регионе вы планируете проводить сборы? \n";
        $baseText .= "Ответ: \n";
        for ($i = 0; $i < $selectedRegionsClient->count(); $i++) {
            $sportName = $selectedRegionsClient[$i]->name;
            $answerNumb = $i + 1;
            $baseText .= "$answerNumb.$sportName \n";
        }

        $baseText .= "<b>3 вопрос:</b> Какие спортивные объекты должны быть на базе? \n";
        $baseText .= "Ответ: \n";
        for ($i = 0; $i < $selectedSportFacilitiesClient->count(); $i++) {
            $sportName = $selectedSportFacilitiesClient[$i]->name;
            $answerNumb = $i + 1;
            $baseText .= "$answerNumb.$sportName \n";
        }

        $baseText .= "<b>4 вопрос:</b> Требуются ли восстановительные и медицинские услуги? \n";
        $baseText .= "Ответ: \n";
        for ($i = 0; $i < $selectedMedicalsClient->count(); $i++) {
            $sportName = $selectedMedicalsClient[$i]->name;
            $answerNumb = $i + 1;
            $baseText .= "$answerNumb.$sportName \n";
        }

        $baseText .= "<b>5 вопрос:</b> Какой у вас бюджет на человека в сутки? \n";
        $baseText .= "Ответ: $basePriceSelectedText \n";

        $baseText .= "<b>6 вопрос:</b> Укажите желаемые даты проведения сборов \n";
        $baseText .= "Ответ: \n";
        $baseText .= "Дата начала: " . $baseDateStartFormatted . "\n";
        $baseText .= "Дата окончания: " . $baseDateEndFormatted . "\n";

        if($basePaymentMethod == "cashless"){
            $basePaymentMethod = "Безналичный расчёт";
        }
        else if($basePaymentMethod == "installments"){
            $basePaymentMethod = "Оплата частями";
        }
        else if($basePaymentMethod == "subsidies"){
            $basePaymentMethod = "Государственные субсидии (для спортивных школ)";
        }

        $baseText .= "<b>7 вопрос:</b> Какой способ оплаты предпочтителен? \n";
        $baseText .= "Ответ: $basePaymentMethod \n";

        $baseText .= "<b>8 вопрос:</b> Укажите предполагаемую продолжительность пребывания (в днях). \n";
        $baseText .= "Ответ: $lengthOfStay \n";

        $baseText .= "<b>9 вопрос:</b> Укажите количество участников и тренеров, которые планируют участие в сборах. \n";
        $baseText .= "Количество участников (спортсменов): " . $sportsmensCount . "\n";
        $baseText .= "Количество тренеров: " . $coachCount . "\n";






        // Замените <YOUR_BOT_TOKEN> на токен вашего бота Telegram
        $botToken = '7896217760:AAEONh8NVikRYXMADXyCdnCtEFngsyy1oFw';
    
        // Замените <YOUR_CHAT_ID> на ваш идентификатор чата с ботом
        $chatId = '-4532037484';
    
        // Создание текстового сообщения
        $text = "$baseText\n";
        // $text .= "Имя: " . $name . "\n";
        // $text .= "Телефон: " . $phone . "\n";
        // $text .= "Текст: " . $content . "\n";
        
    
        // Отправка сообщения в Telegram
        $telegramUrl = "https://api.telegram.org/bot" . $botToken . "/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ];
    
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($data),
            ],
        ];
    
        $context = stream_context_create($options);
        $result = file_get_contents($telegramUrl, false, $context);
    
        // Проверка результата отправки сообщения
        if ($result === false) {
            // Обработка ошибки
            echo "Ошибка отправки сообщения в Telegram.";
        } else {
            echo "Сообщение успешно отправлено в Telegram!";
        }
    //return redirect()->route('home');
}


}
