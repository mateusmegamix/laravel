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
Route::any('products/search', 'ProductController@search')->name('product.search');
Route::resource('products', 'ProductController');//->middleware('auth'); 

/*
Route::delete('products/{id}', 'ProductController@destroy')->name('products.destroy');
Route::put('products/{id}', 'ProductController@update')->name('products.update');
Route::post('products', 'ProductController@store')->name('products.store');
Route::get('products/{id}/edit', 'ProductController@edit')->name('products.edit');
Route::get('products/create', 'ProductController@create')->name('Products.create');
Route::get('products/{id}', 'ProductController@show')->name('products.show');
Route::get('products', 'ProductController@index')->name('products.index');
*/

////////////////////////////////
Route::get('/login', function(){
    return 'Login';
})->name('login');


/*
Route::middleware([])->group(function () {

        Route::prefix('admin')->group(function () {

                Route::namespace('Admin')->group(function(){

                    Route::name('admin.')->group(function (){
                        Route::get('/dashboard', 'TesteConstroller@teste')->name('dashboard');

                        Route::get('/financeiro', 'TesteConstroller@teste')->name('financeiro');

                        Route::get('/produtos', 'TesteConstroller@teste')->name('produtos');

                        Route::get('/', function(){
                            return redirect()->route('admin.dashboard');
                })->name('home');
            });
        });
    });
});
*/

Route::group([
    'middleware' => [],
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'name' => 'admin'
], function (){
    Route::get('/dashboard', 'TesteConstroller@teste')->name('dashboard');

    Route::get('/financeiro', 'TesteConstroller@teste')->name('financeiro');

    Route::get('/produtos', 'TesteConstroller@teste')->name('produtos');

    Route::get('/', function(){
        return redirect()->route('admin.dashboard');
})->name('home');
});

///////////
Route::get('redirect3', function(){
    return redirect()->route('url.name');
});

Route::get('/name-url', function(){
    return 'Hey hey hey';
})->name('url.name');
//////////////

Route::view('/view', 'welcome');

Route::redirect('/redirect1', '/redirect2');

// Route::get('redirect1', function(){
//     return redirect('/redirect2');
// });

Route::get('redirect2', function(){
    return 'redirect 02';
});
///////////////

Route::get('/produtos/{idProdut?}/details', function ($idProduct = ''){
    return "Produtos(s): {$idProduct}";
});

Route::get('/categorias/{flag}', function($flag){
    return "Produtos da categoria: {$flag}";
});

Route::match(['get', 'post'],'/match', function(){
    return 'match';
});

Route::any('/any', function(){
    return 'Any';
});

Route::post('/register', function(){
    return '';
});

Route::get('/empresa', function(){
    return view('site.contact');
});

Route::get('/contato', function(){
    return 'Contato';
});
Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);
