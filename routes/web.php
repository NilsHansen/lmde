<?php

use Illuminate\Support\Facades\Route;
use GrahamCampbell\Markdown\Facades\Markdown;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ContentController;
use App\Models\Content;

Route::get('/login', function() {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::resource('/editor', ContentController::class)->middleware('auth');
Route::get('/{content}',function(Content $content) {
    if($content->external == 1 || Auth::user()->id == $content->user_id) {
        $otherContent = Content::where('external',1)->get();
        dd($otherContent);
        return view('external', compact('content','otherContent'));
    } else
        abort(404);
});

Route::redirect('/','/editor');
