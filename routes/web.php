<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect('dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ticket
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::middleware('can:create-ticket')
        ->group(function () {
            Route::get('/tickets/add', [TicketController::class, 'create'])
                ->name('tickets.create');
            Route::post('/tickets', [TicketController::class, 'store'])
                ->name('tickets.store');
        });
    Route::get('/tickets/{ticket:id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::put('/tickets/{ticket:id}', [TicketController::class, 'update'])
        ->name('tickets.update');

    // Comment
    Route::post('/tickets/{ticket:id}/comments', [CommentsController::class, 'store'])
        ->name('comments.store')
        ->can('create-comment', ['ticket']);
});

require __DIR__ . '/auth.php';
