<?php

namespace App\Http\Controllers;

use App\Models\OptionsGeneral;
use App\Models\Page;
use App\Models\Place;
use App\Models\PlaceImage;
use App\Models\Schedule;
use App\Models\News;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Banner;
use App\Models\Kitchen;
use App\Models\PlaceKitchen;
use App\Models\Staff;
use App\Models\NewsletterSubscription;
use App\Mail\MassMail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMassMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public  function login(Request $request){
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if(auth()->user()->is_admin !== 1){
                return redirect('admin');
            }
            else{
                $request->session()->regenerate();
                return redirect()->intended('admin/dashboard');
            }
        }
        else{
            return  back()->withErrors([
                'login' => 'Неверный логин или пароль',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function loginPage()
    {
        if(Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        else{
            return View('admin.login');
        }
    }

    public function dashboard(){
        return View('admin.dashboard');
    }

    public function imageLoad(Request $request){
        $folderName = $request->input('folderName');
        if($request->input('folderName') == 'bases'){
            $manager = new ImageManager(new Driver());
            $img = $manager->read($request->file('image')->getRealPath());
            $img->cover(600, 600);
            $watermarkPath = public_path('watermark.png');
            $img->place(
                $watermarkPath,
                'top-right', // Позиция
                10, // Отступ по X (справа)
                10  // Отступ по Y (снизу)
            );
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::random(20) . '_' . time() . '.' . $extension;
            $pathSave = $img->save(public_path('storage/bases/'.$filename));
            $path = 'bases/' .$filename;

        }
        else{
            $path = $request->file('image')->store('upload', 'public');
        }
        $full_path = '/storage/' . $path;

        return response()->json(['success' => true, 'data' => $full_path]);

    }

    public function imageLoadTmc(Request $request,){
        $imgPath = $request->file('file')->store('portfolio', 'public');

        $imgFullPath = '/storage/' . $imgPath;

        return response()->json(['location' => $imgFullPath]);

    }
    

    public function optionsGeneral(Request $request){
        return View('admin.general-options', ['data' => OptionsGeneral::all()]);
    }


    public function news(Request $request){
        return View('admin.news.news', ['data' => News::all()]);
    }

    public function newsAdd(Request $request){
        return View('admin.news.news-add');
    }

    public function newsAddStore(Request $request){
        $news = new News();
        $news->name = $request->input('name');
        $news->seo_name = $request->input('seoName');
        $news->seo_description = $request->input('seoDescript');
        $news->text = $request->input('content');
        $path = $request->file('image')->store('news', 'public');
        $news->image_src = '/storage/' . $path;

        if($request->input('issocial') == null){
            $news->is_social = 0;
        }
        else{
            $news->is_social = 1;
            if($request->input('isexternallink') == 0){
                $news->is_link_external = 0;
            }
            else{
                $news->is_link_external = 1;
            }
            $news->link = $request->input('link');
        }

        $news->save();

        return redirect()->route('admin.news');
    }

    public function newsUpdate($id){
        $news = new News;
        return View('admin.news.news-update', ['news' => $news->find($id)]);
    }

    public function newsletterSend(Request $request){
        // $emails = NewsletterSubscription::select('email')->get();
        // $content = $request->input('name');

        // SendMassMail::dispatch($emails, $content);
        // foreach($emails as $email){
        //     Mail::to($email)->send(new MassMail($content));
        // }
        return redirect()->route('admin.newsletter.subscribers.list');
    }

    public function newsUpdateStore($id, Request $request){
        $news = News::find($id);
        $news->name = $request->input('name');
        $news->seo_name = $request->input('seoName');
        $news->seo_description = $request->input('seoDescript');
        $news->text = $request->input('content');

        $news->image_src = $request->input('image_src');

        if($request->input('issocial') == null){
            $news->is_social = 0;
        }
        else{
            $news->is_social = 1;
            if($request->input('isexternallink') == 0){
                $news->is_link_external = 0;
            }
            else{
                $news->is_link_external = 1;
            }
            $news->link = $request->input('link');
        }

        $news->save();

        return redirect()->route('admin.news');
    }

    public function newsDelete(News $news){
        $news->delete();

        return redirect()->route('admin.news');
    }

    public function newsletterSubscriptionDelete(NewsletterSubscription $newsletterSubscription){
        $newsletterSubscription->delete();

        return redirect()->route('admin.newsletter.subscribers.list');
    }

    public function pageAddStore(Request $request){
        $page = new Page();
        $page->name = $request->input('name');
        $page->seo_name = $request->input('seoName');
        $page->seo_description = $request->input('seoDescript');
        $page->text = $request->input('content');

        $page->save();

        return redirect()->route('admin.pages');
    }

    public function pageUpdate($id){
        $page = new Page;
        return View('admin.pages.page-update', ['page' => $page->find($id)]);
    }

    public  function pageUpdateStore($id, Request $request){
        $page = Page::find($id);
        $page->name = $request->input('name');
        $page->seo_name = $request->input('seoName');
        $page->seo_description = $request->input('seoDescript');


        $page->text = $request->input('content');

        $page->save();

        return redirect()->route('admin.pages');
    }

    public function pageDelete(Page $page){
        $page->delete();

        return redirect()->route('admin.pages');
    }


    public function faqs(Request $request){
        return View('admin.faqs.faq-list', ['faqs' => Faq::all()]);
    }

    public function faqsAdd(Request $request){
        return View('admin.faqs.faq-add');
    }

    public function faqsAddStore(Request $request){
        $faq = new Faq();
        $faq->question_name = $request->input('question_name');
        $faq->answer_name = $request->input('answer_name');
        if($request->input('sortOrder') !== null){
            $faq->sort_order = $request->input('sortOrder');
        }

        $faq->save();

        return redirect()->route('admin.faqs');
    }

    public function faqsUpdate($id){
        $faq = new Faq;
        return View('admin.faqs.faq-update', ['faq' => $faq->find($id)]);
    }

    public function faqsUpdateStore($id, Request $request){
        $faq = Faq::find($id);
        $faq->question_name = $request->input('question_name');
        $faq->answer_name = $request->input('answer_name');
        if($request->input('sortOrder') !== null){
            $faq->sort_order = $request->input('sortOrder');
        }

        $faq->save();

        return redirect()->route('admin.faqs');
    }

    public function faqsDelete(Faq $faq){
        $faq->delete();

        return redirect()->route('admin.faqs');
    }


    public function banners(Request $request){
        return View('admin.banners.banner-list', ['banners' => Banner::all()]);
    }

    public function bannersAdd(Request $request){
        return View('admin.banners.banner-add');
    }

    public function bannersAddStore(Request $request){
        $banner = new Banner();
        $banner->name = $request->input('name');
        $banner->btn_name = $request->input('btn_name');
        $path = $request->file('image')->store('banners', 'public');
        $banner->image_src = '/storage/' . $path;

        if($request->input('sort_order') !== null){
            $banner->sort_order = $request->input('sort_order');
        }

        if($request->input('is_link_open') == null){
            $banner->is_link_open = 0;
        }
        else{
            $banner->is_link_open = 1;
            if($request->input('isexternallink') == 0){
                $banner->is_link_external = 0;
            }
            else{
                $banner->is_link_external = 1;
            }
            $banner->link = $request->input('link');
        }

        $banner->save();

        return redirect()->route('admin.banners');
    }

    public function bannersUpdate($id){
        $banner = new Banner();
        return View('admin.banners.banner-update', ['banner' => $banner->find($id)]);
    }

    public function bannersUpdateStore($id, Request $request){
        $banner = Banner::find($id);
        $banner->name = $request->input('name');
        $banner->btn_name = $request->input('btn_name');
        $banner->image_src = $request->input('image_src');

        if($request->input('sort_order') !== null){
            $banner->sort_order = $request->input('sort_order');
        }

        if($request->input('is_link_open') == null){
            $banner->is_link_open = 0;
        }
        else{
            $banner->is_link_open = 1;
            if($request->input('isexternallink') == 0){
                $banner->is_link_external = 0;
            }
            else{
                $banner->is_link_external = 1;
            }
            $banner->link = $request->input('link');
        }

        $banner->save();

        return redirect()->route('admin.banners');
    }


    public function bannersDelete(Banner $banner){
        $banner->delete();

        return redirect()->route('admin.banners');
    }


    public function staff(Request $request){
        return View('admin.staff.staff-list', ['staff' => Staff::all()]);
    }

    public function staffAdd(Request $request){
        return View('admin.staff.staff-add');
    }

    public function staffAddStore(Request $request){
        $staff = new Staff();
        $staff->name = $request->input('name');
        $staff->post = $request->input('post');
        $staff->quote = $request->input('quote');
        $path = $request->file('image')->store('staff', 'public');
        $staff->image_src = '/storage/' . $path;

        if($request->input('sortOrder') !== null){
            $staff->sort_order = $request->input('sort_order');
        }

        $staff->save();

        return redirect()->route('admin.staff');
    }

    public function staffUpdate($id){
        $staff = new Staff;
        return View('admin.staff.staff-update', ['staff' => $staff->find($id)]);
    }

    public function staffUpdateStore($id, Request $request){
        $staff = Staff::find($id);
        $staff->name = $request->input('name');
        $staff->post = $request->input('post');
        $staff->quote = $request->input('quote');
        $staff->image_src = $request->input('image_src');

        if($request->input('sortOrder') !== null){
            $staff->sort_order = $request->input('sort_order');
        }

        $staff->save();

        return redirect()->route('admin.staff');
    }

    public function staffDelete(Staff $staff){
        $staff->delete();

        return redirect()->route('admin.staff');
    }

    public function places(Request $request){
        return View('admin.places.places-list', ['places' => Place::paginate(20)]);
    }

    public function placesAdd(Request $request){
        $days = config('days');
        return View('admin.places.place-add', ['categories' => Category::All(), 'days' => $days, 'kitchens' => Kitchen::All()]);
    }

    public function placesAddStore(Request $request){
        
        if($request->input('is_schedule_active') == 1){
            $validated = $request->validate([
                'schedules' => 'required|array|size:7',
                'schedules.*.is_closed' => 'required|boolean',
                'schedules.*.day_name' => 'required',
                'name' => ['required', 'max:300'],
                'address' => ['required', 'max:300'],
                'description' => ['required'],
                'category_id' => ['required'],
                'mood' => 'nullable|array',
                'mood.*' => 'in:' . implode(',', array_keys(Place::MOOD_ANSWERS)),
                'company' => 'nullable|array',
                'company.*' => 'in:' . implode(',', array_keys(Place::COMPANY_ANSWERS)),
                'activity' => 'nullable|array',
                'activity.*' => 'in:' . implode(',', array_keys(Place::ACTIVITY_ANSWERS)),
                'budget' => 'nullable|array',
                'budget.*' => 'in:' . implode(',', array_keys(Place::BUDGET_ANSWERS)),
                'atmosphere' => 'nullable|array',
                'atmosphere.*' => 'in:' . implode(',', array_keys(Place::ATMOSPHERE_ANSWERS)),
                
                // Новые правила валидации
                'schedules.*.open_time' => [
                    'nullable',
                    'required_if:schedules.*.is_closed,0',
                    'date_format:H:i'
                ],
                'schedules.*.close_time' => [
                    'nullable',
                    'required_if:schedules.*.is_closed,0',
                    'date_format:H:i',
                    'after:schedules.*.open_time'
                ]
            ], [
                // Кастомные сообщения об ошибках
                'schedules.*.open_time.required_if' => 'Укажите время открытия для рабочего дня',
                'schedules.*.close_time.required_if' => 'Укажите время закрытия для рабочего дня',
                'schedules.*.close_time.after' => 'Время закрытия должно быть после времени открытия'
            ]);

        }
        else{
            $validated = $request->validate([
                'schedules' => 'required|array|size:7',
                'schedules.*.is_closed' => 'required|boolean',
                'schedules.*.day_name' => 'required',
                'name' => ['required', 'max:300'],
                'address' => ['required', 'max:300'],
                'description' => ['required'],
                'category_id' => ['required'],
                'mood' => 'nullable|array',
                'mood.*' => 'in:' . implode(',', array_keys(Place::MOOD_ANSWERS)),
                'company' => 'nullable|array',
                'company.*' => 'in:' . implode(',', array_keys(Place::COMPANY_ANSWERS)),
                'activity' => 'nullable|array',
                'activity.*' => 'in:' . implode(',', array_keys(Place::ACTIVITY_ANSWERS)),
                'budget' => 'nullable|array',
                'budget.*' => 'in:' . implode(',', array_keys(Place::BUDGET_ANSWERS)),
                'atmosphere' => 'nullable|array',
                'atmosphere.*' => 'in:' . implode(',', array_keys(Place::ATMOSPHERE_ANSWERS)),
                ]);
        }

        $place = new Place();
        $place->name = $request->input('name');
        $place->address = $request->input('address');
        $place->description = $request->input('description');
        $place->average_bill = $request->input('average_bill');
        $place->category_id = $request->input('category_id');
        $place->mood = $validated['mood'] ?? [];
        $place->company = $validated['company'] ?? [];
        $place->activity = $validated['activity'] ?? [];
        $place->budget = $validated['budget'] ?? [];
        $place->atmosphere = $validated['atmosphere'] ?? [];
        if($request->input('is_active') != null){
            $place->is_active = 1;
        }
        else{
            $place->is_active = 0;
        }

        if($request->input('is_schedule_active') != null){
            $place->is_schedule_active = 1;
        }
        else{
            $place->is_schedule_active = 0;
        }

        if($request->file('image') != null){
            $manager = new ImageManager(new Driver());
            $img = $manager->read($request->file('image')->getRealPath());
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::random(20) . '_' . time() . '.' . $extension;
            $path = $img->save(public_path('storage/places/original/'.$filename));
            $place->image_src = 'storage/places/thumbs/' .$filename;
            $img->cover(600, 600);
            $path = $img->save(public_path('storage/places/thumbs/'.$filename));
            $place->thumb_image_src = 'storage/places/thumbs/' .$filename;
        }

        $place->save();

        $this->processImages($request, $place);

        if($request->input('is_schedule_active') == 1){
            foreach ($validated['schedules'] as $data) {
                // Преобразуем русское название в английское
                $englishDay = strtolower(Schedule::russianToEnglishDays()[mb_strtolower($data['day_name'])] ?? null);
        
                // Проверка корректности преобразования
                if (!$englishDay) {
                    throw ValidationException::withMessages([
                        'schedules.*.day_name' => 'Некорректное название дня недели'
                    ]);
                }
        
                $place->schedules()->updateOrCreate(
                    ['day_of_week' => $englishDay],
                    [
                        'open_time' => $data['is_closed'] ? null : $data['open_time'],
                        'close_time' => $data['is_closed'] ? null : $data['close_time'],
                        'is_closed' => $data['is_closed'] ?? false
                    ]
                );
            }
        }

        

        $place->kitchens()->sync($request->kitchens ?? []);


        return redirect()->route('admin.places');
    }

    public function placesUpdate($id){
        
        $place = Place::find($id);
        $days = config('days');
        $placeKitchensArray = PlaceKitchen::where('place_id', $place->id)->get()->toArray();
        $selectedKitchens = array_column($placeKitchensArray, 'kitchen_id');
        return View('admin.places.place-update', ['place' => $place, 'categories' => Category::All(), 'days' => $days, 'kitchens' => Kitchen::All()->toArray(), 'selectedKitchens' => $selectedKitchens]);
    }

    public function placesUpdateStore($id, Request $request){
        if($request->input('is_schedule_active') == 1){
            $validated = $request->validate([
                'schedules' => 'required|array|size:7',
                'schedules.*.is_closed' => 'required|boolean',
                'schedules.*.day_name' => 'required',
                'name' => ['required', 'max:300'],
                'address' => ['required', 'max:300'],
                'description' => ['required'],
                'category_id' => ['required'],
                'mood' => 'nullable|array',
                'mood.*' => 'in:' . implode(',', array_keys(Place::MOOD_ANSWERS)),
                'company' => 'nullable|array',
                'company.*' => 'in:' . implode(',', array_keys(Place::COMPANY_ANSWERS)),
                'activity' => 'nullable|array',
                'activity.*' => 'in:' . implode(',', array_keys(Place::ACTIVITY_ANSWERS)),
                'budget' => 'nullable|array',
                'budget.*' => 'in:' . implode(',', array_keys(Place::BUDGET_ANSWERS)),
                'atmosphere' => 'nullable|array',
                'atmosphere.*' => 'in:' . implode(',', array_keys(Place::ATMOSPHERE_ANSWERS)),
                
                // Новые правила валидации
                'schedules.*.open_time' => [
                    'nullable',
                    'required_if:schedules.*.is_closed,0',
                    'date_format:H:i'
                ],
                'schedules.*.close_time' => [
                    'nullable',
                    'required_if:schedules.*.is_closed,0',
                    'date_format:H:i',
                    'after:schedules.*.open_time'
                ]
            ], [
                // Кастомные сообщения об ошибках
                'schedules.*.open_time.required_if' => 'Укажите время открытия для рабочего дня',
                'schedules.*.close_time.required_if' => 'Укажите время закрытия для рабочего дня',
                'schedules.*.close_time.after' => 'Время закрытия должно быть после времени открытия'
            ]);

        }
        else{
            $validated = $request->validate([
                'schedules' => 'required|array|size:7',
                'schedules.*.is_closed' => 'required|boolean',
                'schedules.*.day_name' => 'required',
                'name' => ['required', 'max:300'],
                'address' => ['required', 'max:300'],
                'description' => ['required'],
                'category_id' => ['required'],
                'mood' => 'nullable|array',
                'mood.*' => 'in:' . implode(',', array_keys(Place::MOOD_ANSWERS)),
                'company' => 'nullable|array',
                'company.*' => 'in:' . implode(',', array_keys(Place::COMPANY_ANSWERS)),
                'activity' => 'nullable|array',
                'activity.*' => 'in:' . implode(',', array_keys(Place::ACTIVITY_ANSWERS)),
                'budget' => 'nullable|array',
                'budget.*' => 'in:' . implode(',', array_keys(Place::BUDGET_ANSWERS)),
                'atmosphere' => 'nullable|array',
                'atmosphere.*' => 'in:' . implode(',', array_keys(Place::ATMOSPHERE_ANSWERS)),
                ]);
        }

        $place = Place::find($id);
        $place->name = $request->input('name');
        $place->address = $request->input('address');
        $place->average_bill = $request->input('average_bill');
        $place->description = $request->input('description');
        $place->category_id = $request->input('category_id');
        $place->mood = $validated['mood'] ?? [];
        $place->company = $validated['company'] ?? [];
        $place->activity = $validated['activity'] ?? [];
        $place->budget = $validated['budget'] ?? [];
        $place->atmosphere = $validated['atmosphere'] ?? [];
        $place->kitchens()->sync($request->kitchens ?? []);
        if($request->input('is_active') != null){
            $place->is_active = 1;
        }
        else{
            $place->is_active = 0;
        }

        if($request->input('is_schedule_active') != null){
            $place->is_schedule_active = 1;
        }
        else{
            $place->is_schedule_active = 0;
        }

        if($request->file('image') != null){
            $manager = new ImageManager(new Driver());
            $img = $manager->read($request->file('image')->getRealPath());
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::random(20) . '_' . time() . '.' . $extension;
            $path = $img->save(public_path('storage/places/original/'.$filename));
            $place->image_src = 'storage/places/thumbs/' .$filename;
            $img->cover(600, 600);
            $path = $img->save(public_path('storage/places/thumbs/'.$filename));
            $place->thumb_image_src = 'storage/places/thumbs/' .$filename;
        }

        $place->save();


        $this->processImages($request, $place);

        if($request->input('is_schedule_active') == 1){
            foreach ($validated['schedules'] as $data) {
                // Преобразуем русское название в английское
                $englishDay = strtolower(Schedule::russianToEnglishDays()[mb_strtolower($data['day_name'])] ?? null);
        
                // Проверка корректности преобразования
                if (!$englishDay) {
                    throw ValidationException::withMessages([
                        'schedules.*.day_name' => 'Некорректное название дня недели'
                    ]);
                }
        
                $place->schedules()->updateOrCreate(
                    ['day_of_week' => $englishDay],
                    [
                        'open_time' => $data['is_closed'] ? null : $data['open_time'],
                        'close_time' => $data['is_closed'] ? null : $data['close_time'],
                        'is_closed' => $data['is_closed'] ?? false
                    ]
                );
            }
        }

        return redirect()->route('admin.places');
    }

    public function placesDelete(Place $place){
        $place->delete();

        return redirect()->route('admin.places');
    }

    public function placesReplicateStore(Place $place){
        $placeCopy = new Place();
        $placeCopy = $place->replicate();
        $placeCopy->name = 'Копия ' . $place->name;
        $placeCopy->save();

        foreach(Schedule::where('place_id', $place->id) as $elem){
            $schedule = new Schedule();
            $schedule->place_id = $placeCopy->id;
            $schedule->day_of_week = $elem->day_of_week;
            $schedule->open_time = $elem->open_time;
            $schedule->close_time = $elem->close_time;
            $schedule->is_closed = $elem->is_closed;
            $schedule->save();
        }

        foreach(PlaceKitchen::where('place_id', $place->id) as $elem){
            $placeKitchen = new PlaceKitchen();
            $placeKitchen->place_id = $placeCopy->id;
            $placeKitchen->kitchen_id = $elem->kitchen_id;
            $placeKitchen->save();
        }

        foreach(PlaceImage::where('place_id', $place->id) as $elem){
            $placeImage = new PlaceImage();
            $placeImage->place_id = $placeCopy->id;
            $placeImage->image_src = $elem->image_src;
            $placeImage->thumb_image_src = $elem->thumb_image_src;
            $placeImage->sort_order = $elem->sort_order;
            $placeImage->save();
        }

        return redirect()->route('admin.places');
    }


    private function processImages(Request $request, Place $place)
    {
        // Удаление помеченных изображений
        $existingImages = $request->input('images', []);
        $place->images()->whereNotIn('id', $existingImages)->delete();

        // Обновление порядка существующих изображений
        foreach ($existingImages as $order => $imageId) {
            if ($imageId) {
                PlaceImage::where('id', $imageId)->update(['sort_order' => $order]);
            }
        }

        // Добавление новых изображений
        if ($request->hasFile('uploaded_images')) {
            foreach ($request->file('uploaded_images') as $order => $file) {

                $manager = new ImageManager(new Driver());
                $img = $manager->read($file->getRealPath());
                $extension = $file->getClientOriginalExtension();
                $filename = Str::random(20) . '_' . time() . '.' . $extension;
                $path = $img->save(public_path('storage/places/original/'.$filename));
                $placeImg = new PlaceImage();
                $placeImg->place_id = $place->id;
                $placeImg->image_src = 'storage/places/original/' .$filename;
                $img->cover(600, 600);
                $path = $img->save(public_path('storage/places/thumbs/'.$filename));
                $placeImg->thumb_image_src = 'storage/places/thumbs/' .$filename;
                $placeImg->sort_order = count($existingImages) + $order;
                $placeImg->save();

                // $path = $file->store('places', 'public');
                // $place->images()->create([
                //     'image_path' => $path,
                //     'order' => count($existingImages) + $order
                // ]);
            }
        }
    }

    public function categoryAddStore(Request $request){
        $category = new Category;
        $category->name = $request->input('name');
        if($request->input('sortOrder') != null){
            $category->sort_order = $request->input('sortOrder');
        }
        $category->save();
        return redirect()->route('admin.category.list');
    }

    public function categoryDeleteStore(Category $Category){
        $Category->delete();

        return redirect()->route('admin.category.list');
    }

    public function categoryUpdate($id){
        $category = new Category;
        return View('admin.category.category-update', ['category' => $category->find($id)]);
    }

    public function categoryUpdateStore($id, Request $request){
        $category = Category::find($id);
        $category->name = $request->input('name');
        if($request->input('sortOrder') != null){
            $category->sort_order = $request->input('sortOrder');
        }
        $category->save();
        return redirect()->route('admin.category.list');
    }


    public function kitchensAddStore(Request $request){
        $kitchen = new Kitchen;
        $kitchen->name = $request->input('name');
        $kitchen->save();
        return redirect()->route('admin.kitchens.list');
    }

    public function kitchensDeleteStore(Kitchen $Kitchen){
        $Kitchen->delete();

        return redirect()->route('admin.kitchens.list');
    }

    public function kitchensUpdate($id){
        $kitchen = new Kitchen;
        return View('admin.kitchens.kitchens-update', ['kitchen' => $kitchen->find($id)]);
    }

    public function kitchensUpdateStore($id, Request $request){
        $kitchen = Kitchen::find($id);
        $kitchen->name = $request->input('name');
        $kitchen->save();
        return redirect()->route('admin.kitchens.list');
    }


}
