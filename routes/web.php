<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\JobOpportunityController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PannelController;
use App\Http\Controllers\PopupController;
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
    Route::get('/', [JobOpportunityController::class, 'categories'])->name('job-opportunity.categories');
    Route::get('/jobs', [JobOpportunityController::class, 'index'])->name('job-opportunity.index');
});














Route::get('/AboutUs', [\App\Http\Controllers\AboutUsController::class, 'site'])->middleware('senddata');
Route::get('/register', [\App\Http\Controllers\SiteController::class, 'register']);
Route::post('/register', [\App\Http\Controllers\SchoolController::class, 'addPost']);
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


// api
Route::post('/like/{advertisement_id}', [LikeController::class, 'toggle']);
Route::get('/like-count/{advertisement_id}', [LikeController::class, 'count']);
Route::get('/like/{advertisement_id}/check', function ($id) {
    $ip = request()->ip();
    $liked = \App\Models\Like::where('advertisement_id', $id)
        ->where('ip_address', $ip)->exists();
    return response()->json(['liked' => $liked]);
});


Route::prefix('/dashboard')->group(function () {
    // Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'loginPost']);
});

Route::prefix('/dashboard')->middleware('auth')->group(function () {

    Route::get('contents', [\App\Http\Controllers\ContentController::class, 'index'])->name('contents.index');
    Route::get('contents/create', [\App\Http\Controllers\ContentController::class, 'create'])->name('contents.create');
    Route::post('contents', [\App\Http\Controllers\ContentController::class, 'store'])->name('contents.store');

    // روت‌های جدید برای ایجاد تیتر اصلی
    Route::get('contents/createTitle', [\App\Http\Controllers\ContentController::class, 'createTitle'])->name('contents.createTitle');
    Route::post('contents/storeTitle', [\App\Http\Controllers\ContentController::class, 'storeTitle'])->name('contents.storeTitle');

    // روت‌های بروزرسانی و حذف
    Route::get('contents/edit/{id}', [\App\Http\Controllers\ContentController::class, 'edit'])->name('contents.edit');
    Route::put('contents/{id}', [\App\Http\Controllers\ContentController::class, 'update'])->name('contents.update');
    Route::delete('contents/{id}', [\App\Http\Controllers\ContentController::class, 'destroy'])->name('contents.destroy');
    Route::delete('destroyTitle', [\App\Http\Controllers\ContentController::class, 'destroyTitle'])->name('contents.destroyTitle');


    Route::post('/referral_update/{id}', [\App\Http\Controllers\SchoolController::class, 'referral_update']);
    Route::post('/admin_update/{id}', [\App\Http\Controllers\SchoolController::class, 'referral_update'])->name('admin_update');

    Route::get('/home', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
    Route::get('/verify', [\App\Http\Controllers\DashboardController::class, 'verify'])->middleware('auth');
    Route::post('/verify', [\App\Http\Controllers\DashboardController::class, 'verifyCheck'])->name('verify.check')->middleware('auth');

    Route::get('/pay/{id}', [\App\Http\Controllers\PayController::class, 'pay'])->name('pay');
    Route::get('/pay-all/{id}', [\App\Http\Controllers\PayController::class, 'payAll'])->name('pay.all');


    Route::prefix('/About-us')->group(function () {
        Route::get('/list', [\App\Http\Controllers\AboutUsController::class, 'index'])->name('about.index');
        Route::get('/add', [\App\Http\Controllers\AboutUsController::class, 'create'])->name('about.add');
        Route::post('/add', [\App\Http\Controllers\AboutUsController::class, 'store'])->name('about.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\AboutUsController::class, 'destroy'])->name('about.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\AboutUsController::class, 'edit'])->name('about.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\AboutUsController::class, 'update'])->name('about.editpost');
    });


    Route::prefix('/Advertisement')->group(function () {
        Route::get('/list', [\App\Http\Controllers\AdvertisementController::class, 'list'])->name('Advertisement.list');
        Route::get('/add', [\App\Http\Controllers\AdvertisementController::class, 'add'])->name('Advertisement.add');
        Route::post('/add', [\App\Http\Controllers\AdvertisementController::class, 'addPost'])->name('Advertisement.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\AdvertisementController::class, 'delete'])->name('Advertisement.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\AdvertisementController::class, 'edit'])->name('Advertisement.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\AdvertisementController::class, 'editPost'])->name('Advertisement.editpost');
    });


    Route::prefix('/Ads')->group(function () {
        Route::prefix('/login')->group(function () {
            Route::get('/list', [\App\Http\Controllers\LoginPageAds::class, 'login_list'])->name('adslogin.list');
            Route::get('/add', [\App\Http\Controllers\LoginPageAds::class, 'login_add'])->name('adslogin.add');
            Route::post('/add', [\App\Http\Controllers\LoginPageAds::class, 'login_addPost'])->name('adslogin.addpost');
            Route::get('/delete/{id}', [\App\Http\Controllers\LoginPageAds::class, 'login_delete'])->name('adslogin.delete');
            Route::get('/edit/{id}', [\App\Http\Controllers\LoginPageAds::class, 'login_edit'])->name('adslogin.edit');
            Route::post('/edit/{id}', [\App\Http\Controllers\LoginPageAds::class, 'login_editPost'])->name('adslogin.editpost');
        });
        Route::prefix('/video')->group(function () {
            Route::get('/list', [\App\Http\Controllers\videoAds::class, 'video_list'])->name('videoads.list');
            Route::get('/add', [\App\Http\Controllers\videoAds::class, 'video_add'])->name('videoads.add');
            Route::post('/add', [\App\Http\Controllers\videoAds::class, 'video_addPost'])->name('videoads.addpost');
            Route::get('/delete/{id}', [\App\Http\Controllers\videoAds::class, 'video_delete'])->name('videoads.delete');
            Route::get('/edit/{id}', [\App\Http\Controllers\videoAds::class, 'video_edit'])->name('videoads.edit');
            Route::post('/edit/{id}', [\App\Http\Controllers\videoAds::class, 'video_editPost'])->name('videoads.editpost');
        });
    });



    Route::prefix('/training-course')->group(function () {
        Route::get('/list', [\App\Http\Controllers\TrainingCourseController::class, 'list'])->name('course.list');
        Route::get('/add', [\App\Http\Controllers\TrainingCourseController::class, 'add'])->name('course.add');
        Route::post('/add', [\App\Http\Controllers\TrainingCourseController::class, 'addPost'])->name('course.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\TrainingCourseController::class, 'delete'])->name('course.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\TrainingCourseController::class, 'edit'])->name('course.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\TrainingCourseController::class, 'editPost'])->name('course.editpost');
    });
    Route::prefix('/off')->group(function () {
        Route::get('/list', [\App\Http\Controllers\OffController::class, 'list'])->name('off.list');
        Route::get('/add', [\App\Http\Controllers\OffController::class, 'add'])->name('off.add');
        Route::post('/add', [\App\Http\Controllers\OffController::class, 'addPost'])->name('off.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\OffController::class, 'delete'])->name('off.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\OffController::class, 'edit'])->name('off.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\OffController::class, 'editPost'])->name('off.editpost');
    });
    Route::prefix('/city')->group(function () {
        Route::get('/state', [\App\Http\Controllers\StateController::class, 'states'])->name('state.list');
        Route::post('/state', [\App\Http\Controllers\StateController::class, 'statesChange'])->name('state.change');
        Route::get('/city', [\App\Http\Controllers\StateController::class, 'cities'])->name('city.list');
        Route::post('/city', [\App\Http\Controllers\StateController::class, 'citiesChange'])->name('city.change');
    });
    Route::get('/policy', [\App\Http\Controllers\SiteController::class, 'policy'])->name('policy.list');
    Route::post('/policy', [\App\Http\Controllers\SiteController::class, 'policyChange'])->name('policy.change');

    Route::prefix('/organ')->group(function () {
        Route::get('/herfe', [\App\Http\Controllers\SchoolController::class, 'herfes'])->name('organ.herfes');
        Route::post('/herfe', action: [\App\Http\Controllers\SchoolController::class, 'herfesPost'])->name('organ.herfes.post');
        Route::get('/reshte', [\App\Http\Controllers\SchoolController::class, 'reshtes'])->name('organ.reshtes');
        Route::post('/reshte', [\App\Http\Controllers\SchoolController::class, 'reshtesPost'])->name('organ.reshtes.post');
        Route::get('/file', [\App\Http\Controllers\SchoolController::class, 'files'])->name('organ.files');
        Route::post('/file', [\App\Http\Controllers\SchoolController::class, 'filesPost'])->name('organ.files.post');
    });
    Route::prefix('regester')->name('organ.')->group(function () {
        // لیست
        Route::get('/', [\App\Http\Controllers\AdminOrganController::class, 'index'])->name('index');
        // فرم ایجاد
        Route::get('/create', [\App\Http\Controllers\AdminOrganController::class, 'create'])->name('create');

        // ذخیره آموزشگاه جدید
        Route::post('/store', [\App\Http\Controllers\AdminOrganController::class, 'store'])->name('store');

        // فرم ویرایش
        Route::get('/edit/{id}', [\App\Http\Controllers\AdminOrganController::class, 'edit'])->name('edit');

        // بروزرسانی
        Route::put('/update/{id}', [\App\Http\Controllers\AdminOrganController::class, 'update'])->name('update');

        // حذف
        Route::delete('/destroy/{id}', [\App\Http\Controllers\AdminOrganController::class, 'destroy'])->name('destroy');
        Route::post('/status/{organ}', [\App\Http\Controllers\AdminOrganController::class, 'status'])->name('status');
    });

    Route::prefix('/asnaf')->group(function () {
        Route::get('/list', [\App\Http\Controllers\SenfController::class, 'list'])->name('senf.list');
        Route::get('/add', [\App\Http\Controllers\SenfController::class, 'add'])->name('senf.add');
        Route::post('/add', [\App\Http\Controllers\SenfController::class, 'addPost'])->name('senf.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\SenfController::class, 'delete'])->name('senf.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\SenfController::class, 'edit'])->name('senf.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\SenfController::class, 'editPost'])->name('senf.editpost');
        Route::prefix('/{o_id}/users')->group(function () {
            Route::get('/list', [\App\Http\Controllers\MemberController::class, 'list'])->name('member.list');
            Route::get('/add', [\App\Http\Controllers\MemberController::class, 'add'])->name('member.add');
            Route::post('/add', [\App\Http\Controllers\MemberController::class, 'addPost'])->name('member.addpost');
            Route::get('/delete/{id}', [\App\Http\Controllers\MemberController::class, 'delete'])->name('member.delete');
            Route::get('/edit/{id}', [\App\Http\Controllers\MemberController::class, 'edit'])->name('member.edit');
            Route::post('/edit/{id}', [\App\Http\Controllers\MemberController::class, 'editPost'])->name('member.editpost');
        });

        Route::get('/schools-list', [\App\Http\Controllers\SchoolController::class, 'list1'])->name('school.list1');
        Route::get('/schools-show/{id}', [\App\Http\Controllers\SchoolController::class, 'show1'])->name('school.show1');
        Route::get('/school-delete/{id}', [\App\Http\Controllers\SchoolController::class, 'school_delete'])->name('school.delete');
        Route::get('/school-active/{id}', [\App\Http\Controllers\SchoolController::class, 'school_active'])->name('school.active');
        Route::post('/schools-warning/{id}', [\App\Http\Controllers\SchoolController::class, 'school_warning'])->name('school.warning');


        Route::prefix('/{o_id}/schools')->group(function () {
            Route::get('/list', [\App\Http\Controllers\SchoolController::class, 'list'])->name('school.list');
            Route::get('/add', [\App\Http\Controllers\SchoolController::class, 'add'])->name('school.add');
            Route::post('/add', [\App\Http\Controllers\SchoolController::class, 'addPost'])->name('school.addpost');
            Route::get('/delete/{id}', [\App\Http\Controllers\SchoolController::class, 'delete'])->name('school.delete');
            Route::get('/edit/{id}', [\App\Http\Controllers\SchoolController::class, 'edit'])->name('school.edit');
            Route::post('/edit/{id}', [\App\Http\Controllers\SchoolController::class, 'editPost'])->name('school.editpost');
        });
    });
    Route::prefix('/standard')->group(function () {
        Route::get('/list', [\App\Http\Controllers\StandardController::class, 'list'])->name('standard.list');
        Route::get('/list/{$id}', [\App\Http\Controllers\StandardController::class, 'list1'])->name('standard.list1');
        Route::post('/add', [\App\Http\Controllers\StandardController::class, 'addPost'])->name('standard.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\StandardController::class, 'delete'])->name('standard.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\StandardController::class, 'edit'])->name('standard.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\StandardController::class, 'editPost'])->name('standard.editpost');
        Route::post('/bulk-delete', [\App\Http\Controllers\StandardController::class, 'bulkDelete'])->name('standard.bulk-delete');
    });
    Route::prefix('/khoshe')->group(function () {
        Route::get('/list', [\App\Http\Controllers\KhosheController::class, 'list'])->name('khoshe.list');
        Route::post('/add', [\App\Http\Controllers\KhosheController::class, 'addPost'])->name('khoshe.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\KhosheController::class, 'delete'])->name('khoshe.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\KhosheController::class, 'edit'])->name('khoshe.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\KhosheController::class, 'editPost'])->name('khoshe.editpost');
        Route::post('/bulk-delete', [\App\Http\Controllers\KhosheController::class, 'bulkDelete'])->name('khoshe.bulk-delete');
    });
    Route::prefix('/group')->group(function () {
        Route::get('/list/{id}', [\App\Http\Controllers\GroupController::class, 'list'])->name('group.list');
        Route::post('/add/{id}', [\App\Http\Controllers\GroupController::class, 'addPost'])->name('group.addpost');

        Route::get('/list1', [\App\Http\Controllers\GroupController::class, 'list1'])->name('group.list1');
        Route::post('/add1', [\App\Http\Controllers\GroupController::class, 'addPost1'])->name('group.addpost1');

        Route::get('/delete/{id}', [\App\Http\Controllers\GroupController::class, 'delete'])->name('group.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\GroupController::class, 'edit'])->name('group.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\GroupController::class, 'editPost'])->name('group.editpost');
    });
    Route::prefix('mineducation')->group(function () {
        Route::get('/', [\App\Http\Controllers\MinEducationController::class, 'index'])->name('mineducation.list');
        Route::get('/create', [\App\Http\Controllers\MinEducationController::class, 'create'])->name('mineducation.create');
        Route::post('/store', [\App\Http\Controllers\MinEducationController::class, 'store'])->name('mineducation.store');
        Route::get('/edit/{id}', [\App\Http\Controllers\MinEducationController::class, 'edit'])->name('mineducation.edit');
        Route::post('/update/{id}', [\App\Http\Controllers\MinEducationController::class, 'update'])->name('mineducation.update');
        Route::get('/delete/{id}', [\App\Http\Controllers\MinEducationController::class, 'destroy'])->name('mineducation.delete');
    });

    Route::prefix('/herfe')->group(function () {
        Route::get('/list', [\App\Http\Controllers\HerfeController::class, 'list'])->name('herfe.list');
        Route::get('/list1', [\App\Http\Controllers\HerfeController::class, 'list1'])->name('herfe.list1');
        Route::post('/add', [\App\Http\Controllers\HerfeController::class, 'addPost'])->name('herfe.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\HerfeController::class, 'delete'])->name('herfe.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\HerfeController::class, 'edit'])->name('herfe.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\HerfeController::class, 'editPost'])->name('herfe.editpost');
        Route::post('/bulk-delete', [\App\Http\Controllers\HerfeController::class, 'bulkDelete'])->name('herfe.bulk-delete');
    });
    Route::prefix('/sanad')->group(function () {
        Route::get('/list', [\App\Http\Controllers\SanadController::class, 'list'])->name('sanad.list');
        Route::get('/list1', [\App\Http\Controllers\SanadController::class, 'list1'])->name('sanad.list1');
        Route::post('/add', [\App\Http\Controllers\SanadController::class, 'addPost'])->name('sanad.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\SanadController::class, 'delete'])->name('sanad.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\SanadController::class, 'edit'])->name('sanad.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\SanadController::class, 'editPost'])->name('sanad.editpost');
    });

    Route::get('/tuition', [App\Http\Controllers\TuitionHerfeController::class, 'home'])->name('tuition'); // نمایش لیست سال‌ها
    Route::prefix('/tuition_herfe')->group(function () {
        Route::get('/create', [App\Http\Controllers\TuitionHerfeController::class, 'create'])->name('tuition_herfe.create'); // فرم اضافه کردن سال
        Route::post('/store', [App\Http\Controllers\TuitionHerfeController::class, 'storeyear'])->name('tuition_herfe.store'); // فرم اضافه کردن سال
        Route::get('/{year}', [App\Http\Controllers\TuitionHerfeController::class, 'showYear'])->name('tuition_herfe.showYear'); // نمایش جزئیات سال
        Route::post('/updateAll', [App\Http\Controllers\TuitionHerfeController::class, 'updateAll'])->name('tuition_herfe.updateAll'); // بروزرسانی قیمت‌ها
    });


    Route::prefix('/jobtype')->group(function () {
        Route::get('/list', [\App\Http\Controllers\JobtypeController::class, 'list'])->name('jobtype.list');
        Route::post('/add', [\App\Http\Controllers\JobtypeController::class, 'addPost'])->name('jobtype.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\JobtypeController::class, 'delete'])->name('jobtype.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\JobtypeController::class, 'edit'])->name('jobtype.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\JobtypeController::class, 'editPost'])->name('jobtype.editpost');
    });
    Route::prefix('/kardanesh')->group(function () {
        Route::get('/list', [\App\Http\Controllers\KardaneshController::class, 'list'])->name('kardanesh.list');
        Route::post('/add', [\App\Http\Controllers\KardaneshController::class, 'addPost'])->name('kardanesh.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\KardaneshController::class, 'delete'])->name('kardanesh.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\KardaneshController::class, 'edit'])->name('kardanesh.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\KardaneshController::class, 'editPost'])->name('kardanesh.editpost');
    });

    Route::prefix('/khabar')->group(function () {
        Route::get('/list', [\App\Http\Controllers\KhabarController::class, 'list'])->name('khabar.list');
        Route::get('/add', [\App\Http\Controllers\KhabarController::class, 'add'])->name('khabar.add');
        Route::post('/add', [\App\Http\Controllers\KhabarController::class, 'addPost'])->name('khabar.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\KhabarController::class, 'delete'])->name('khabar.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\KhabarController::class, 'edit'])->name('khabar.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\KhabarController::class, 'editPost'])->name('khabar.editpost');
        Route::post('/bulk-delete', [\App\Http\Controllers\KhabarController::class, 'bulkDelete'])->name('khabar.bulk-delete');
        Route::get('/gallary/{id}', [\App\Http\Controllers\KhabarController::class, 'gallary'])->name('khabar.gallary');
        Route::post('add-image/{id}', [\App\Http\Controllers\KhabarController::class, 'addImage'])->name('khabar.add-image');
        Route::get('delete-image/{id}', [\App\Http\Controllers\KhabarController::class, 'deleteImage'])->name('khabar.delete-image');
    });

    Route::prefix('/topadv')->group(function () {
        Route::get('/list', [\App\Http\Controllers\TopadvController::class, 'list'])->name('topadv.list');
        Route::get('/add', [\App\Http\Controllers\TopadvController::class, 'add'])->name('topadv.add');
        Route::post('/add', [\App\Http\Controllers\TopadvController::class, 'addPost'])->name('topadv.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\TopadvController::class, 'delete'])->name('topadv.delete');
        Route::get('/edit/{id}', [\App\Http\Controllers\TopadvController::class, 'edit'])->name('topadv.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\TopadvController::class, 'editPost'])->name('topadv.editpost');
    });


    Route::prefix('/slider')->group(function () {
        Route::get('/list', [\App\Http\Controllers\SliderController::class, 'list'])->name('slider.list');
        Route::post('/add', [\App\Http\Controllers\SliderController::class, 'addPost'])->name('slider.addpost');
        Route::get('/delete/{id}', [\App\Http\Controllers\SliderController::class, 'delete'])->name('slider.delete');
        Route::get('/release/{id}/{type}', [\App\Http\Controllers\SliderController::class, 'release'])->name('slider.release');
        Route::get('/edit/{id}', [\App\Http\Controllers\SliderController::class, 'edit'])->name('slider.edit');
        Route::post('/edit/{id}', [\App\Http\Controllers\SliderController::class, 'editPost'])->name('slider.editpost');
        Route::get('/deleteMedia/{id}', [\App\Http\Controllers\SliderController::class, 'deleteMedia'])->name('slider.deleteMedia');
    });
    // register message
    Route::get('/register-message', [RegisterMessageController::class, 'edit'])->name('register_message.edit');
    Route::post('/register-message', [RegisterMessageController::class, 'update'])->name('register_message.update');
    // pop-up
    Route::get('/popup', [PopupController::class, 'edit'])->name('popup.edit');
    Route::post('/popup', [PopupController::class, 'update'])->name('popup.update');
    // alert_register
    Route::get('/register_alert', [RegisterAlertController::class, 'edit'])->name('register_alert.edit');
    Route::post('/register_alert', [RegisterAlertController::class, 'update'])->name('register_alert.update');
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
