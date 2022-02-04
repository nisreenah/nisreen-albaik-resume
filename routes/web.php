<?php

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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/post-single/{blog}', 'HomeController@postSingle')->name('post-single');
Route::get('/project-single/{portfolio}', 'HomeController@projectSingle')->name('project-single');
Route::post('/leave-a-comment', 'HomeController@leaveComment')->name('leave-a-comment');
Route::post('/get-in-touch', 'HomeController@getInTouch')->name('get-in-touch');

Route::group(['middleware' => ['auth']], function () {

    Route::prefix('admin')->group(function () {

        Route::prefix('users')->group(function () {
            Route::get('/', 'UsersController@index')->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/store', 'UsersController@store')->name('users.store');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::put('/{user}/update', 'UsersController@update')->name('users.update');
            Route::get('/{user}/destroy', 'UsersController@destroy')->name('users.destroy');
        });

        Route::prefix('comments')->group(function () {
            Route::get('/', 'CommentsController@index')->name('comments.index');
            Route::get('/{comment}', 'CommentsController@show')->name('comments.show');
            Route::post('/store', 'CommentsController@store')->name('comments.store');
            Route::get('/{comment}/destroy', 'CommentsController@destroy')->name('comments.destroy');
            Route::get('/{comment}/activate', 'CommentsController@activate')->name('comments.activate');
            Route::get('/{comment}/deactivate', 'CommentsController@deactivate')->name('comments.deactivate');
        });

        Route::prefix('blogs')->group(function () {
            Route::get('/', 'BlogsController@index')->name('blogs.index');
            Route::get('/create', 'BlogsController@create')->name('blogs.create');
            Route::post('/store', 'BlogsController@store')->name('blogs.store');
            Route::get('/{blog}/edit', 'BlogsController@edit')->name('blogs.edit');
            Route::put('/{blog}/update', 'BlogsController@update')->name('blogs.update');
            Route::get('/{blog}/destroy', 'BlogsController@destroy')->name('blogs.destroy');
            Route::get('/{blog}/activate', 'BlogsController@activate')->name('blogs.activate');
            Route::get('/{blog}/deactivate', 'BlogsController@deactivate')->name('blogs.deactivate');
        });

        Route::prefix('profile')->group(function () {
            Route::get('/', 'ProfileController@index')->name('profile.index');
            Route::get('/create', 'ProfileController@create')->name('profile.create');
            Route::post('/store', 'ProfileController@store')->name('profile.store');
            Route::get('/{profile}/edit', 'ProfileController@edit')->name('profile.edit');
            Route::put('/{profile}/update', 'ProfileController@update')->name('profile.update');
            Route::get('/{profile}/destroy', 'ProfileController@destroy')->name('profile.destroy');
            Route::get('/{profile}/activate', 'ProfileController@activate')->name('profile.activate');
            Route::get('/{profile}/deactivate', 'ProfileController@deactivate')->name('profile.deactivate');
        });

        Route::prefix('skills')->group(function () {
            Route::get('/', 'SkillsController@index')->name('skills.index');
            Route::get('/create', 'SkillsController@create')->name('skills.create');
            Route::post('/store', 'SkillsController@store')->name('skills.store');
            Route::get('/{skill}/edit', 'SkillsController@edit')->name('skills.edit');
            Route::put('/{skill}/update', 'SkillsController@update')->name('skills.update');
            Route::get('/{skill}/destroy', 'SkillsController@destroy')->name('skills.destroy');
        });

        Route::prefix('experiences')->group(function () {
            Route::get('/', 'ExperiencesController@index')->name('experiences.index');
            Route::get('/create', 'ExperiencesController@create')->name('experiences.create');
            Route::post('/store', 'ExperiencesController@store')->name('experiences.store');
            Route::get('/{experience}/edit', 'ExperiencesController@edit')->name('experiences.edit');
            Route::put('/{experience}/update', 'ExperiencesController@update')->name('experiences.update');
            Route::get('/{experience}/destroy', 'ExperiencesController@destroy')->name('experiences.destroy');
        });

        Route::prefix('educations')->group(function () {
            Route::get('/', 'EducationsController@index')->name('educations.index');
            Route::get('/create', 'EducationsController@store')->name('educations.create');
            Route::post('/store', 'EducationsController@store')->name('educations.store');
            Route::get('/{education}/edit', 'EducationsController@edit')->name('educations.edit');
            Route::put('/{education}/update', 'EducationsController@update')->name('educations.update');
            Route::get('/{education}/destroy', 'EducationsController@destroy')->name('educations.destroy');
        });

        Route::prefix('services')->group(function () {
            Route::get('/', 'ServicesController@index')->name('services.index');
            Route::get('/create', 'ServicesController@create')->name('services.create');
            Route::post('/store', 'ServicesController@store')->name('services.store');
            Route::get('/{service}/edit', 'ServicesController@edit')->name('services.edit');
            Route::put('/{service}/update', 'ServicesController@update')->name('services.update');
            Route::get('/{service}/destroy', 'ServicesController@destroy')->name('services.destroy');
        });

        Route::prefix('testimonials')->group(function () {
            Route::get('/', 'TestimonialsController@index')->name('testimonials.index');
            Route::get('/create', 'TestimonialsController@create')->name('testimonials.create');
            Route::post('/store', 'TestimonialsController@store')->name('testimonials.store');
            Route::get('/{testimonial}/edit', 'TestimonialsController@edit')->name('testimonials.edit');
            Route::put('/{testimonial}/update', 'TestimonialsController@update')->name('testimonials.update');
            Route::get('/{testimonial}/destroy', 'TestimonialsController@destroy')->name('testimonials.destroy');
        });

        Route::prefix('contact-us')->group(function () {
            Route::get('/', 'ContactUsController@index')->name('contact-us.index');
            Route::get('/{contact}', 'ContactUsController@show')->name('contact-us.show');
            Route::post('/store', 'ContactUsController@store')->name('contact-us.store');
            Route::get('/{contact}/edit', 'ContactUsController@edit')->name('contact-us.edit');
            Route::put('/{contact}/update', 'ContactUsController@update')->name('contact-us.update');
            Route::get('/{contact}/destroy', 'ContactUsController@destroy')->name('contact-us.destroy');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', 'CategoriesController@index')->name('categories.index');
            Route::get('/create', 'CategoriesController@create')->name('categories.create');
            Route::post('/store', 'CategoriesController@store')->name('categories.store');
            Route::get('/{category}/edit', 'CategoriesController@edit')->name('categories.edit');
            Route::put('/{category}/update', 'CategoriesController@update')->name('categories.update');
            Route::get('/{category}/destroy', 'CategoriesController@destroy')->name('categories.destroy');
        });

        Route::prefix('portfolio')->group(function () {
            Route::get('/', 'PortfolioController@index')->name('portfolio.index');
            Route::get('/create', 'PortfolioController@create')->name('portfolio.create');
            Route::post('/store', 'PortfolioController@store')->name('portfolio.store');
            Route::get('/{portfolio}/edit', 'PortfolioController@edit')->name('portfolio.edit');
            Route::put('/{portfolio}/update', 'PortfolioController@update')->name('portfolio.update');
            Route::get('/{portfolio}/destroy', 'PortfolioController@destroy')->name('portfolio.destroy');

            Route::get('/gallery/{portfolio}', 'GalleryController@portfolioGallery')->name('portfolio.gallery');
            Route::post('/gallery/store', 'GalleryController@storeGallery')->name('portfolio.gallery.store');
            Route::post('/gallery/delete/{gallery}', 'GalleryController@deleteGallery')->name('portfolio.gallery.delete');
        });

//    Route::resource('comments', 'CommentsController')->except(['create', 'edit', 'update']);
//
//    Route::resource('blogs', 'BlogsController')->except(['show']);
//
//    Route::resource('profile', 'ProfileController')->except(['show']);
//
//    Route::resource('skills', 'SkillsController')->except(['show']);
//
//    Route::resource('experiences', 'ExperiencesController')->except(['show']);
//
//    Route::resource('educations', 'EducationsController')->except(['show']);
//
//    Route::resource('services', 'ServicesController')->except(['show']);
//
//    Route::resource('testimonials', 'TestimonialsController')->except(['show']);
//
//    Route::resource('contact-us', 'ContactUsController')->only(['index', 'show', 'destroy']);
//
//    Route::resource('categories', 'CategoriesController')->except(['show']);
//
//    Route::resource('portfolio', 'PortfolioController')->except(['show']);
//
//    Route::get('portfolio/gallery/{portfolio}', 'GalleryController@portfolioGallery')->name('portfolio.gallery');
//    Route::post('portfolio/gallery/store', 'GalleryController@storeGallery')->name('portfolio.gallery.store');
//    Route::post('portfolio/gallery/delete/{gallery}', 'GalleryController@deleteGallery')->name('portfolio.gallery.delete');


    });

});
