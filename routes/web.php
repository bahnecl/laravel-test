<?php

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
$this->get('/', 'HomeController@index')->name('home');
$this->get('buy/{id}', 'PaymentController@create')->name('create.invoice');
$this->get('return-paypal', 'PaymentController@returnPayPal')->name('return.paypal');
$this->get('paypal', 'PaymentController@create')->name('paypal');