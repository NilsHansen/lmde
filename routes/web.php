<?php
use Illuminate\Support\Facades\Route;
use GrahamCampbell\Markdown\Facades\Markdown;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Content;

Route::get('/login', function() {
    return view('login');
})->name('loginS');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::resource('/editor', ContentController::class)->middleware('auth');
Route::get('/{content}',function(Content $content) {
    if($content->external == 1 || (Auth::check() && Auth::user()->id == $content->user_id)) {
        $otherContent = Content::where(function($query) {
            if(Auth::user())
                $query->where('external',1)->orWhere('user_id', Auth::user()->id);
            else
                $query->where('external',1);
        })->where('id','!=',$content->id)->get(['slug','name']);
        return view('external', compact('content','otherContent'));
    } else
        abort(404);
})->name('contentLink');

Route::get('/', function(Request $request) {
    $notes = Content::where('external', '1')->get()->sortByDesc('updated_at');
    if($request->has('q')) {
        $search = $request->input('q');
        $notes = collect($notes)->filter(function ($item) use ($search) {
            return false !== stripos($item, $search);
        });
    }
    return view('welcome', compact('notes'));
})->name('start');