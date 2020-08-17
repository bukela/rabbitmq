<?php

use App\Events\TestEvent;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function (Request $request) {
    // $notification = array('message' => 'Test notification');
    // broadcast(new TestEvent($notification));
    // return response(['test notification']);
    app('amqp')->publish('Message to direct exchange', 'routing-key', [
        'exchange' => [
            'type'    => 'direct',
            'name'    => 'direct.exchange',
        ],
    ]);
});