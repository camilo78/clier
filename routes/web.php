<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');

// Public SEO routes
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [\App\Http\Controllers\RobotsTxtController::class, 'index'])->name('robots');

// Quote request route
Route::post('/quote-request', [\App\Http\Controllers\QuoteRequestController::class, 'send'])->name('quote.send');

// Contact form route
Route::post('/contact-send', [\App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

Route::middleware(['auth'])->group(function (): void {
    
    // Redirect /admin to admin index
    Route::redirect('/admin', '/admin/')->name('admin');

    // Impersonations
    Route::post('/impersonate/{user}', [\App\Http\Controllers\ImpersonationController::class, 'store'])->name('impersonate.store')->middleware('can:impersonate');
    Route::delete('/impersonate/stop', [\App\Http\Controllers\ImpersonationController::class, 'destroy'])->name('impersonate.destroy');

    // Settings
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', \App\Livewire\Settings\Profile::class)->name('settings.profile');
    Route::get('settings/password', \App\Livewire\Settings\Password::class)->name('settings.password');
    Route::get('settings/appearance', \App\Livewire\Settings\Appearance::class)->name('settings.appearance');
    Route::get('settings/locale', \App\Livewire\Settings\Locale::class)->name('settings.locale');

    // Admin
    Route::prefix('admin')->as('admin.')->group(function (): void {
        Route::get('/', \App\Livewire\Admin\Index::class)->middleware(['auth', 'verified'])->name('index')->middleware('can:access dashboard');
        Route::get('/users', \App\Livewire\Admin\Users::class)->name('users.index')->middleware('can:view users');
        Route::get('/users/create', \App\Livewire\Admin\Users\CreateUser::class)->name('users.create')->middleware('can:create users');
        Route::get('/users/{user}', \App\Livewire\Admin\Users\ViewUser::class)->name('users.show')->middleware('can:view users');
        Route::get('/users/{user}/edit', \App\Livewire\Admin\Users\EditUser::class)->name('users.edit')->middleware('can:update users');
        Route::get('/roles', \App\Livewire\Admin\Roles::class)->name('roles.index')->middleware('can:view roles');
        Route::get('/roles/create', \App\Livewire\Admin\Roles\CreateRole::class)->name('roles.create')->middleware('can:create roles');
        Route::get('/roles/{role}/edit', \App\Livewire\Admin\Roles\EditRole::class)->name('roles.edit')->middleware('can:update roles');
        Route::get('/permissions', \App\Livewire\Admin\Permissions::class)->name('permissions.index')->middleware('can:view permissions');
        Route::get('/permissions/create', \App\Livewire\Admin\Permissions\CreatePermission::class)->name('permissions.create')->middleware('can:create permissions');
        Route::get('/permissions/{permission}/edit', \App\Livewire\Admin\Permissions\EditPermission::class)->name('permissions.edit')->middleware('can:update permissions');
        
        // CMS Routes
        Route::prefix('cms')->as('cms.')->group(function (): void {
            Route::get('/company-info', \App\Livewire\Admin\Cms\CompanyInfo\Index::class)->name('company-info')->middleware('can:manage cms');
            Route::get('/slides', \App\Livewire\Admin\Cms\Slides\Index::class)->name('slides')->middleware('can:manage cms');
            Route::get('/slides/create', \App\Livewire\Admin\Cms\Slides\Create::class)->name('slides.create')->middleware('can:manage cms');
            Route::get('/slides/{slide}/edit', \App\Livewire\Admin\Cms\Slides\Edit::class)->name('slides.edit')->middleware('can:manage cms');
            Route::get('/services', \App\Livewire\Admin\Cms\Services\Index::class)->name('services')->middleware('can:manage cms');
            Route::get('/services/create', \App\Livewire\Admin\Cms\Services\Create::class)->name('services.create')->middleware('can:manage cms');
            Route::get('/services/{service}/edit', \App\Livewire\Admin\Cms\Services\Edit::class)->name('services.edit')->middleware('can:manage cms');
            Route::get('/testimonials', \App\Livewire\Admin\Cms\Testimonials\Index::class)->name('testimonials')->middleware('can:manage cms');
            Route::get('/testimonials/create', \App\Livewire\Admin\Cms\Testimonials\Create::class)->name('testimonials.create')->middleware('can:manage cms');
            Route::get('/testimonials/{testimonial}/edit', \App\Livewire\Admin\Cms\Testimonials\Edit::class)->name('testimonials.edit')->middleware('can:manage cms');

        });

        // SEO Routes
        Route::prefix('seo')->as('seo.')->group(function (): void {
            Route::get('/global-config', \App\Livewire\Admin\Seo\GlobalConfig\Index::class)->name('global-config')->middleware('can:manage cms');
            Route::get('/page-settings', \App\Livewire\Admin\Seo\PageSettings\Index::class)->name('page-settings')->middleware('can:manage cms');
        });
    });
});

require __DIR__.'/auth.php';