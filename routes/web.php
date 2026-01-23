<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/a-propos', function () {
    return view('a-propos');
})->name('a-propos');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/realisations', function () {
    return view('realisations');
})->name('realisations');

Route::get('/actualites', function () {
    return view('actualites');
})->name('actualites');

Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

Route::get('/appels-offres', [\App\Http\Controllers\OffreController::class, 'index'])->name('appels-offres.index');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/dashboard', function () {
    // Rediriger les admins et éditeurs vers l'admin
    if (auth()->check() && auth()->user()->isAdminOrEditor()) {
        return redirect()->route('admin.posts.index');
    }
    // Pour les autres utilisateurs, afficher le dashboard normal
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'adminOrEditor'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Posts (Articles/Blog)
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);

    // Upload d'images pour l'éditeur
    Route::post('/posts/upload-image', [\App\Http\Controllers\Admin\PostController::class, 'uploadImage'])->name('posts.upload-image');

    // Categories
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // Tags
    Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);

    // Règles de filtrage des offres
    Route::resource('filtering-rules', \App\Http\Controllers\Admin\FilteringRuleController::class);
    Route::post('/filtering-rules/reapply', [\App\Http\Controllers\Admin\FilteringRuleController::class, 'reapplyFiltering'])->name('filtering-rules.reapply');

    // Pôles d'activité
    Route::resource('activity-poles', \App\Http\Controllers\Admin\ActivityPoleController::class);
    Route::post('/activity-poles/{activityPole}/keywords', [\App\Http\Controllers\Admin\ActivityPoleController::class, 'addKeyword'])->name('activity-poles.keywords.add');
    Route::delete('/activity-poles/{activityPole}/keywords/{keyword}', [\App\Http\Controllers\Admin\ActivityPoleController::class, 'removeKeyword'])->name('activity-poles.keywords.remove');

    // Scraping des offres
    Route::get('/scraping', [\App\Http\Controllers\Admin\ScrapingController::class, 'index'])->name('scraping.index');
    Route::post('/scraping/start', [\App\Http\Controllers\Admin\ScrapingController::class, 'start'])->name('scraping.start');
    Route::get('/scraping/progress', [\App\Http\Controllers\Admin\ScrapingController::class, 'progress'])->name('scraping.progress');
    Route::get('/scraping/findings/{jobId}', [\App\Http\Controllers\Admin\ScrapingController::class, 'getFindings'])->name('scraping.findings');
    Route::post('/scraping/cancel', [\App\Http\Controllers\Admin\ScrapingController::class, 'cancel'])->name('scraping.cancel');
    Route::post('/scraping/truncate', [\App\Http\Controllers\Admin\ScrapingController::class, 'truncate'])->name('scraping.truncate');
    Route::get('/scraping/current-job-id', [\App\Http\Controllers\Admin\ScrapingController::class, 'getCurrentJobId'])->name('scraping.current-job-id');

    // Scraping automatique programmé
    Route::post('/scraping/schedule/update', [\App\Http\Controllers\Admin\ScrapingScheduleController::class, 'updateSchedule'])->name('scraping.schedule.update');
    Route::get('/scraping/schedule', [\App\Http\Controllers\Admin\ScrapingScheduleController::class, 'getSchedule'])->name('scraping.schedule.get');
});

// Admin Only Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Users
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});

require __DIR__ . '/auth.php';
