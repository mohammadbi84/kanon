<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AcademyController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BenefitController;
use App\Http\Controllers\Admin\BookmarkController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ClusterController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\JobtypeController;
use App\Http\Controllers\Admin\KardaneshController;
use App\Http\Controllers\Admin\KhabarController;
use App\Http\Controllers\Admin\MinEducationController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\PositionPriceController;
use App\Http\Controllers\Admin\ProfessionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TuitionController;
use App\Http\Controllers\Admin\TuitionProfessionController;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->group(function () {
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

        // advertisements
        Route::get('/{position}/advertisement/{status?}', [AdvertisementController::class, 'advertisements'])->name('positions.advertisements');
    });
    // ================== advertisement ==================
    Route::prefix('/advertisement')->name('advertisement.')->group(function () {
        Route::get('/', [AdvertisementController::class, 'index'])->name('index');
        Route::post('/store', [AdvertisementController::class, 'store'])->name('store');
        Route::patch('/{id}/toggle', [AdvertisementController::class, 'toggle'])->name('toggle');
    });
    // ================== academy ==================
    Route::prefix('/academy')->group(function () {
        Route::get('/', [AcademyController::class, 'index'])->name('academy.index');
        Route::get('/pending', [AcademyController::class, 'pending'])->name('academy.pending');
        Route::get('/create', [AcademyController::class, 'create'])->name('academy.create');
        Route::post('/store', [AcademyController::class, 'store'])->name('academy.store');
        Route::delete('/delete/{id}', [AcademyController::class, 'delete'])->name('academy.delete');
        Route::post('/bulk-toggle', [AcademyController::class, 'bulkToggle'])->name('academy.bulkToggle');
        Route::get('/{id}/edit', [AcademyController::class, 'edit'])->name('academy.edit');
        Route::put('/{id}', [AcademyController::class, 'update'])->name('academy.update');
        Route::patch('/{academy}/toggle', [AcademyController::class, 'toggle'])->name('academy.toggle');
        Route::get('/{academy}/show', [AcademyController::class, 'show'])->name('academy.show');
    });
    // ================== Khabar ==================
    Route::prefix('/khabar')->group(function () {
        Route::get('/', [KhabarController::class, 'index'])->name('khabar.index');
        Route::post('/store', [KhabarController::class, 'store'])->name('khabar.store');
        Route::delete('/delete/{id}', [KhabarController::class, 'delete'])->name('khabar.delete');
        Route::post('/bulk-delete', [KhabarController::class, 'bulkDelete'])->name('khabar.bulkDelete');
        Route::get('/{id}', [KhabarController::class, 'edit'])->name('khabar.edit');
        Route::put('/{id}', [KhabarController::class, 'update'])->name('khabar.update');

        // images
        Route::get('/showImages/{id}', [KhabarController::class, 'showImages'])->name('khabar.showImages');
        Route::post('/upload/{id}', [KhabarController::class, 'uploadImage'])->name('khabar.upload');
        Route::post('/status/{id}', [KhabarController::class, 'toggleImageStatus'])->name('khabar.status');
        Route::delete('/image/{id}', [KhabarController::class, 'deleteImage'])->name('khabar.image.delete');
    });
    // ================== jobtypes ==================
    Route::prefix('/jobtype')->group(function () {
        Route::get('/', [JobtypeController::class, 'index'])->name('jobtype.index');
        Route::post('/store', [JobtypeController::class, 'store'])->name('jobtype.store');
        Route::delete('/delete/{id}', [JobtypeController::class, 'delete'])->name('jobtype.delete');
        Route::post('/bulk-delete', [JobTypeController::class, 'bulkDelete'])->name('jobtype.bulkDelete');
        Route::post('/update', [JobtypeController::class, 'update'])->name('jobtype.update');
        Route::get('/{id}', [JobtypeController::class, 'edit'])->name('jobtype.edit');
    });
    // ================== min educations ==================
    Route::prefix('/mineducations')->group(function () {
        Route::get('/', [MinEducationController::class, 'index'])->name('mineducations.index');
        Route::post('/store', [MinEducationController::class, 'store'])->name('mineducations.store');
        Route::delete('/delete/{id}', [MinEducationController::class, 'delete'])->name('mineducations.delete');
        Route::post('/bulk-delete', [MinEducationController::class, 'bulkDelete'])->name('mineducations.bulkDelete');
        Route::post('/update', [MinEducationController::class, 'update'])->name('mineducations.update');
        Route::get('/{id}', [MinEducationController::class, 'edit'])->name('mineducations.edit');
    });
    // ================== kardanesh ==================
    Route::prefix('/kardanesh')->group(function () {
        Route::get('/', [KardaneshController::class, 'index'])->name('kardanesh.index');
        Route::post('/store', [KardaneshController::class, 'store'])->name('kardanesh.store');
        Route::delete('/delete/{id}', [KardaneshController::class, 'delete'])->name('kardanesh.delete');
        Route::post('/bulk-delete', [KardaneshController::class, 'bulkDelete'])->name('kardanesh.bulkDelete');
        Route::post('/update', [KardaneshController::class, 'update'])->name('kardanesh.update');
        Route::get('/{id}', [KardaneshController::class, 'edit'])->name('kardanesh.edit');
    });
    // ================== Tuitions ==================
    Route::prefix('/tuitions')->name('tuitions.')->group(function () {
        Route::get('/', [TuitionController::class, 'index'])->name('index');
        Route::get('/available-states', [TuitionController::class, 'availableStates'])->name('available-states');
        Route::get('/available-cities', [TuitionController::class, 'availableCities'])->name('available-cities');
        Route::post('/store', [TuitionController::class, 'store'])->name('store');
        Route::get('/{tuition}/edit', [TuitionController::class, 'edit'])->name('edit');
        Route::put('/{tuition}', [TuitionController::class, 'update'])->name('update');
        Route::patch('/{tuition}/toggle', [TuitionController::class, 'toggle'])->name('toggle');
        Route::delete('/delete/{id}', [TuitionController::class, 'delete'])->name('delete');
        Route::post('/bulk-delete', [TuitionController::class, 'bulkDelete'])->name('bulkDelete');

        // professions
        Route::get('{tuition}/professions', [TuitionProfessionController::class, 'index'])->name('professions.index');
        Route::post('{tuition}/prices', [TuitionProfessionController::class, 'prices'])->name('professions.prices');
        Route::post('{tuition}/professions/update', [TuitionProfessionController::class, 'update'])->name('professions.update');
        Route::post('{tuition}/tuitions-professions/bulk-toggle', [TuitionProfessionController::class, 'bulkToggle'])->name('professions.bulk-toggle');
        Route::patch('{tuition}/{professionTuition}/toggle', [TuitionProfessionController::class, 'toggle'])->name('professions.toggle');
    });
    // ================== Categories ==================
    Route::prefix('/categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::post('/bulk-toggle', [CategoryController::class, 'bulkToggle'])->name('categories.bulkToggle');
        Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::post('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulkDelete');
        Route::post('/update', [CategoryController::class, 'update'])->name('categories.update');
        Route::get('/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::patch('/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');
    });

    // ================== Clusters ==================
    Route::prefix('/clusters')->group(function () {
        Route::get('/', [ClusterController::class, 'index'])->name('clusters.index');
        Route::post('/store', [ClusterController::class, 'store'])->name('clusters.store');
        Route::post('/bulk-toggle', [ClusterController::class, 'bulkToggle'])->name('clusters.bulkToggle');
        Route::delete('/delete/{id}', [ClusterController::class, 'delete'])->name('clusters.delete');
        Route::post('/bulk-delete', [ClusterController::class, 'bulkDelete'])->name('clusters.bulkDelete');
        Route::post('/update', [ClusterController::class, 'update'])->name('clusters.update');
        Route::get('/{id}', [ClusterController::class, 'edit'])->name('clusters.edit');
        Route::patch('/{cluster}/toggle', [ClusterController::class, 'toggle'])->name('clusters.toggle');
    });

    // ================== Fields ====================
    Route::prefix('/fields')->group(function () {
        Route::get('/', [FieldController::class, 'index'])->name('fields.index');
        Route::post('/store', [FieldController::class, 'store'])->name('fields.store');
        Route::post('/bulk-toggle', [FieldController::class, 'bulkToggle'])->name('fields.bulkToggle');
        Route::delete('/delete/{id}', [FieldController::class, 'delete'])->name('fields.delete');
        Route::post('/bulk-delete', [FieldController::class, 'bulkDelete'])->name('fields.bulkDelete');
        Route::post('/update', [FieldController::class, 'update'])->name('fields.update');
        Route::get('/{id}', [FieldController::class, 'edit'])->name('fields.edit');
        Route::patch('/{field}/toggle', [FieldController::class, 'toggle'])->name('fields.toggle');
    });

    // ================== Professions ==================
    Route::prefix('/professions')->group(function () {
        Route::get('/', [ProfessionController::class, 'index'])->name('professions.index');
        Route::get('/search', [ProfessionController::class, 'search'])->name('professions.search');
        Route::post('/bulk-toggle', [ProfessionController::class, 'bulkToggle'])->name('professions.bulkToggle');
        Route::post('/bulk-archive', [ProfessionController::class, 'bulkArchive'])->name('professions.bulkArchive');
        Route::get('/create', [ProfessionController::class, 'create'])->name('professions.create');
        Route::post('/store', [ProfessionController::class, 'store'])->name('professions.store');
        Route::post('/upload', [ProfessionController::class, 'upload'])->name('professions.upload');
        Route::post('/uploadExcel', [ProfessionController::class, 'uploadExcel'])->name('professions.uploadExcel');
        // پرینت لاگ ها
        Route::get('/print/{id}', [ProfessionController::class, 'print'])->name('professions.print');
        // لیست همه آپلودها
        Route::get('/imports', [ProfessionController::class, 'imports'])->name('professions.imports');
        // لاگ‌های مربوط به یک آپلود خاص
        Route::get('/imports/{id}/logs', [ProfessionController::class, 'import_log'])->name('professions.imports.logs');
        Route::delete('/delete/{id}', [ProfessionController::class, 'delete'])->name('professions.delete');
        Route::post('/bulk-delete', [ProfessionController::class, 'bulkDelete'])->name('professions.bulkDelete');
        Route::get('/{id}', [ProfessionController::class, 'edit'])->name('professions.edit');
        Route::put('/{id}', [ProfessionController::class, 'update'])->name('professions.update');
        Route::patch('/{profession}/toggle', [ProfessionController::class, 'toggle'])->name('professions.toggle');
        Route::patch('/{profession}/archive', [ProfessionController::class, 'archive'])->name('professions.archive');
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

    // ================== Benefit ==================
    Route::prefix('/benefit')->group(function () {
        Route::get('/', [BenefitController::class, 'index'])->name('benefit.index');
        Route::post('/store', [BenefitController::class, 'store'])->name('benefit.store');
        Route::delete('/delete/{id}', [BenefitController::class, 'delete'])->name('benefit.delete');
        Route::post('/bulk-delete', [BenefitController::class, 'bulkDelete'])->name('benefit.bulkDelete');
        Route::get('/{id}', [BenefitController::class, 'edit'])->name('benefit.edit');
        Route::post('/{id}', [BenefitController::class, 'update'])->name('benefit.update');
    });
});
