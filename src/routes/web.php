<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CsvDownloadController;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

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

// 入力画面（PG01）
Route::get('/', [ContactController::class, 'index'])->name('rewrite');

// 確認画面（PG02）
Route::post('/confirm', [ContactController::class, 'confirm']);

// 保存 → サンクス（PG03）
Route::post('/store', [ContactController::class, 'store']);
Route::get('/thanks', function () {
    return view('thanks');
});

// 管理画面（PG04）
Route::get('/admin', [ContactController::class, 'admin']);

// 検索（PG05）
Route::get('/search', [ContactController::class, 'search']);

// 検索リセット（PG06）
Route::get('/reset', [ContactController::class, 'reset']);

// 削除（PG07）
Route::post('/delete', [ContactController::class, 'delete']);

// ユーザ登録（PG08）
Route::get('/register', [AuthController::class, 'registerView']);

// ログイン（PG09）
Route::get('/login', [AuthController::class, 'loginView']);

// エクスポート（PG11）
Route::get('/export', [CsvDownloadController::class, 'downloadCsv']);