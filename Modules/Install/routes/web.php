<?php



use Illuminate\Support\Facades\Route;
use Modules\Install\App\Http\Controllers\InstallController;

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

Route::group([], static function (): void {
    Route::resource('install', InstallController::class)->names('install');
});
