<?php


Route::group([
    'namespace' => 'Dkp\Seat\SeatDKP\Http\Controllers',
    'prefix' => 'dkp',
], function () {

    Route::group([
        'middleware' => ['web', 'auth'],
    ], function () {

        Route::get('/', [
            'as' => 'dkp.minelist',
            'uses' => 'DkpController@getMineDkp',
            'middleware' => 'can:dkp.request',
        ]);

        Route::get('/commodity', [
            'as' => 'dkp.commodity',
            'uses' => 'DkpController@commodity',
            'middleware' => 'can:dkp.request',
        ]);

        Route::post('/rollbackCommodity', [
            'as' => 'dkp.rollbackCommodity',
            'uses' => 'DkpController@rollbackCommodity',
            'middleware' => 'can:dkp.request',
        ]);

        Route::get('/exchangeCommodity/{supplementId}/{userId}', [
            'as' => 'dkp.exchangeCommodity',
            'uses' => 'DkpController@exchangeCommodity',
            'middleware' => 'can:dkp.request',
        ]);

        Route::get('/approve', [
            'as' => 'dkp.approve',
            'uses' => 'DkpController@approve',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::get('/approve/{kill_id}/{action}', [
            'as'   => 'dkp.settle',
            'uses' => 'DkpController@dkpApprove',
            'middleware' => 'can:dkp.admin',
        ])->where(['action' => 'Approve|Reject|Paid Out|Pending']);

        Route::get('/supplement', [
            'as' => 'dkp.supplement',
            'uses' => 'DkpController@supplement',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::post('/createSupplement', [
            'as' => 'dkp.createSupplement',
            'uses' => 'DkpController@createSupplement',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::post('/supplementDelete', [
            'as' => 'dkp.supplementDelete',
            'uses' => 'DkpController@supplementDelete',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::post('/supplementUpdate', [
            'as' => 'dkp.supplementUpdate',
            'uses' => 'DkpController@supplementUpdate',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::get('/setting', [
            'as' => 'dkp.settings',
            'uses' => 'DkpController@settings',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::post('/settingDkpAdd', [
            'as' => 'dkp.settingDkpAdd',
            'uses' => 'DkpController@settingDkpAdd',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::post('/settingDkpEdit', [
            'as' => 'dkp.settingDkpEdit',
            'uses' => 'DkpController@settingDkpEdit',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::post('/settingDkpDelete', [
            'as' => 'dkp.settingDkpDelete',
            'uses' => 'DkpController@settingDkpDelete',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::get('/commodityInfo', [
            'as' => 'dkp.commodityInfo',
            'uses' => 'DkpController@getCommodityInfo',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::get('/allScoreDetail/{userId}', [
            'as' => 'dkp.allScoreDetail',
            'uses' => 'DkpController@allScoreDetail',
            'middleware' => 'can:dkp.admin',
        ]);

        Route::get('/useScoreDetail/{userId}', [
            'as' => 'dkp.useScoreDetail',
            'uses' => 'DkpController@useScoreDetail',
            'middleware' => 'can:dkp.admin',
        ]);
    });
});
