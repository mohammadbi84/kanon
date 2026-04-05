<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\PannelController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/sms', [\App\Http\Controllers\AuthController::class, 'sms'])->name('sms');
Route::get('/resend-code/{user}', [\App\Http\Controllers\AuthController::class, 'resendCode'])->name('resend.code');

Route::get('/states/{cityId}', [SiteController::class, 'states']);




// site pages
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/school', [SiteController::class, 'school'])->name('school');
Route::get('/maps', [SiteController::class, 'map'])->name('map');
Route::prefix('/job-opportunity')->group(function () {
    // Route::get('/', [JobOpportunityController::class, 'categories'])->name('job-opportunity.categories');
    // Route::get('/jobs', [JobOpportunityController::class, 'index'])->name('job-opportunity.index');
});





Route::get('/register', [\App\Http\Controllers\SiteController::class, 'register']);
// Route::post('/register', [\App\Http\Controllers\SchoolController::class, 'addPost']);
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/register2', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/register2', [\App\Http\Controllers\AuthController::class, 'register_post'])->name('register_post');
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/signIn', [\App\Http\Controllers\AuthController::class, 'signIn'])->name('signIn');
Route::post('/check_password', [\App\Http\Controllers\AuthController::class, 'check_password'])->name('check_password');
Route::post('/check_organ_id', [\App\Http\Controllers\AuthController::class, 'check_organ_id'])->name('check_organ_id');
Route::post('/one_time_password', [\App\Http\Controllers\AuthController::class, 'one_time_password'])->name('one_time_password');
Route::get('/status', [\App\Http\Controllers\AuthController::class, 'status'])->name('register.status');
Route::get('/loginCode', [\App\Http\Controllers\AuthController::class, 'loginCode'])->name('loginCode');
Route::post('/verifyCode', [\App\Http\Controllers\AuthController::class, 'verifyCode'])->name('verifyCode');
Route::get('/forgot_password', [\App\Http\Controllers\AuthController::class, 'forgot_password'])->name('forgot_password');
Route::post('/forgot_password', [\App\Http\Controllers\AuthController::class, 'forgot_password_post'])->name('forgot_password.store');
Route::post('/forgot_password_code_check', [\App\Http\Controllers\AuthController::class, 'forgot_password_code_check'])->name('forgot_password.code_check');

Route::post('/loginCode', [\App\Http\Controllers\AuthController::class, 'loginCode_post'])->name('loginCode_post');
Route::get('/code/{id}', [\App\Http\Controllers\AuthController::class, 'code'])->name('code');
Route::post('/code_check', [\App\Http\Controllers\AuthController::class, 'code_check'])->name('code_check');
Route::post('/set_password', [\App\Http\Controllers\AuthController::class, 'set_password'])->name('set_password');
Route::get('/schools', [\App\Http\Controllers\SiteController::class, 'schools']);
Route::get('/school/{id}', [\App\Http\Controllers\SiteController::class, 'show'])->name('school.show');

Route::get('/news', [\App\Http\Controllers\SiteController::class, 'news'])->name('news');
Route::get('/new/{id}', [\App\Http\Controllers\SiteController::class, 'new'])->name('new');
Route::get('/courses', [\App\Http\Controllers\SiteController::class, 'courses']);
Route::get('/course/{id}', [\App\Http\Controllers\SiteController::class, 'course'])->name('course');


Route::prefix('/dashboard')->group(function () {
    // Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'loginPost']);
});

Route::prefix('/panel')->middleware('auth')->group(function () {
    Route::get('/', [PannelController::class, 'index'])->name('panel');
    Route::get('/personal_page', [PannelController::class, 'personal_page'])->name('personal_page');
});

Route::post('/buying', [Controller::class, 'buying'])->name('buying');
Route::get('/callback', [Controller::class, 'callback'])->name('payment.callback');
// captcha
Route::get('/refresh-captcha', function () {
    return captcha_img('my_custom');
});
