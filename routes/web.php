<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/admin/login', function () {
    return view('admin.auth.login');
});

Route::get('/', function () {
    return view('loket_antrian.index');
    return view('welcome');
});


Route::get('/staff', function () {
    return view('loket_staff.index');
});



Route::get('/poli', function () {
    return view('loket_staff.poli');
});



Route::get('/poli_call', function () {
    return view('loket_staff.call');
});


Route::get('/poli_terpanggil', function () {
    return view('pasien.poli_terpanggil');
});

Route::get('/admin', function () {
    return view('admin.index');
});
