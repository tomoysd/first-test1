<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ContactController::class, 'create'])->name('contact.create');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');
Route::get('/confirm', fn() => redirect('/'));

Route::middleware('auth')->group(function () {
Route::get('/admin',                 [ContactAdminController::class, 'index'])->name('admin.contacts.index');
Route::get('/admin/contacts/{id}',   [ContactAdminController::class, 'show'])->name('admin.contacts.show');     // Ajax(詳細)
Route::delete('/admin/contacts/{id}',[ContactAdminController::class, 'destroy'])->name('admin.contacts.destroy');
Route::get('/admin/export',          [ContactAdminController::class, 'export'])->name('admin.contacts.export');
});