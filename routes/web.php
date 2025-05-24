<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;
use App\Http\Livewire\LikePost;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\forgot_password;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\DonativoController;

Route::prefix('donativos')->group(function () {
    Route::get('/', [DonativoController::class, 'create'])->name('donativos.create');
    Route::post('/', [DonativoController::class, 'store'])->name('donativos.store');
});

Route::get('/', HomeController::class)->name('home');

Route::prefix('register')->name('register.')->group(function () {
    Route::get('/', [RegisterController::class, 'index'])->name('index');
    Route::post('/', [RegisterController::class, 'store'])->name('store');
});

Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

Route::prefix('editar-perfil')->name('perfil.')->group(function () {
    Route::get('/', [PerfilController::class, 'index'])->name('index');
    Route::post('/', [PerfilController::class, 'store'])->name('store');
});

Route::middleware('auth')->prefix('messages')->name('messages.')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('index');
    Route::get('/{user}', [MessageController::class, 'getMessages'])->name('get');
    Route::post('/send', [MessageController::class, 'sendMessage'])->name('send');
});

Route::get('/map', [MapController::class, 'index'])->name('map');

Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/create', [PostController::class, 'create'])->name('create');
    Route::post('/', [PostController::class, 'store'])->name('store');
    Route::get('/{user:username}/{post}', [PostController::class, 'show'])->name('show');
    Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
    Route::post('/{post}/likes', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/{post}/likes', [LikeController::class, 'destroy'])->name('likes.destroy');
});

Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');

Route::get('/forgot-password', [forgot_password::class, 'index'])->name('password.request');
Route::post('/forgot-password', function (Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    try {
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    } catch (\Exception $e) {
        Log::error('Error en enviar enlace de recuperación: ' . $e->getMessage());
        return back()->withErrors(['email' => 'Error: ' . $e->getMessage()]);
    }
})->name('password.email');

Route::get('/reset-password/{token}', [forgot_password::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [forgot_password::class, 'reset'])->name('password.update');
