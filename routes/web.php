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


// 🏠 Página principal
Route::get('/', HomeController::class)->name('home');

// 👤 Registro y Autenticación
Route::prefix('register')->name('register.')->group(function () {
    Route::get('/', [RegisterController::class, 'index'])->name('index');
    Route::post('/', [RegisterController::class, 'store'])->name('store');
});

Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});

Route::get('/forgot-password', [forgot_password::class, 'index'])->name('password.request');
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// ⚙ Perfil de Usuario
Route::prefix('editar-perfil')->name('perfil.')->group(function () {
    Route::get('/', [PerfilController::class, 'index'])->name('index');
    Route::post('/', [PerfilController::class, 'store'])->name('store');
});

// 💬 Mensajes (requiere autenticación)
Route::middleware('auth')->prefix('messages')->name('messages.')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('index');
    Route::get('/{user}', [MessageController::class, 'getMessages'])->name('get');
    Route::post('/send', [MessageController::class, 'sendMessage'])->name('send');
});

// 🗺 Mapa
Route::get('/map', [MapController::class, 'index'])->name('map');

// 📝 Publicaciones
Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/create', [PostController::class, 'create'])->name('create');
    Route::post('/', [PostController::class, 'store'])->name('store');
    Route::get('/{user:username}/{post}', [PostController::class, 'show'])->name('show');
    Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');

    // ❤ Likes
    Route::post('/{post}/likes', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/{post}/likes', [LikeController::class, 'destroy'])->name('likes.destroy');
});

// 💬 Comentarios
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

// 📷 Imágenes
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

// ➕ / ➖ Seguidores
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

// 📄 Perfil de Usuario y sus Posts
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');

Route::get('/forgot-password', [forgot_password::class, 'index'])->name('password.request');
Route::post('/forgot-password', function (Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = \Illuminate\Support\Facades\Password::sendResetLink(
        $request->only('email')
    );

    return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');
Route::get('/reset-password/{token}', [forgot_password::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [forgot_password::class, 'reset'])->name('password.update');
