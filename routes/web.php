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
use App\Http\Controllers\BlogController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminStaffController;

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/aboutus', [PageController::class, 'aboutus'])->name('aboutus');
Route::get('/contactus', [PageController::class, 'contactus'])->name('contactus');
// Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs');
Route::get('/projects', [PageController::class, 'projects'])->name('projects');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/clients', [PageController::class, 'clients'])->name('clients');
Route::get('/team', [PageController::class, 'team'])->name('team');
Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');


/* Blog Routes */
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blogs/category/{categorySlug}', [BlogController::class, 'category'])->name('blogs.category');
Route::get('/blogs/tag/{tagSlug}', [BlogController::class, 'tag'])->name('blogs.tag');
Route::get('/blogs/archive/{year}/{month?}', [BlogController::class, 'archive'])->name('blogs.archive');
// New route for comment submission
Route::post('blog/comments/store', [BlogController::class, 'storeComment'])->name('blog.comments.store');


/* Services Routes */
Route::get('/services/automation', [ServicesController::class, 'automation'])->name('services.automation');
Route::get('/services/itservice', [ServicesController::class, 'itservice'])->name('services.itservice');
Route::get('/services/itsolutions', [ServicesController::class, 'itsolutions'])->name('services.itsolutions');
Route::get('/services/softwaredevelopment', [ServicesController::class, 'softwaredevelopment'])->name('services.softwaredevelopment');
Route::get('/services/staffing', [ServicesController::class, 'staffing'])->name('services.staffing');
Route::get('/services/training', [ServicesController::class, 'training'])->name('services.training');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


/* Admin Routes */
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');

    // Posts Management
    Route::resource('posts', AdminPostController::class);
    Route::patch('posts/{post}/toggle-status', [AdminPostController::class, 'toggleStatus'])->name('posts.toggle-status');
    Route::patch('posts/{post}/toggle-featured', [AdminPostController::class, 'toggleFeatured'])->name('posts.toggle-featured');

    Route::post('posts/bulk-action', [AdminPostController::class, 'bulkAction'])->name('posts.bulk-action');

    // Categories Management
    Route::resource('categories', AdminCategoryController::class);
    Route::patch('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::post('categories/update-order', [AdminCategoryController::class, 'updateOrder'])->name('categories.update-order');

    // Tags Management
    Route::resource('tags', AdminTagController::class);
    Route::patch('tags/{tag}/toggle-status', [AdminTagController::class, 'toggleStatus'])->name('tags.toggle-status');
    Route::delete('tags/bulk-delete', [AdminTagController::class, 'bulkDelete'])->name('tags.bulk-delete');

    // Comments Management
    Route::resource('comments', AdminCommentController::class)->except(['create', 'store']);
    Route::patch('comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::patch('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
    // Route::patch('comments/{comment}/spam', [AdminCommentController::class, 'spam'])->name('comments.spam');
    Route::patch('comments/{comment}/toggle-featured', [AdminCommentController::class, 'toggleFeatured'])->name('comments.toggle-featured');
    Route::post('comments/bulk-action', [AdminCommentController::class, 'bulkAction'])->name('comments.bulk-action');
    Route::post('comments/{comment}/reply', [AdminCommentController::class, 'reply'])->name('comments.reply');
    Route::get('comments/pending', [AdminCommentController::class, 'pending'])->name('comments.pending');
    Route::get('comments/spam', [AdminCommentController::class, 'spam'])->name('comments.spam');

    // Staff Management
    Route::resource('staff', AdminStaffController::class);
    Route::patch('staff/{staff}/toggle-status', [AdminStaffController::class, 'toggleStatus'])->name('staff.toggle-status');
    Route::delete('staff/{staff}/remove-avatar', [AdminStaffController::class, 'removeAvatar'])->name('staff.remove-avatar');
    Route::get('staff/{staff}/profile', [AdminStaffController::class, 'profile'])->name('staff.profile');

});

// Add this near the top with other routes, before the admin routes
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
