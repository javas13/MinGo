<?php

namespace App\Http\Controllers;

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
use App\Models\MedicalSupport;
use App\Models\MedicalSupportsBase;
use Illuminate\Support\Collection;

class TestController extends Controller
{
    public function GetAnswers(Request $request)
    {

        if($request->input('questionId') == 1){
            $sports = SportsDiscipline::orderBy('name', 'asc')->get();
            return response()->json([
                'html' => view('partials.kviz-answers', ['answers' => $sports, 'questionId' => 1])->render(),
                'success' => true
            ]);
        }
        else if($request->input('questionId') == 2){
            $regions = Region::all();
            return response()->json([
                'html' => view('partials.kviz-answers', ['answers' => $regions, 'questionId' => 2])->render(),
                'success' => true
            ]);
        }
        else if($request->input('questionId') == 3){
            $sportFacilities = SportsFacility::all();
            return response()->json([
                'html' => view('partials.kviz-answers', ['answers' => $sportFacilities, 'questionId' => 3])->render(),
                'success' => true
            ]);
        }
        else if($request->input('questionId') == 4){
            $mediacals = MedicalSupport::all();
            return response()->json([
                'html' => view('partials.kviz-answers', ['answers' => $mediacals, 'questionId' => 4])->render(),
                'success' => true
            ]);
        }
        else if($request->input('questionId') == 5){
            return response()->json([
                'html' => view('partials.kviz-answers', ['questionId' => 5])->render(),
                'success' => true
            ]);
        }
        else if($request->input('questionId') == 6){
            return response()->json([
                'html' => view('partials.kviz-answers', ['questionId' => 6])->render(),
                'success' => true
            ]);
        }
        else if($request->input('questionId') == 7){
            return response()->json([
                'html' => view('partials.kviz-answers', ['questionId' => 7])->render(),
                'success' => true
            ]);
        }
        else if($request->input('questionId') == 8){
            return response()->json([
                'html' => view('partials.kviz-answers', ['questionId' => 8])->render(),
                'success' => true
            ]);
        }
        else if($request->input('questionId') == 9){
            return response()->json([
                'html' => view('partials.kviz-answers', ['questionId' => 9])->render(),
                'success' => true
            ]);
        }
        else if($request->input('questionId') == 10){
            return response()->json([
                'html' => view('partials.kviz-answers', ['questionId' => 10])->render(),
                'success' => true
            ]);
        }
        else if($request->input('questionId') == 11){
            return response()->json([
                'html' => view('partials.kviz-answers', ['questionId' => 11])->render(),
                'success' => true
            ]);
        }
    }

    public function GetBases(Request $request)
    {
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
        }
        else if(in_array(6000, $selectedPrice)){
            $query->whereBetween('price', [3000, 6000]);
        }
        else if(in_array(6001, $selectedPrice)){
            $query->where('price', '>', 6000);
        }
        $query->when($selectedPaymentMethod, function ($query) use ($selectedPaymentMethod) {
            $query->where(function ($q) use ($selectedPaymentMethod) {
                foreach ($selectedPaymentMethod as $value) {
                    $q->orWhereJsonContains('payment_options', $value); // Ищем каждое значение через OR
                }
            });
        });


        $bases = $query->get()->toArray();
        if(count($bases) == 0){
            return response()->json(['basesCount' => 0]);
        }
        else{
            $basesIds = array_column($bases, 'id');
            return redirect()->route('pdf.generate', ['ids' => $basesIds]);
        }
        // dd($bases->count());
        // foreach($bases as $elem){
        //     dd($elem->name);
        // }
        // foreach($request->input('firstAnswer') as $elem){
        //     dd($elem['name']);
        // }
    }

    public function generatePdf(Request $request)
    {
        $bases = Base::whereIn('id', $request->input('ids'))->get();
        foreach($bases as $elem){
            $imagePathFromDB = $elem->image_src;

            // Убираем префикс "/storage/" из пути
            $relativePath = str_replace('/storage/', '', $imagePathFromDB);

            // Получаем абсолютный путь к файлу в публичном диске
            $absolutePath = Storage::disk('public')->path($relativePath);
            $elem->image_src = $absolutePath;
        }
        // Данные для передачи в шаблон
        $data = [
            'title' => 'Ваши базы',
            'content' => 'Это содержимое PDF-документа.',
            'bases' => $bases,
        ];

        // Генерация PDF из Blade-шаблона
        $pdf = Pdf::loadView('pdf.bases-pdf', $data);

        $pdf->save(storage_path('app/public/temp.pdf'));
        return response()->json(['url' => '/download-pdf', 'basesCount' => $bases->count()]);
    }

}
