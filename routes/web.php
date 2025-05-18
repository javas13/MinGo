<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Banner;
use App\Models\News;
use App\Models\NewsletterSubscription;
use App\Models\Faq;
use App\Models\City;
use App\Models\District;
use App\Models\Kitchen;
use App\Models\Place;
use App\Models\Staff;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KvizController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Route::get('news', [NewsController::class, 'NewsList'])->name('news');

// Route::get('news/{id}', [NewsController::class, 'NewsElem'])->name('news.elem');



// Route::get('about', function () {
//     $mas = array();
// 	$mas[] = array('title' => 'Главная', 'link' => '/');
// 	$mas[] = array('title' => 'О нас', 'link' => '/');

//     return view('about', ['breads' => $mas, 'faqs' => Faq::get()->sortBy('sort_order'), 'staff' => Staff::get()->sortBy('sort_order')]);
// })->name('about');

Route::post('kviz-search', [KvizController::class, 'search'])->name('kviz.search');

Route::get('kviz-results', [KvizController::class, 'kvizResults'])->name('kviz.results');

Route::get('contacts', function () {
    $mas = array();
	$mas[] = array('title' => 'Главная', 'link' => '/');
	$mas[] = array('title' => 'Контакты', 'link' => '/');

    return view('contacts', ['breads' => $mas]);
})->name('contacts');

Route::get('/kviz-results/{key}', function ($key) {
    $mas = array();
	$mas[] = array('title' => 'Главная', 'link' => '/');
	$mas[] = array('title' => 'Результаты квиза', 'link' => '/');

    $cacheKey = 'filtered_places_' . $key;
    
    if (!Cache::has($cacheKey)) {
        $error = 'Данная ссылка устарела( Пройдите квиз заново для получения результатов';
        return View('kviz.results', ['error' => $error]);
    }
    
    $placesIds = Cache::get($cacheKey);

    $places = Place::whereIn('id', $placesIds)->paginate(24);

    return View('kviz.results', ['places' => $places, 'breads' => $mas]);  
})->name('temporary.results');

Route::get('/places/{slug}', [PlaceController::class, 'placePage'])->name('places.elem');

Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');

Route::post('newsletterSubscription', [NewsController::class, 'subscribeToTheNewsletter'])->name('subscribe.newsletter');

Route::post('sendFeedbackTelegram', [FeedbackController::class, 'sendToTelegram'])->name('send.feedback.telegram');

Route::post('sendFeedbackTelegramBase', [FeedbackController::class, 'sendToTelegramBase'])->name('send.feedback.telegram.base');

