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

// CAMBIA EL CARGO DEL USUARIO
Route::post('/usuarios/cambiarCargo/{id}', 'UsuariosController@cambiarCargo')->name('/usuarios/cambiarCargo/{id}')->middleware('auth');

// RETORNA LA VISTA DEL MODAL CON LA INFORMACIÓN DEL CARGO VIGENTE DEL USUARIO
Route::post('/usuarios/detalleCargo/{id}', 'UsuariosController@cargo')->name('/usuarios/Cargo/{id}')->middleware('auth');

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
Route::get('/horasExtras', 'HorasExtrasController@index')->name('/horasExtras')->middleware('auth');

// RETORNA LA VISTA DE REGISTRO DE HORAS EXTRAS
Route::get('/horasExtras_registro', 'HorasExtrasController@registrar')->name('/horasExtras_registro')->middleware('auth');

// GUARDA LAS HORAS EXTRAS
Route::post('/horas/guardar/{id}', 'HorasExtrasController@guardar')->name('/horas/guardar')->middleware('auth');

// MUESTRA LA INFORMACIÓN DE LAS HORAS
Route::post('/horas/detalle/{id}', 'HorasExtrasController@detalle')->name('/horas/detalle/{id}')->middleware('auth');

// AUTORIZA LAS HORAS
Route::post('/horas/update/{id}', 'HorasExtrasController@update')->name('/horas/update/{id}')->middleware('auth');

// AUTORIZA LAS HORAS
Route::post('/horas/autorizar/{id}', 'HorasExtrasController@autorizar')->name('/horas/autorizar/{id}')->middleware('auth');


// ----------- MODULO CARGOS -------------------------------------

// RETORNA LA VISTA DE HORAS EXTRAS
Route::get('/cargos', 'CargosController@index')->name('/cargos')->middleware('auth');

// RETORNA LA VISTA DEL MODAL DE CARGOS
Route::post('/cargos/detalle/{id}', 'CargosController@detalle')->name('/cargos/detalle')->middleware('auth');

// ACTUALIZA CARGOS
Route::post('/cargos/update/{id}', 'CargosController@update')->name('/cargos/update')->middleware('auth');

// GUARDA EL CARGO
Route::post('/cargos/guardar/{id}', 'CargosController@save')->name('/cargos/save')->middleware('auth');


// ------------- MODULO DE REPORTES -------------------------------

// RETORNA LA VISTA DE GENERAR REPORTES
Route::get('/reportes', 'ReportesController@index')->name('/registrar/horas')->middleware('auth');

// DESCARGA EL REPORTE DE SOLICITUD AUTORIZACIÓN
Route::get('/reportes/solicitudAutorizacion', 'ReportesController@solicitudAutorizacion')->name('/reportes/solicitudAutorizacion/{id}')->middleware('auth');

// ----------- MODULO DE PRESUPUESTO -------------------------------------

// RETORNA LA VISTA DE PRESUPUESTO
Route::get('/presupuestos', 'PresupuestosController@index')->name('/presupuesto')->middleware('auth');

// GUARDA EL PRESUPUESTO
Route::post('/presupuesto/save/{id}', 'PresupuestosController@guardar')->name('/presupuestos/save/{id}')->middleware('auth');

// TABLA DE PRESUPUESTOS
Route::post('/presupuesto/tabla/{id}', 'PresupuestosController@horas')->name('/presupuestos/save/{id}')->middleware('auth');

// DETALLE DE PRESUPUESTOS
Route::post('/presupuesto/detalle/{id}', 'PresupuestosController@detalle')->name('/presupuestos/detalle/{id}')->middleware('auth');

// ------------- MODULO DE TIPO DE HORAS -------------------------------

// RETORNA LA VISTA DE TIPO DE HORAS
Route::get('/tipo_horas', 'TipoHorasController@index')->name('/tipo_horas')->middleware('auth');

// RETORNA EL MODAL DE TIPO DE HORAS
Route::post('/tipo_horas/detalle/{id}', 'TipoHorasController@detalle')->name('/tipo_horas/detalle/{id}')->middleware('auth');

// ACTUALIZA EL TIPO DE HORAS
Route::post('/tipo_horas/update/{id}', 'TipoHorasController@update')->name('/tipo_horas/update/{id}')->middleware('auth');

// ------------- MODULO DIÁS ESPECIALES -------------------------------

// RETORNA LA VISTA DE TIPO DE HORAS
Route::get('/fechas_especiales', 'FechasEspecialesController@index')->name('/fechas_especiales')->middleware('auth');

// RETORNA EL MODAL DE FECHA ESPECIAL
Route::post('/fechas_especiales/detalle/{id}', 'FechasEspecialesController@detalle')->name('/fechas_especiales/detalle/{id}')->middleware('auth');

// ACTUALIZA LA FECHA ESPECIAL
Route::post('/fechas_especiales/update/{id}', 'FechasEspecialesController@update')->name('/fechas_especiales/update/{id}')->middleware('auth');

// GUARDA LA FECHA ESPECIAL
Route::post('/fechas_especiales/save/{id}', 'FechasEspecialesController@save')->name('/fechas_especiales/save/{id}')->middleware('auth');


