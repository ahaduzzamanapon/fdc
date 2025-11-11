<?php
use App\Models\Producer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\FilmApplicationController;
use App\Http\Controllers\DramaApplicationController;
use App\Http\Controllers\DocufilmApplicationController;
use App\Http\Controllers\RealityApplicationController;
use App\Http\Controllers\PartyApplicationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MakePaymentController;
use App\Http\Controllers\Reports;
use App\Http\Controllers\LanguageController;

Route::get('lang/{locale}', [LanguageController::class, 'switch']);




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

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');
Route::get('/', function () {
    return view('welcome');
});

// payments
Route::resource('makePayments', 'MakePaymentController');
Route::prefix('make-payment')->name('makePayments.')->group(function () {
    Route::get('{makePayment}/forward/{desk}', [MakePaymentController::class, 'forward'])->name('forward');
    Route::post('change_status', [MakePaymentController::class, 'update_status'])->name('st.status');
    Route::get('make_payment/{package_id}', [MakePaymentController::class, 'make_payment'])->name('make_payment');
    Route::get('package', [MakePaymentController::class, 'package'])->name('package');
    Route::post('package', [MakePaymentController::class, 'custom_package_store'])->name('cp.store');
    // Route::get('cm_package_list', [MakePaymentController::class, 'cm_package_list'])->name('cm_package_list');
    Route::get('makeCustomPackage', [MakePaymentController::class, 'makeCustomPackage'])->name('makeCustomPackage');
    Route::get('get_items_by_type', [MakePaymentController::class, 'get_items_by_type'])->name('get_items_by_type');
});
Route::get('makePayments_forward_table', [MakePaymentController::class, 'forward_table'])->name('makePayments.forward.table');

// party applications
Route::resource('partyApplications', 'PartyApplicationController');
Route::prefix('party-application')->name('partyApplications.')->group(function () {
    Route::get('{partyApplication}/forward/{desk}', [PartyApplicationController::class, 'forward'])->name('forward');
    Route::post('change_status', [PartyApplicationController::class, 'update_status'])->name('st.status');
});
Route::get('partyApplications_forward_table', [PartyApplicationController::class, 'forward_table'])->name('partyApplications.forward.table');

// reality applications
Route::resource('realityApplications', 'RealityApplicationController');
Route::prefix('reality-application')->name('realityApplications.')->group(function () {
    Route::get('{realityApplication}/forward/{desk}', [RealityApplicationController::class, 'forward'])->name('forward');
    Route::post('change_status', [RealityApplicationController::class, 'update_status'])->name('st.status');
});
Route::get('realityApplications_forward_table', [RealityApplicationController::class, 'forward_table'])->name('realityApplications.forward.table');

// docufilm applications
Route::resource('docufilmApplications', 'DocufilmApplicationController');
Route::prefix('docufilm-application')->name('docufilmApplications.')->group(function () {
    Route::get('{docufilmApplication}/forward/{desk}', [DocufilmApplicationController::class, 'forward'])->name('forward');
    Route::post('change_status', [DocufilmApplicationController::class, 'update_status'])->name('st.status');
});
Route::get('docufilmApplications_forward_table', [DocufilmApplicationController::class, 'forward_table'])->name('docufilmApplications.forward.table');

// drama applications
Route::resource('dramaApplications', 'DramaApplicationController');
Route::prefix('drama-application')->name('dramaApplications.')->group(function () {
    Route::get('{dramaApplication}/forward/{desk}', [DramaApplicationController::class, 'forward'])->name('forward');
    Route::post('change_status', [DramaApplicationController::class, 'update_status'])->name('st.status');
});
Route::get('dramaApplications_forward_table', [DramaApplicationController::class, 'forward_table'])->name('dramaApplications.forward.table');

// film applications
Route::resource('filmApplications', 'FilmApplicationController');
Route::prefix('film-applications')->name('filmApplications.')->group(function () {
    Route::get('{filmApplication}/forward/{desk}', [FilmApplicationController::class, 'forward'])->name('forward');
    Route::post('change_status', [FilmApplicationController::class, 'update_status'])->name('st.status');
    Route::get('{filmApplication}/back/{desk}', [FilmApplicationController::class, 'back'])->name('back');
    Route::get('{filmApplication}/final-forward/{desk}', [FilmApplicationController::class, 'finalForwardToMD'])->name('final_forward_to_md');
    Route::get('{filmApplication}/approve_md/{desk}', [FilmApplicationController::class, 'approve_md'])->name('approve_md');
    Route::get('{filmApplication}/make_payment/{package_id}', [FilmApplicationController::class, 'make_payment'])->name('make_payment');
    Route::get('{filmApplication}/payment_data', [FilmApplicationController::class, 'payment_data'])->name('payment_data');
    Route::get('single_payment_receipt/{filmPackage}', [FilmApplicationController::class, 'single_payment_receipt'])->name('single_payment_receipt');
});


// reports
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('film-reports', [Reports::class, 'film_report_index'])->name('filmReport');
    Route::post('show-film-reports', [Reports::class, 'film_report_show'])->name('showFilmReport');

    Route::get('drama-reports', [Reports::class, 'drama_report_index'])->name('dramaReport');
    Route::post('show-drama-reports', [Reports::class, 'drama_report_show'])->name('showDramaReport');

    Route::get('pramanno-reports', [Reports::class, 'pramanno_report_index'])->name('pramannoReport');
    Route::post('show-pramanno-reports', [Reports::class, 'pramanno_report_show'])->name('showPramannoReport');

    Route::get('reality-reports', [Reports::class, 'reality_report_index'])->name('realityReport');
    Route::post('show-reality-reports', [Reports::class, 'reality_report_show'])->name('showRealityReport');


    Route::post('/export/{type}', [Reports::class, 'exportReport'])->name('export');


});

Route::get('filmApplications_forward_table', [FilmApplicationController::class, 'forward_table'])->name('filmApplications.forward.table');
Route::get('filmApplications_backward_table', [FilmApplicationController::class, 'backward_table'])->name('filmApplications.backward.table');





Route::get('/innitiate_payment/{transaction_id}', [PaymentController::class, 'innitiate_payment'])->name('innitiate_payment');

// EkPay callback routes (success, cancel)
Route::get('/filmApplications/payment/success', [PaymentController::class, 'ekPaySuccess']);
Route::get('/filmApplications/payment/cancel', [PaymentController::class, 'ekPayCancel']);

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
        Route::get('/get_application', 'get_application')->name('producer.get_application');
        Route::get('/get_applicant_balance', 'get_applicant_balance')->name('producer.get_applicant_balance');
        Route::get('/get_items_by_category', 'get_items_by_category')->name('producer.get_items_by_category');
        Route::get('/get_shift_by_item', 'get_shift_by_item')->name('producer.get_shift_by_item');
        Route::get('/get_booking_date', 'get_booking_date')->name('producer.get_booking_date');
        Route::post('/add_to_cart', 'add_to_cart')->name('producer.add_to_cart');
        Route::post('/producer_booking_request', 'producer_booking_request')->name('producer.producer_booking_request');

        Route::get('/producer_booking_details/{id}', 'show_booking_details')->name('producer.booking_details');
        Route::get('/approve_booking/{id}', 'approve_booking')->name('producer.approve_booking');
        Route::get('/booking_forward_table', 'forward_table')->name('producerBooking.forward.table');
        Route::get('{booking}/forward/{desk}', 'forward')->name('producerBooking.forward');
        Route::post('/change_status', 'update_status')->name('producerBooking.st.status');
    });
});









Route::get('/upload_exell', function () {
    return view('upload_exell');
});
