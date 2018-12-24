<?php

/*
|--------------------------------------------------------------------------
| AUTH STUFF
|--------------------------------------------------------------------------
*/

Route::get('afterLogin', 'Auth\AuthController@afterLogin');



Route::get('cfg', 'ConfigController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('login/facebook', 'Auth\AuthController@loginViaFacebook');
Route::get('login/google', 'Auth\AuthController@loginViaGoogle');
Route::get('login/persistFacebook', 'Auth\AuthController@persistFacebook');


Route::group(
	[
//		'prefix'     => LaravelLocalization::setLocale(),
//		'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]
	], function () {

	Route::get('auth/login/', 'Auth\AuthController@getLogin');
	Route::get('auth/register/', 'Auth\AuthController@getRegister');

	Route::get('password/email/', 'Auth\PasswordController@getEmail');
	Route::get('password/reset/', 'Auth\PasswordController@getReset');


}
);


//TODO Divide routes to /api/dashboard/messages/ and /api/public/messages and /api/profile/messages. Same thing with controller structure

/*
|--------------------------------------------------------------------------
| DASHBOARD API
|--------------------------------------------------------------------------
*/
Route::group(
	[
		'prefix'     => 'api',
		'middleware' => ['auth', 'dashboard']
	], function () {

	Route::put('landing/updateAllLangs/{id}', 'Api\LandingPagesController@updateAllLangs');
	Route::get('landing/listByParent/{parentId}/{section}', 'Api\LandingPagesController@listByParent');
	Route::get('landing/editByToken/{token}', 'Api\LandingPagesController@editByToken');

	Route::get('landing/getByTokenAndSection/{token}/{section}', 'Api\LandingPagesController@getByTokenAndSection');

	Route::resource('landing', 'Api\LandingPagesController');
	Route::get('landing/create/{section}', 'Api\LandingPagesController@create');


	// Settings
	Route::post('settings/updateAll', 'Api\SettingController@updateAll');
	Route::resource('settings', 'Api\SettingController');

	// Users
	Route::post('users/changePassword/{id}', 'Api\UsersController@changePassword');
	Route::resource('users', 'Api\UsersController');


	/*
	|--------------------------------------------------------------------------
	| SAMPLE UNCOMMENT TO WORK
	|--------------------------------------------------------------------------
	*/
	//RECIPES
//	Route::get('recipes/category/{id}', 'Api\Dashboard\RecipesController@category');
//	Route::post('recipes', 'Api\Dashboard\RecipesController@store');
//	Route::put('recipes/{id}', 'Api\Dashboard\RecipesController@update');
//	Route::get('recipes/{id}/edit', 'Api\Dashboard\RecipesController@edit');
//	Route::delete('recipes/{id}', 'Api\Dashboard\RecipesController@delete');


}
);

/*
|--------------------------------------------------------------------------
| COMMON API
|--------------------------------------------------------------------------
*/
Route::group(
	[
		'prefix' => 'api/common'
	], function () {
	Route::get('files/getAllInfoForUploader', 'Api\Common\FilesController@getAllInfoForUploader');
	Route::resource('files', 'Api\Common\FilesController');
	Route::delete('files/forceDelete/{token}', 'Api\Common\FilesController@forceDelete');
});

/*
|--------------------------------------------------------------------------
| API WITH AUTHENTICATION
|
*/
Route::group(
	[
		'prefix' => 'api',
		'middleware' => ['auth']
	], function() {
	//SOME SAMPLE ROUTES

//		Route::put('cards/setDefaultCard', 'Api\CardsController@setDefaultCard');
//		Route::resource('cards', 'Api\CardsController');
//		Route::get('messages/dialog/{quoteId}', 'Api\MessagesController@dialog');
//		Route::get('messages/newCount', 'Api\MessagesController@getNewCount');
//		Route::resource('messages', 'Api\MessagesController');

}
);

/*
|--------------------------------------------------------------------------
| API MIXED CALLS. WITH AUTH AND NOT
|--------------------------------------------------------------------------
*/

Route::group([
	'prefix' => 'api/auth'
], function() {
	Route::get('profile', 'Api\Auth\ProfileController@index');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD ANGULAR FIX
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', ['middleware' => [ 'auth', 'dashboard'], 'uses' => 'Dashboard\DashboardController@index']);
Route::get('/dashboard/{one?}/{two?}/{three?}/{four?}/{five?}', ['middleware' => [ 'auth', 'dashboard'], 'uses' => 'Dashboard\DashboardController@index']);

/*
|--------------------------------------------------------------------------
| OTHER SPECIAL ROUTES
|--------------------------------------------------------------------------
*/

Route::get('download/{token}', 'FilesController@download');

//Set language
//Route::get('/setLang/{lang}', function($lang)
//{
//	Session::put('lang', $lang);
//	return redirect()->back();
//});









/*
|--------------------------------------------------------------------------
| SAMPLE UNCOMMENT TO WORK
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| NEW ROUTES
|--------------------------------------------------------------------------
*/

//Route::get('/', 'PagesController@home');
//Route::get('/about', 'PagesController@about');
//Route::get('/content', 'PagesController@content');
//Route::get('/technology', 'PagesController@technology');
//Route::get('/contact', 'PagesController@contact');
//
//Route::post('/contact', 'PagesController@postContact');

//Services
//Route::post('/subscribe', 'ServicesController@storeSubscription');
//Route::post('/contact', 'ServicesController@storeContact');
//Route::post('/comment', 'ServicesController@storeComment');
//Route::get('/captcha', 'ServicesController@captcha');

//RECIPES
//Route::get('recipes/category/{id}', 'Api\Dashboard\RecipesController@category');
//Route::post('recipes', 'Api\Dashboard\RecipesController@store');
//Route::put('recipes/{id}', 'Api\Dashboard\RecipesController@update');
//Route::get('recipes/{id}/edit', 'Api\Dashboard\RecipesController@edit');
