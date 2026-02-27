<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BookmarkController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ClusterController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\JobtypeController;
use App\Http\Controllers\Admin\KardaneshController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\PositionPriceController;
use App\Http\Controllers\Admin\ProfessionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TuitionController;
use App\Http\Controllers\Admin\TuitionProfessionController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\JobOpportunityController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PannelController;
use App\Http\Controllers\RegisterAlertController;
use App\Http\Controllers\RegisterMessageController;
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
Route::get('/', [SiteController::class, 'index'])->middleware('senddata')->name('home');
Route::get('/school', [SiteController::class, 'school'])->name('school');
Route::get('/maps', [SiteController::class, 'map'])->name('map');
Route::prefix('/job-opportunity')->group(function () {
    // Route::get('/', [JobOpportunityController::class, 'categories'])->name('job-opportunity.categories');
    // Route::get('/jobs', [JobOpportunityController::class, 'index'])->name('job-opportunity.index');
});



// admin pages
Route::prefix('/admin2')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');


    // Positions ==============================================================================================================
    Route::prefix('/positions')->group(function () {
        Route::get('/', [PositionController::class, 'index'])->name('positions.index');
        Route::post('/bulk-toggle', [PositionController::class, 'bulkToggle'])->name('positions.bulkToggle');
        Route::get('/{position}/edit', [PositionController::class, 'edit'])->name('positions.edit');
        Route::put('/{position}', [PositionController::class, 'update'])->name('positions.update');
        Route::patch('/{position}/toggle', [PositionController::class, 'toggle'])->name('positions.toggle');
        // Pricing Rules
        Route::get('/{position}/pricing', [PositionPriceController::class, 'index'])->name('pricing.index');
        Route::post('/{position}/pricing', [PositionPriceController::class, 'store'])->name('pricing.store');
        Route::put('/pricing/{positionPrice}', [PositionPriceController::class, 'update'])->name('pricing.update');
        Route::delete('/pricing/{positionPrice}', [PositionPriceController::class, 'destroy'])->name('pricing.destroy');
    });
















    // ================== jobtypes ==================
    Route::prefix('/jobtype')->group(function () {
        Route::get('/', [JobtypeController::class, 'index'])->name('jobtype.index');
        Route::post('/store', [JobtypeController::class, 'store'])->name('jobtype.store');
        Route::delete('/delete/{id}', [JobtypeController::class, 'delete'])->name('jobtype.delete');
        Route::post('/bulk-delete', [JobTypeController::class, 'bulkDelete'])->name('jobtype.bulkDelete');
        Route::get('/{id}', [JobtypeController::class, 'edit'])->name('jobtype.edit');
        Route::post('/{id}', [JobtypeController::class, 'update'])->name('jobtype.update');
    });

    // ================== kardanesh ==================
    Route::prefix('/kardanesh')->group(function () {
        Route::get('/', [KardaneshController::class, 'index'])->name('kardanesh.index');
        Route::post('/store', [KardaneshController::class, 'store'])->name('kardanesh.store');
        Route::delete('/delete/{id}', [KardaneshController::class, 'delete'])->name('kardanesh.delete');
        Route::post('/bulk-delete', [KardaneshController::class, 'bulkDelete'])->name('kardanesh.bulkDelete');
        Route::get('/{id}', [KardaneshController::class, 'edit'])->name('kardanesh.edit');
        Route::post('/{id}', [KardaneshController::class, 'update'])->name('kardanesh.update');
    });

    // ================== Tuitions ==================
    Route::prefix('/tuitions')->name('tuitions.')->group(function () {
        Route::get('/', [TuitionController::class, 'index'])->name('index');
        Route::post('/store', [TuitionController::class, 'store'])->name('store');
        Route::get('/{tuition}/edit', [TuitionController::class, 'edit'])->name('edit');
        Route::put('/{tuition}', [TuitionController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [TuitionController::class, 'delete'])->name('delete');
        Route::post('/bulk-delete', [TuitionController::class, 'bulkDelete'])->name('bulkDelete');
        // professions
        Route::get('{tuition}/professions', [TuitionProfessionController::class, 'index'])->name('professions.index');
        Route::post('{tuition}/professions/update', [TuitionProfessionController::class, 'update'])->name('professions.update');
    });

    // ================== Categories ==================
    Route::prefix('/categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::post('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulkDelete');
        Route::get('/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('/{id}', [CategoryController::class, 'update'])->name('categories.update');
    });

    // ================== Clusters ==================
    Route::prefix('/clusters')->group(function () {
        Route::get('/', [ClusterController::class, 'index'])->name('clusters.index');
        Route::post('/store', [ClusterController::class, 'store'])->name('clusters.store');
        Route::delete('/delete/{id}', [ClusterController::class, 'delete'])->name('clusters.delete');
        Route::post('/bulk-delete', [ClusterController::class, 'bulkDelete'])->name('clusters.bulkDelete');
        Route::get('/{id}', [ClusterController::class, 'edit'])->name('clusters.edit');
        Route::post('/{id}', [ClusterController::class, 'update'])->name('clusters.update');
    });

    // ================== Fields ====================
    Route::prefix('/fields')->group(function () {
        Route::get('/', [FieldController::class, 'index'])->name('fields.index');
        Route::post('/store', [FieldController::class, 'store'])->name('fields.store');
        Route::delete('/delete/{id}', [FieldController::class, 'delete'])->name('fields.delete');
        Route::post('/bulk-delete', [FieldController::class, 'bulkDelete'])->name('fields.bulkDelete');
        Route::get('/{id}', [FieldController::class, 'edit'])->name('fields.edit');
        Route::post('/{id}', [FieldController::class, 'update'])->name('fields.update');
    });

    // ================== Professions ==================
    Route::prefix('/professions')->group(function () {
        Route::get('/', [ProfessionController::class, 'index'])->name('professions.index');
        Route::post('/store', [ProfessionController::class, 'store'])->name('professions.store');
        Route::delete('/delete/{id}', [ProfessionController::class, 'delete'])->name('professions.delete');
        Route::post('/bulk-delete', [ProfessionController::class, 'bulkDelete'])->name('professions.bulkDelete');
        Route::get('/{id}', [ProfessionController::class, 'edit'])->name('professions.edit');
        Route::put('/{id}', [ProfessionController::class, 'update'])->name('professions.update');
    });

    Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
    // ================== Popups =====================
    Route::resource('popups', PopupController::class)->except('show', 'create', 'edit', 'update');
    Route::prefix('popups')->name('popups.')->group(function () {
        Route::get('/{id}', [PopupController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PopupController::class, 'update'])->name('update');
        Route::post('/bulk-delete', [PopupController::class, 'bulkDelete'])->name('bulkDelete');
        // images
        Route::get('/showImages/{id}', [PopupController::class, 'showImages'])->name('showImages');
        Route::post('/upload/{id}', [PopupController::class, 'uploadImage'])->name('upload');
        Route::post('/status/{id}', [PopupController::class, 'toggleImageStatus'])->name('status');
        Route::delete('/image/{id}', [PopupController::class, 'deleteImage'])->name('image.delete');
    });
    // ================== Articles ==================
    Route::prefix('/articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
        Route::post('/store', [ArticleController::class, 'store'])->name('articles.store');
        Route::delete('/delete/{id}', [ArticleController::class, 'delete'])->name('articles.delete');
        Route::post('/bulk-delete', [ArticleController::class, 'bulkDelete'])->name('articles.bulkDelete');
        Route::get('/{id}', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::post('/{id}', [ArticleController::class, 'update'])->name('articles.update');
    });
    // ================== Bookmark ==================
    Route::prefix('/bookmark')->group(function () {
        Route::get('/', [BookmarkController::class, 'index'])->name('bookmark.index');
        Route::post('/store', [BookmarkController::class, 'store'])->name('bookmark.store');
        Route::delete('/delete/{id}', [BookmarkController::class, 'delete'])->name('bookmark.delete');
        Route::post('/bulk-delete', [BookmarkController::class, 'bulkDelete'])->name('bookmark.bulkDelete');
        Route::get('/{id}', [BookmarkController::class, 'edit'])->name('bookmark.edit');
        Route::put('/{id}', [BookmarkController::class, 'update'])->name('bookmark.update');
    });

    // ================== Slider ==================
    Route::prefix('/slider')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('slider.index');
        Route::post('/store', [SliderController::class, 'store'])->name('slider.store');
        Route::delete('/delete/{id}', [SliderController::class, 'delete'])->name('slider.delete');
        Route::post('/bulk-delete', [SliderController::class, 'bulkDelete'])->name('slider.bulkDelete');
        Route::get('/{id}', [SliderController::class, 'edit'])->name('slider.edit');
        Route::put('/{id}', [SliderController::class, 'update'])->name('slider.update');
    });
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
