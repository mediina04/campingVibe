<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CampingController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PostControllerAdvance;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// 🟠 AUTH PASSWORD RESET (Sin autenticación)
Route::post('forget-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forget.password.post');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');

// 🟢 RUTAS PÚBLICAS
Route::get('category-list', [CategoryController::class, 'getList']);
Route::get('get-posts', [PostControllerAdvance::class, 'getPosts']);
Route::get('get-category-posts/{id}', [PostControllerAdvance::class, 'getCategoryByPosts']);
Route::get('get-post/{id}', [PostControllerAdvance::class, 'getPost']);

// 🔵 CAMPINGS - Públicos y protegidos según middleware en el controlador
Route::get('/campings/destacados', [CampingController::class, 'destacados']);
Route::get('/campings', [CampingController::class, 'index']);
Route::get('/campings/{camping}', [CampingController::class, 'show']);

// 🟣 NOTES - Pueden estar protegidas si decides hacerlo con middleware
Route::get('note', [NoteController::class, 'index'])->name('note.index');
Route::post('note', [NoteController::class, 'store'])->name('note.store');
Route::get('note/{id}', [NoteController::class, 'show'])->name('note.show');
Route::put('note/{id}', [NoteController::class, 'update'])->name('note.update');
Route::delete('note/{id}', [NoteController::class, 'destroy'])->name('note.destroy');

// 🔒 RUTAS PROTEGIDAS POR SANCTUM
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/campings', [CampingController::class, 'store']);
    Route::put('/campings/{camping}', [CampingController::class, 'update']);
    Route::delete('/campings/{camping}', [CampingController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Users y Roles
    Route::apiResource('users', UserController::class);
    Route::post('users/updateimg', [UserController::class,'updateimg']);

    Route::apiResource('roles', RoleController::class);
    Route::get('role-list', [RoleController::class, 'getList']);
    Route::get('role-permissions/{id}', [PermissionController::class, 'getRolePermissions']);
    Route::put('/role-permissions', [PermissionController::class, 'updateRolePermissions']);

    // Permissions
    Route::apiResource('permissions', PermissionController::class);

    //Accommodations
    Route::apiResource('accommodations', AccommodationController::class);

    //Reviews
    Route::apiResource('reviews', ReviewController::class);

    //Reservations
    Route::apiResource('reservations', ReservationController::class);


    // Posts y Categorías
    Route::apiResource('posts', PostControllerAdvance::class);
    Route::apiResource('categories', CategoryController::class);

    // Profile
    Route::get('/user', [ProfileController::class, 'user']);
    Route::put('/user', [ProfileController::class, 'update']);

    // Abilities (Roles → Permisos)
    Route::get('abilities', function(Request $request) {
        return $request->user()->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    });
});
