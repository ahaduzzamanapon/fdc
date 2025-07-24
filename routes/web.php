<?php

use App\Models\Producer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\LeaveController;


include 'demo.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

// login2, register2 pages
Route::view('login2', 'auth.login2');
Route::view('login3', 'auth.login3');
Route::view('register2', 'auth.register2');
Route::view('register3', 'auth.register3');

Route::get('/dashboard', function () {
    return view('index');
})->middleware('auth');
Route::get('/', function () {
    return view('welcome');
});

Route::resource('filmApplications', 'FilmApplicationController');

// GUI crud builder routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

    Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

    Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

    Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

    Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

    Route::post(
        'generator_builder/generate-from-file',
        '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
    )->name('io_generator_builder_generate_from_file');

    // Model checking
    Route::post('tableCheck', 'AppBaseController@tableCheck');

    include 'web_builder.php';







    //hguigig7ig
    Route::get('get_upazilas', 'HomeController@get_upazilas')->name('get_upazilas');

    Route::resource('profile', ProfileController::class);

    // leave action Dept Head / MD
    Route::get('leave-apply-list', 'LeaveController@applyLeaveList')->name('leaves.apply.leave.list');
    Route::get('/forward-to-dept-head/{id}', 'LeaveController@forwardToDeptHead')->name('forward.to.dept.head');
    Route::get('/forward-to-md/{id}', 'LeaveController@forwardToMd')->name('forward.to.md');
    Route::get('/forward-to-director-finance/{id}', 'LeaveController@forwardToDirectorFinance')->name('forward.to.director.finance');
    Route::get('/leave-approved/{id}', 'LeaveController@leaveApproved')->name('leaves.approved');
    Route::get('/leave-rejected/{id}', 'LeaveController@leaveRejected')->name('leaves.rejected');
    // end leave action .....

    Route::get('/dashboard-data', [HomeController::class, 'getDashboardData'])->name('dashboard.data');
});
Route::get('empty_table', 'JoshController@emptyTable');
Route::get('remove_all_files', 'JoshController@remove_all_files');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('{name?}', 'JoshController@showView');





Route::post('/producers_register', [ProducerController::class, 'producers_register'])->name('producers_register');



Route::post('/producers_login', [ProducerController::class, 'producers_login'])->name('producers_login');


Route::group(["middleware" => []], function () {
    Route::prefix('producer')->controller(ProducerController::class)
        ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('producer.dashboard');
        Route::get('/booking', 'booking')->name('producer.booking');
        Route::get('/create_page', 'create_page')->name('producer.create_page');
        Route::post('/book_store', 'book_store')->name('producer.book_store');
        Route::get('/get_items_by_category', 'get_items_by_category')->name('producer.get_items_by_category');
        Route::get('/get_booking_date_by_item', 'get_booking_date_by_item')->name('producer.get_booking_date_by_item');
        Route::post('/add_to_cart', 'add_to_cart')->name('producer.add_to_cart');
        Route::post('/producer_booking_request', 'producer_booking_request')->name('producer.producer_booking_request');
    });
});








Route::get('/upload_exell', function () {
    return view('upload_exell');
});
Route::get('/get_who', function () {
    dd(auth()->user()->group_id);
});
