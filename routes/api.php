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
    app('amqp')->publish('hi to direct exchange', 'message', [
        'connection' => 'konekcija', // should exists in amqp.php file
        'channel_id' => 100, // int value or decided by the package
        'exchange'   => [], // exchange configuration like amqp.php file
        'message'    => [], // msg conf, will be passed along with msg
    ]);
});

Route::get('konzum', function (Request $request) {
    app('amqp')->consume(function ($message) {}, 'message', [
        'connection' => 'konekcija', // should exists in amqp.php file
        'channel_id' => 100, // int value or decided by the package
        'exchange'   => [], // exchange configuration like amqp.php file
        'queue'      => [], // queue configuration like amqp.php file,
        'consumer'   => [], // consumer configuration like amqp.php file
        'qos'        => [], // qos configuration like amqp.php file
    ]);
});