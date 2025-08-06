<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Filament\Resources\CommentResource\Pages\RespondComment;
use App\Http\Controllers\ResponseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/comments/respond/{id}', [RespondComment::class, 'respond'])->name('comments.respond');
// Route::post('/comments/{id}/send-response', [CommentController::class, 'sendResponse'])
//     ->name('comments.sendResponse');
//     Route::get('/comments/{comment}/respond', RespondComment::class)->name('comments.respond');
//     Route::get('/respond-comment/{comment}', RespondComment::class);

Route::get('/', function () {
    return redirect('/tiket/login');
});

Route::middleware(['auth'])->group(function () {

        Route::post('/responses', [ResponseController::class, 'store'])->name('responses.store');
Route::delete('/responses/{response}', [ResponseController::class, 'destroy'])->name('responses.destroy');
// Route::get('/respond/{record}', [CommentController::class, 'respond'])
//     ->name('comments.respond'); // Pastikan middleware sesuai



});


