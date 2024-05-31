<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return view('auth.login');
});


//Auth::routes();
Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::resource('/invoices', InvoiceController::class);
//Route::resource('sections', SectionController::class);
//Route::resource('/products', ProductController::class);

Route::middleware(['auth'])->group(function () {
    Route::resource('/invoices', InvoiceController::class);
    Route::get('Invoice_Paid', [InvoiceController::class,'Invoice_Paid']);
    Route::get('Invoice_UnPaid', [InvoiceController::class,'Invoice_UnPaid']);
    Route::get('Invoice_Partial', [InvoiceController::class,'Invoice_Partial']);
    Route::get('edit_invoice/{id}', [InvoiceController::class,'edit']);
    Route::get('Print_invoice/{id}', [InvoiceController::class,'Print_invoice']);

    Route::resource('sections', SectionController::class);
    Route::get('section/{id}', [InvoiceController::class,'getProduct']);
    Route::get('/Status_show/{id}', [InvoiceController::class,'show'])->name('Status_show');
    Route::post('/Status_Update/{id}', [InvoiceController::class,'Status_Update'])->name('Status_Update');
    Route::get('export_invoices', [InvoiceController::class,'export']);

    Route::resource('/products', ProductController::class);
    Route::resource('Archive', \App\Http\Controllers\InvoiceArchiveController::class);

});
Route::get('InvoicesDetails/{id}', [\App\Http\Controllers\InvoicesDetailsController::class,'edit']);
Route::get('download/{invoice_number}/{file_name}', [\App\Http\Controllers\InvoicesDetailsController::class,'get_file']);
Route::get('View_file/{invoice_number}/{file_name}', [\App\Http\Controllers\InvoicesDetailsController::class,'open_file']);
Route::post('delete_file', [\App\Http\Controllers\InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::resource('InvoiceAttachments', \App\Http\Controllers\InvoicesAttachmentsController::class);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles',\App\Http\Controllers\RoleController::class);
    Route::resource('users',\App\Http\Controllers\UserController::class);
});

Route::get('invoices_report', [InvoicesReportController::class,'index']);
Route::post('Search_invoices', [InvoicesReportController::class,'Search_invoices']);

//Route::get('invoices_report', 'Invoices_Report@index');
//Route::post('Search_invoices', 'InvoicesReportController@Search_invoices');

Route::get('customers_report', [CustomersReportController::class,'index'])->name("customers_report");
Route::post('Search_customers', [CustomersReportController::class,'Search_customers']);

//Route::get('customers_report', 'CustomersReportController@index')->name("customers_report");
//Route::post('Search_customers', 'CustomersReportController@Search_customers');


//Route::get('download/{invoice_number}/{file_name}', 'InvoicesDetailsController@get_file');
//Route::get('View_file/{invoice_number}/{file_name}', 'InvoicesDetailsController@open_file');


Route::get('MarkAsRead_all',[InvoiceController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');

Route::get('unreadNotifications_count', [InvoiceController::class,'unreadNotifications_count'])->name('unreadNotifications_count');

Route::get('unreadNotifications', [InvoiceController::class,'unreadNotifications'])->name('unreadNotifications');

Route::get("/{page}",[AdminController::class,'index']);


