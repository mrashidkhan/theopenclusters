<?php

use Illuminate\Support\Facades\Route;


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

use App\Http\Controllers\PageController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactController;

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/project', [PageController::class, 'project'])->name('project');
Route::get('/service', [PageController::class, 'service'])->name('service');
Route::get('/client', [PageController::class, 'client'])->name('client');
Route::get('/team', [PageController::class, 'team'])->name('team');
Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');

/* Services Routes */
Route::get('/services/automation', [ServicesController::class, 'automation'])->name('services.automation');
Route::get('/services/itservice', [ServicesController::class, 'itservice'])->name('services.itservice');
Route::get('/services/itsolutions', [ServicesController::class, 'itsolutions'])->name('services.itsolutions');
Route::get('/services/softwaredevelopment', [ServicesController::class, 'softwaredevelopment'])->name('services.softwaredevelopment');
Route::get('/services/staffing', [ServicesController::class, 'staffing'])->name('services.staffing');
Route::get('/services/training', [ServicesController::class, 'training'])->name('services.training');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
