<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\AiEventController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\TestEmail;
use App\Http\Controllers\TaskController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/notite', [NoteController::class, 'index'])->name('notite.index');
    Route::post('/notite', [NoteController::class, 'store'])->name('notite.store');
    Route::delete('/notite/{id}', [NoteController::class, 'destroy'])->name('notite.destroy');
});

Route::get('/evenimente', [EventController::class, 'index'])->middleware('auth');
Route::get('/calendar', [CalendarController::class, 'index'])->middleware(['auth']);
Route::get('/calendar/events', [CalendarController::class, 'getEvents'])->middleware(['auth']);
Route::post('/calendar/events', [CalendarController::class, 'store'])->middleware(['auth']);
Route::middleware(['auth'])->group(function () {
    Route::get('/calendar/events', [UserEventController::class, 'index']);
    Route::post('/calendar/events', [UserEventController::class, 'store']);
});

Route::post('/ai/add-event', [AiEventController::class, 'addEvent'])->middleware('auth');

Route::get('/test-email', function () {
    try {
        Mail::to('rralucapa@gmail.com')->send(new TestEmail());
        Log::info('✅ Email trimis cu succes!');
        return 'Email trimis!';
    } catch (\Exception $e) {
        Log::error('❌ Eroare la trimiterea emailului: ' . $e->getMessage());
        return 'Eroare: ' . $e->getMessage();
    }
});

Route::get('/recomandari', [OfferController::class, 'index'])->name('offers.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/todo', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/todo', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/todo/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/todo/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

require __DIR__.'/auth.php';
