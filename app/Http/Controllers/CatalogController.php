<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Base;
use App\Models\Faq;
use App\Models\BaseImage;
use App\Models\SportsDisciplinesBase;
use App\Models\SportsDiscipline;
use App\Models\SportsFacility;
use App\Models\SportsFacilitiesBase;
use App\Models\Region;
use App\Models\MedicalSupport;
use App\Models\MedicalSupportsBase;

class CatalogController extends Controller
{
    public function BasesList(Request $request)
    {
        $mas = array();
		$mas[] = array('title' => 'Главная', 'link' => '/');
		$mas[] = array('title' => 'Каталог баз', 'link' => '/');

        $sportDisciplnes = SportsDiscipline::orderBy('name', 'asc')->get();
        $sportFacilities = SportsFacility::all();
        $regions = Region::all();
        $medicals = MedicalSupport::all();

        $query = Base::select('id', 'name', 'base_type', 'price', 'image_src', 'address');

        if(isset($request['sport-types'])){
            $basesIds = SportsDisciplinesBase::select('base_id')->whereIn('sports_discipline_id', $request['sport-types'])->groupBy('base_id')->get();
            $query->whereIn('id', $basesIds);
        }

        if(isset($request['sport-facilities'])){
            $basesIds = SportsFacilitiesBase::select('base_id')->whereIn('sports_facility_id', $request['sport-facilities'])->groupBy('base_id')->get();
            $query->whereIn('id', $basesIds);
        }

        if(isset($request['regions'])){
            $query->whereIn('region_id', $request['regions']);
        }

        if(isset($request['medicals'])){
            $basesIds = MedicalSupportsBase::select('base_id')->whereIn('medical_support_id', $request['medicals'])->groupBy('base_id')->get();
            $query->whereIn('id', $basesIds);
        }

        if(isset($request['price'])){
            if(in_array(3000, $request['price'])){
                $query->where('price', '<', 3000);
            }
            else if(in_array(6000, $request['price'])){
                $query->whereBetween('price', [3000, 6000]);
            }
            else if(in_array(6001, $request['price'])){
                $query->where('price', '>', 6000);
            }
        }

        if(isset($request['payments'])){
            $searchValues = $request['payments'];
            $query->when($searchValues, function ($query) use ($searchValues) {
                $query->where(function ($q) use ($searchValues) {
                    foreach ($searchValues as $value) {
                        $q->orWhereJsonContains('payment_options', $value); // Ищем каждое значение через OR
                    }
                });
            });
        }

        $bases = $query->paginate(12);


        return View('catalog', ['breads' => $mas, 'bases' => $bases, 'sportDisciplnes' => $sportDisciplnes, 'regions' => $regions, 'sportFacilities' => $sportFacilities, 'medicals' => $medicals]);
    }

    public function BaseElem($id)
    {
        $base = Base::with('region')->find($id);
        $baseImages = BaseImage::where('base_id', $id)->get();
        $includePriceArray = json_decode($base->include_price, true);
        $sportInfrastructArray = json_decode($base->sport_infrastruct, true);
        $amenitiesAndServices = json_decode($base->amenities_and_services, true);
        $sportDisciplnesBases = SportsDisciplinesBase::with('sportDiscipline')->where('base_id', $id)->get();

        $mas = array();
		$mas[] = array('title' => 'Главная', 'link' => '/');
		$mas[] = array('title' => 'Каталог баз', 'link' => route('bases'));
        $mas[] = array('title' => $base->name, 'link' => '/');

        return View('base', ['breads' => $mas, 'base' => $base, 
        'baseImages' => $baseImages,
        'includePriceArray' => $includePriceArray,
        'sportInfrastructArray' => $sportInfrastructArray,
        'amenitiesAndServices' => $amenitiesAndServices,
        'sportDisciplnesBases' => $sportDisciplnesBases,
        'faqs' => Faq::get()->sortBy('sort_order')]);
    }

    public function baseFilter(Request $request)
    {
        dd($request->input('sport-types'));
    }


}
