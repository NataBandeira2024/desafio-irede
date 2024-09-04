<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('produtos', ProdutoController::class);
Route::get('/categorias', [CategoriaController::class, 'index']);

Route::get('imagem/imagens/{filename}', function ($filename) {
    $path = storage_path('app/public/imagens/' . $filename);

    if (!File::exists($path)) {
        abort(404, 'Imagem não encontrada.');
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
