<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;

// Rutas principales del sitio web
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/beneficios', function () {
    return view('beneficios');
})->name('beneficios');

Route::get('/portada', function () {
    return view('portada');
});

Route::get('/sobre-nosotros', function () {
    return view('sobre-nosotros');
})->name('sobre-nosotros');

Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

Route::get('/servicios/marketing', function () {
    return view('fragmentos.info-servicios.marketing');
});

Route::get('/servicios/consultoria', function () {
    return view('fragmentos.info-servicios.consultoria');
});

Route::get('/servicios/eventos-activaciones', function () {
    return view('fragmentos.info-servicios.eventos-activaciones');
});

Route::get('/contactanos', function () {
    return view('contactanos');
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Rutas de administración (protegidas por autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
});

// ===== RUTAS DEL CHATBOT =====

// RUTA NUEVA: Para guardar contactos desde el widget JavaScript
Route::post('/guardar-contacto', [ChatbotController::class, 'guardarContacto'])->name('guardar.contacto');

// Ruta principal de BotMan (para escuchar mensajes GET y POST)
Route::match(['get', 'post'], '/botman', [ChatbotController::class, 'handleBotRequest'])
    ->name('botman')
    ->middleware(['web']);

// Ruta para manejar los mensajes del chatbot (POST)
Route::post('/chatbot', [ChatbotController::class, 'handleMessage'])
    ->name('chatbot.message')
    ->middleware(['web']);

// Rutas de utilidad del chatbot
Route::get('/chatbot/init', [ChatbotController::class, 'init'])
    ->name('chatbot.init');

Route::get('/chatbot/status', [ChatbotController::class, 'status'])
    ->name('chatbot.status');

// Ruta para la vista del widget del chatbot (opcional)
Route::get('/chatbot', function () {
    return view('chatbot.widget');
})->name('chatbot.widget');

// ===== RUTAS DE TESTING (SOLO DESARROLLO) =====
if (app()->environment('local')) {
    // Ruta para probar el chatbot sin widget
    Route::get('/chatbot/test', function () {
        return response()->json([
            'message' => 'Chatbot test endpoint',
            'endpoints' => [
                'botman' => route('botman'),
                'direct' => route('chatbot.message'),
                'init' => route('chatbot.init'),
                'status' => route('chatbot.status')
            ]
        ]);
    });
}