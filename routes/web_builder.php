<?php




Route::resource('siteSettings', 'SiteSettingController');
Route::resource('users', 'UserController');
Route::resource('permissions', 'PermissionController');
Route::resource('roleAndPermissions', 'RoleAndPermissionController');
Route::resource('designations', 'DesignationController');
Route::resource('districts', 'DistrictController');
Route::resource('upazilas', 'UpazilaController');



Route::resource('leaves', 'LeaveController');