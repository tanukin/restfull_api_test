<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'namespace' => 'Product',
    'prefix' => 'products'
], function () {
    Route::get('/', 'ProductController@index')->name('products.index');
    Route::post('/', 'ProductController@store')->name('products.store');

    Route::group([
        'prefix' => '{product}'
    ], function () {
        Route::get('/', 'ProductController@show')->name('products.show');
        Route::put('/', 'ProductController@update')->name('products.update');
        Route::delete('/', 'ProductController@destroy')->name('products.destroy');

        Route::get('/reviews', 'ReviewController@index')->name('reviews.index');
        Route::post('/reviews', 'ReviewController@store')->name('reviews.store');

        Route::get('/reviews/{review}', 'ReviewController@show')->name('reviews.show');
        Route::put('/reviews/{review}', 'ReviewController@update')->name('reviews.update');
        Route::delete('/reviews/{review}', 'ReviewController@destroy')->name('reviews.destroy');
    });
});