Route::post('/places/{place}/favorite/toggle', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
Route::get('/places/{place}/favorite/check', [FavoriteController::class, 'check']);


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'loginPage'])->name('admin.login.page');

    Route::post('/', [AdminController::class, 'login'])->name('admin.login');

    Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');

    Route::get('options-general', [AdminController::class, 'optionsGeneral'])->name('admin.options.general')->middleware('admin');

    Route::post('image-load', [AdminController::class, 'imageLoad'])->name('admin.image.load')->middleware('admin');

    Route::post('upload-image-tmc', [AdminController::class, 'imageLoadTmc'])->name('admin.image.load.tmc')->middleware('admin');

    Route::get('news', [AdminController::class, 'news'])->name('admin.news')->middleware('admin');

    Route::get('news/add', [AdminController::class, 'newsAdd'])->name('admin.news.add')->middleware('admin');

    Route::post('news/add', [AdminController::class, 'newsAddStore'])->name('admin.news.add.store')->middleware('admin');

    Route::delete('news/{news}/delete', [AdminController::class, 'newsDelete'])->name('admin.news.delete')->middleware('admin');

    Route::get('news/{id}/update', [AdminController::class, 'newsUpdate'])->name('admin.news.update')->middleware('admin');

    Route::post('news/{id}/update', [AdminController::class, 'newsUpdateStore'])->name('admin.news.update.store')->middleware('admin');

    Route::get('faqs', [AdminController::class, 'faqs'])->name('admin.faqs')->middleware('admin');

    Route::get('faqs/add', [AdminController::class, 'faqsAdd'])->name('admin.faqs.add')->middleware('admin');

    Route::post('faqs/add', [AdminController::class, 'faqsAddStore'])->name('admin.faqs.add.store')->middleware('admin');

    Route::delete('faqs/{faq}/delete', [AdminController::class, 'faqsDelete'])->name('admin.faqs.delete')->middleware('admin');

    Route::get('faqs/{id}/update', [AdminController::class, 'faqsUpdate'])->name('admin.faqs.update')->middleware('admin');

    Route::post('faqs/{id}/update', [AdminController::class, 'faqsUpdateStore'])->name('admin.faqs.update.store')->middleware('admin');

    Route::get('banners', [AdminController::class, 'banners'])->name('admin.banners')->middleware('admin');

    Route::get('banners/add', [AdminController::class, 'bannersAdd'])->name('admin.banners.add')->middleware('admin');

    Route::post('banners/add', [AdminController::class, 'bannersAddStore'])->name('admin.banners.add.store')->middleware('admin');

    Route::delete('banners/{banner}/delete', [AdminController::class, 'bannersDelete'])->name('admin.banners.delete')->middleware('admin');

    Route::get('banners/{id}/update', [AdminController::class, 'bannersUpdate'])->name('admin.banners.update')->middleware('admin');

    Route::post('banners/{id}/update', [AdminController::class, 'bannersUpdateStore'])->name('admin.banners.update.store')->middleware('admin');

    Route::get('newsletter-add', function (){
        return view('admin.newsletter.newsletter-add');
    })->name('admin.newsletter.add')->middleware('admin');

    Route::get('newsletter-subscribers-list', function (){
        return view('admin.newsletter.newsletter-subscribers-list', ['subscribers' => NewsletterSubscription::all()]);
    })->name('admin.newsletter.subscribers.list')->middleware('admin');

    Route::delete('newsletter-subscribers/{newsletterSubscription}/delete', [AdminController::class, 'newsletterSubscriptionDelete'])->name('admin.newsletter.subscription.delete')->middleware('admin');

    Route::post('newsletter-send', [AdminController::class, 'newsletterSend'])->name('admin.newsletter.send')->middleware('admin');

    Route::get('places', [AdminController::class, 'places'])->name('admin.places')->middleware('admin');

    Route::get('places/add', [AdminController::class, 'placesAdd'])->name('admin.places.add')->middleware('admin');

    Route::post('places/add', [AdminController::class, 'placesAddStore'])->name('admin.places.add.store')->middleware('admin');

    Route::delete('places/{place}/delete', [AdminController::class, 'placesDelete'])->name('admin.places.delete')->middleware('admin');

    Route::get('places/{id}/update', [AdminController::class, 'placesUpdate'])->name('admin.places.update')->middleware('admin');

    Route::post('places/{id}/update', [AdminController::class, 'placesUpdateStore'])->name('admin.places.update.store')->middleware('admin');

    Route::post('places/{place}/replicate', [AdminController::class, 'placesReplicateStore'])->name('admin.places.replicate.store')->middleware('admin');

    Route::get('categories', function () {
        return view('admin.category.category-list', ['data' => Category::all()]);
    })->name('admin.category.list')->middleware('admin');

    Route::get('category/add', function () {
        return view('admin.category.category-add');
    })->name('admin.category.add')->middleware('admin');

    Route::post('category/add', [AdminController::class, 'categoryAddStore'])->name('admin.category.add.store')->middleware('admin');

    Route::get('category/{id}/update', [AdminController::class, 'categoryUpdate'])->name('admin.category.update')->middleware('admin');

    Route::post('category/{id}/update', [AdminController::class, 'categoryUpdateStore'])->name('admin.category.update.store')->middleware('admin');

    Route::delete('category/{Category}/delete', [AdminController::class, 'categoryDeleteStore'])->name('admin.category.delete.store')->middleware('admin');


    Route::get('kitchens', function () {
        return view('admin.kitchens.kitchens-list', ['data' => Kitchen::all()]);
    })->name('admin.kitchens.list')->middleware('admin');

    Route::get('kitchens/add', function () {
        return view('admin.kitchens.kitchens-add');
    })->name('admin.kitchens.add')->middleware('admin');

    Route::post('kitchens/add', [AdminController::class, 'kitchensAddStore'])->name('admin.kitchens.add.store')->middleware('admin');

    Route::get('kitchens/{id}/update', [AdminController::class, 'kitchensUpdate'])->name('admin.kitchens.update')->middleware('admin');

    Route::post('kitchens/{id}/update', [AdminController::class, 'kitchensUpdateStore'])->name('admin.kitchens.update.store')->middleware('admin');

    Route::delete('kitchens/{Kitchen}/delete', [AdminController::class, 'kitchensDeleteStore'])->name('admin.kitchens.delete.store')->middleware('admin');




    Route::get('staff', [AdminController::class, 'staff'])->name('admin.staff')->middleware('admin');

    Route::get('staff/add', [AdminController::class, 'staffAdd'])->name('admin.staff.add')->middleware('admin');

    Route::post('staff/add', [AdminController::class, 'staffAddStore'])->name('admin.staff.add.store')->middleware('admin');

    Route::delete('staff/{staff}/delete', [AdminController::class, 'staffDelete'])->name('admin.staff.delete')->middleware('admin');

    Route::get('staff/{id}/update', [AdminController::class, 'staffUpdate'])->name('admin.staff.update')->middleware('admin');

    Route::post('staff/{id}/update', [AdminController::class, 'staffUpdateStore'])->name('admin.staff.update.store')->middleware('admin');

    Route::get('cities', function (){
        return view('admin.cities.city-list', ['cities' => City::all()]);
    })->name('admin.cities')->middleware('admin');

    Route::get('cities/add', function (){
        return view('admin.cities.city-add', ['cities' => City::all()]);
    })->name('admin.cities.add')->middleware('admin');

    Route::post('cities/add', [AdminController::class, 'cityAddStore'])->name('admin.cities.add.store')->middleware('admin');

    Route::get('cities/{id}/update', [AdminController::class, 'cityUpdate'])->name('admin.cities.update')->middleware('admin');

    Route::post('cities/{id}/update', [AdminController::class, 'cityUpdateStore'])->name('admin.cities.update.store')->middleware('admin');

    Route::delete('cities/{city}/delete', [AdminController::class, 'cityDelete'])->name('admin.cities.delete')->middleware('admin');

    Route::get('districts', function (){
        return view('admin.districts.districts-list', ['districts' => District::all()]);
    })->name('admin.districts')->middleware('admin');

    Route::get('districts/add', function (){
        return view('admin.districts.districts-add', ['cities' => City::all()]);
    })->name('admin.districts.add')->middleware('admin');

    Route::post('districts/add', [AdminController::class, 'districtsAddStore'])->name('admin.districts.add.store')->middleware('admin');

    Route::get('districts/{id}/update', [AdminController::class, 'districtsUpdate'])->name('admin.districts.update')->middleware('admin');

    Route::post('districts/{id}/update', [AdminController::class, 'districtsUpdateStore'])->name('admin.districts.update.store')->middleware('admin');

    Route::delete('districts/{district}/delete', [AdminController::class, 'districtsDelete'])->name('admin.districts.delete')->middleware('admin');

    Route::get('/districts/city/{city}', [AdminController::class, 'byCity'])->name('districts.by-city')->middleware('admin');

});

