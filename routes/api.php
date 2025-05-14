<?php

use App\Http\Controllers\Api\MidtransController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Hanya bisa di akses jika sudah di hosting atau menggunakan Ngrok
Route::post('/midtrans-callback', [MidtransController::class, 'callback']);
