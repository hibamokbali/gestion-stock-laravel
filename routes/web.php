<?php

use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\ConfigurationSeuilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDash;
use App\Http\Controllers\Admin\DirectionController;
use App\Http\Controllers\Admin\EmployeController;
use App\Http\Controllers\Admin\EntreeController;
use App\Http\Controllers\Admin\FournisseurController;
use App\Http\Controllers\Admin\MagasinController;
use App\Http\Controllers\Admin\SortieController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\UniteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\DashboardController as UserDash;

Route::redirect('/', '/login');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Redirection /dashboard selon le rôle
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // Redirection /home selon le rôle
    Route::get('/home', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('home');


    // ROUTES ADMIN

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDash::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('directions', DirectionController::class);
        Route::resource('magasins', MagasinController::class);
        Route::resource('employes', EmployeController::class);
        Route::resource('categories', CategorieController::class);
        Route::resource('unites', UniteController::class);
        Route::resource('fournisseurs', FournisseurController::class);
        // CRUD partagés ADMIN + USER (même contrôleur)
        Route::resource('entrees', EntreeController::class);
        Route::resource('sorties', SortieController::class);

        // Consultation Stock
        Route::get('stock', [StockController::class, 'index'])->name('stock.index');

        // Configuration seuil rapide (modal)
        // ✅ AJOUTÉ - Configuration du seuil (ADMIN uniquement)
        Route::post('unites/{unite}/configure-seuil', [UniteController::class, 'configurerSeuil'])
            ->name('unites.configure-seuil');

        // PDF Fiche de décharge
        Route::get('sorties/{id}/pdf', [SortieController::class, 'generatePDF'])->name('sorties.pdf');
    });


    // ROUTES USER

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDash::class, 'index'])->name('dashboard');

        // MÊMES contrôleurs que admin, mais préfixe différent
        Route::resource('entrees', EntreeController::class);
        Route::resource('sorties', SortieController::class);

        // Consultation Stock (lecture seule)
        Route::get('stock', [StockController::class, 'index'])->name('stock.index');
        // VÉRIFIEZ si cette route existe
        Route::post('/admin/unites/{unite}/configure-seuil', [UniteController::class, 'configurerSeuil'])
            ->name('admin.unites.configurer-seuil');

        // PDF
        Route::get('sorties/{id}/pdf', [SortieController::class, 'generatePDF'])->name('sorties.pdf');
    });
});