Route::middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'create'])->name('register');
    Route::post('register', [UserController::class, 'store'])->name('user.store');

    Route::get('login', [UserController::class, 'login'])->name('login');
    Route::post('login', [UserController::class, 'loginAuth'])->name('login.auth');

    Route::get('forgot-password', function (){
        return view('user.forgot-password');
    })->name('password.request');

    Route::post('forgot-password', [UserController::class, 'forgotPasswordStore'])->name('password.email')->middleware('throttle:8,1');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('user.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', [UserController::class, 'resetPasswordUpdate'])->name('password.update');
});

Route::middleware('auth', 'verified')->group(function (){

    Route::get('profile/settings', [ProfileController::class, 'index'])->name('profile');

});


Route::middleware('auth')->group(function (){

    Route::get('verify-email', function () {
        $userId = Auth::id();
        $cacheKey = "user_cooldown_{$userId}";
        if (Cache::has($cacheKey)) {
            $remaining = Cache::get($cacheKey) - time();
            return view('user.verify-email', ['remaining' => $remaining]);
        }
        else{
            return view('user.verify-email');
        }
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('profile');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        $userId = Auth::id();
        $cacheKey = "user_cooldown_{$userId}";
        Cache::put($cacheKey, time() + 60, 60);
        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:3,1')->name('verification.send');

    Route::get('logout', [UserController::class, 'logout'])->name('logout');

});




