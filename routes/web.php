<?php

use App\Models\Producer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\ProfileController;


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

Route::get('/', function () {
    return view('index');
})->middleware('auth');



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
        Route::get('/dashboard', 'dashboard');
    });
});








Route::get('/upload_exell', function () {
    return view('upload_exell');
});
Route::get('/get_who', function () {
    dd(auth()->user()->group_id);
});
