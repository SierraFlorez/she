<?php
/*
|--------------------------------------------------------------------------
| RUTAS PUBLICAS
|--------------------------------------------------------------------------
|
*/

// RETORNA VISTA DEL INICIO
Route::get('/inicio', 'HomeController@index')->name('/inicio');
Route::get('/home', 'HomeController@index')->name('/home');
Route::get('/', 'HomeController@index')->name('/');


/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS
|--------------------------------------------------------------------------
|
*/
Auth::routes();


// ----------- MODULO USUARIO -----------------------------------------

// RETORNA LA VISTA DE CONSULTAR USUARIOS
Route::get('/usuarios', 'UsuariosController@index')->name('/usuarios')->middleware('auth');

// RETORNA LA VISTA DEL MODAL CON LA INFORMACIÓN DEL USUARIO
Route::post('/usuarios/detalle/{id}', 'UsuariosController@detalle')->name('/usuarios/detalle/{id}')->middleware('auth');

// ACTUALIZA LA INFORMACIÓN DEL USUARIO
Route::post('/usuarios/actualizar/{id}', 'UsuariosController@update')->name('/usuarios/update/{id}')->middleware('auth');

// CAMBIA EL ESTADO DEL USUARIO A ACTIVO
Route::post('/usuarios/activar/{id}', 'UsuariosController@activar')->name('/usuarios/activar/{id}')->middleware('auth');

// CAMBIA EL ESTADO DEL USUARIO A INACTIVO
Route::post('/usuarios/inactivar/{id}', 'UsuariosController@inactivar')->name('/usuarios/inactivar/{id}')->middleware('auth');

// RETORNA LA VISTA DE REGISTRAR USUARIOS
Route::get('/registrar', 'UsuariosController@registrar')->name('/registrar')->middleware('auth');

// RETORNA MODAL PARA REGISTRAR USUARIO
Route::post('/registrar/nuevo', 'UsuariosController@nuevoUsuario')->name('/registrar/nuevo')->middleware('auth');

// GUARDA LA INFORMACIÓN DEL MODAL EN LA BASE DE DATOS
Route::post('/registrar/guardar/{id}', 'UsuariosController@save')->name('/registrar/guardar')->middleware('auth');

// CAMBIA LA CONTRASEÑA DEL USUARIO QUE HAYA INICIADO SESIÓN
Route::post('/passreset/{id}', 'UsuariosController@cambiar_password')->name('/registrar/guardar')->middleware('auth');


// ----------- MODULO HORAS EXTRAS -------------------------------------

// RETORNA LA VISTA DE HORAS EXTRAS DEL USUARIO
Route::get('/horasExtras', 'horasExtrasController@index')->name('/horasExtras')->middleware('auth');

// RETORNA LA VISTA DE REGISTRO DE HORAS EXTRAS
Route::get('/registrar/horasExtras', 'horasExtrasController@registrar')->name('/registrar/horas')->middleware('auth');

// GUARDA LAS HORAS EXTRAS
Route::post('/registrar/horas/guardar/{id}', 'horasExtrasController@guardar')->name('/horas/guardar')->middleware('auth');


// ----------- MODULO CARGOS -------------------------------------

// RETORNA LA VISTA DE HORAS EXTRAS
Route::get('/cargos', 'CargosController@index')->name('/cargos')->middleware('auth');

// RETORNA LA VISTA DEL MODAL DE CARGOS
Route::post('/cargos/detalle/{id}', 'CargosController@detalle')->name('/cargos/detalle')->middleware('auth');

// ACTUALIZA CARGOS
Route::post('/cargos/update/{id}', 'CargosController@update')->name('/cargos/update')->middleware('auth');

// GUARDA EL CARGO
Route::post('/cargos/guardar/{id}', 'CargosController@save')->name('/cargos/save')->middleware('auth');



