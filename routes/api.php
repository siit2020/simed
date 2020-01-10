<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('pacientes/movil', 'PacientesController@addmovil')->name('pacientes.movil');




/* Route::get('pacientes', function(){
     return datatables()
    ->eloquent(App\Paciente::query())
    ->addColumn('nacimiento', function($row) {
        return "{$row->age}";
     })
    ->addColumn('btn','pacientes.actions')
    ->rawColumns(['btn'])
    ->toJson();
});

 Route::get('listaPacientes', function(){
    return datatables()
    ->eloquent(App\Paciente::query())
    ->addColumn('nacimiento', function($row){
        return "{$row->age}";
    })
    ->addColumn('btn', 'pacientes.actionsSecretaria')
    ->rawColumns(['btn'])
    ->toJson();
}); */

