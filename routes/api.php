<?php

use App\Http\Controllers\Api\V1\WaitingList\WaitingListController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'as' => 'api.v1.',
    'middleware' => ['api', 'throttle:50,1'],
], function () {

    // #region WaitingList
    Route::apiResource(
        'waiting_lists',
        WaitingListController::class
    )
        ->except(['show', 'update', 'destroy']);

    Route::delete(
        'waiting_lists',
        [WaitingListController::class, 'destroy']
    )
        ->name('waiting_lists.destroy');
    // #endregion
});
