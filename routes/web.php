<?php


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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');


Auth::routes(['register' => false]);


Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices_paid', 'InvoiceController@invoice_paid')->name('invoices.paid');
    Route::get('invoices_unpaid', 'InvoiceController@invoice_unpaid')->name('invoices.unpaid');
    Route::get('invoices_partial', 'InvoiceController@invoice_partial')->name('invoices.partial');
    Route::get('invoices_archives', 'InvoiceController@invoice_archive')->name('invoices.archive');
    Route::delete('invoices_archive/{id}', 'InvoiceController@archiveInvoice')->name('invoices.archiveInvoice');
    Route::post('invoices_restore/{id}', 'InvoiceController@restoreInvoice')->name('invoices.restoreInvoice');
    Route::get('invoices_status/{id}', 'InvoiceController@edit_status')->name('invoices.edit_status');
    Route::put('invoices_status/{id}', 'InvoiceController@update_status')->name('invoices.update_status');
    Route::get('print_invoice/{id}', 'InvoiceController@printInvoice')->name('invoices.print');
    Route::get('invoice_export', 'InvoiceController@export')->name('invoice_export');
    Route::get('section/{id}', 'InvoiceController@getProducts');


    //Sections
    Route::resource('sections', SectionController::class);
    //Products
    Route::resource('products', ProductController::class);
    //Invoices_Details
    Route::resource('invoiceDetails', InvoiceDetailsController::class);
    Route::get('download/{invoice_number}/{file_name}',  'InvoiceDetailsController@download')->name('download');
    //Invoices_Attachments
    Route::resource('invoiceAttachment', InvoiceAttachmentController::class);
    //Roles
    Route::resource('roles', 'RoleController');
    //Users
    Route::resource('users', 'UserController');


    //Invoice Reports
    Route::get('invoice_reports', 'InvoiceReportController@index')->name('invoice_reports');
    Route::post('invoice_reports', 'InvoiceReportController@search_invoice')->name('search_invoice');
    //Customer Reports
    Route::get('customer_reports', 'CustomerReportController@index')->name('customer_reports');
    Route::post('customer_reports', 'CustomerReportController@search_customer')->name('search_customer');
});

Route::get('/{page}', 'AdminController@index');