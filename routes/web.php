<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Gunakan redirect() untuk mengalihkan ke URL /admin
    return redirect('/admin');
});