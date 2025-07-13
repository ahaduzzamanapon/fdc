<?php


Route::resource('competences', 'CompetenceAPIController');

Route::resource('leaves', 'LeaveAPIController');

Route::resource('item_units', 'ItemUnitAPIController');

Route::resource('item_categories', 'ItemCategoryAPIController');

Route::resource('items', 'ItemAPIController');

Route::resource('divisions', 'DivisionAPIController');