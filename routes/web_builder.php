<?php

Route::resource('siteSettings', 'SiteSettingController');
Route::resource('users', 'UserController');
Route::resource('invPermissions', 'InvPermissionController');
Route::resource('permissions', 'PermissionController');
Route::resource('roleAndPermissions', 'RoleAndPermissionController');
Route::resource('designations', 'DesignationController');
Route::resource('districts', 'DistrictController');
Route::resource('upazilas', 'UpazilaController');
Route::resource('leaves', 'LeaveController');
Route::resource('departments', 'DepartmentController');
Route::resource('leaveTypes', 'LeaveTypeController');

Route::resource('producers', 'ProducerController');



Route::resource('itemDepartments', 'ItemDepartmentController');
Route::resource('itemUnits', 'ItemUnitController');
Route::resource('itemCategories', 'ItemCategoryController');
Route::get('items/export', 'ItemController@export')->name('items.export');
Route::post('items/import', 'ItemController@import')->name('items.import');
Route::resource('items', 'ItemController');


Route::resource('divisions', 'DivisionController');

Route::resource('packages', 'PackageController');



Route::resource('shifts', 'ShiftController');

Route::resource('approvalFlowMasters', 'ApprovalFlowMasterController');

Route::resource('approvalFlowSteps', 'ApprovalFlowStepsController');

Route::resource('approvalRequests', 'ApprovalRequestsController');

Route::resource('approvalLogs', 'ApprovalLogsController');
use App\Http\Controllers\DecadeFilmListController;

// Keep backward compatibility for old /decadeFilms/search links while supporting pagination via GET.
Route::match(['get', 'post'], 'decadeFilms/search', [DecadeFilmListController::class, 'index'])->name('decadeFilms.search');

Route::resource('decadeFilms', DecadeFilmListController::class);
Route::resource('decadeFilmsPhotos', PhotoGalleryController::class);
