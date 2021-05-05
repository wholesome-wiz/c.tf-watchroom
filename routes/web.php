<?php

use App\Http\Controllers\DigitalDirectiveController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function()
// {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index',])->name('home');

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

Route::resource('users', App\Http\Controllers\UserController::class);

Route::resource('items', App\Http\Controllers\ItemController::class);

Route::resource('statistics', App\Http\Controllers\StatisticController::class);

Route::prefix('/dd20')->group(function()
{
    Route::get('/', DigitalDirectiveController::class . '@index')->name('dd20.index');
    Route::get('/find', DigitalDirectiveController::class . '@find')->name('dd20.find');
    Route::get('/{player}/rpc', DigitalDirectiveController::class . '@cmd')->name('dd20.rpc');
    Route::get('/{player}', DigitalDirectiveController::class . '@view')->name('dd20.view');
    Route::post('/{player}', DigitalDirectiveController::class . '@store')->name('dd20.save');
});