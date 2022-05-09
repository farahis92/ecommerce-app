<?php

use App\Mail\OtpMail;
use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    sendMail();
    return response()->json('success');
});

function sendMail(): void
{
    Mail::to('fajarraz70@gmail.com')->send(new OtpMail('212455'));
}
