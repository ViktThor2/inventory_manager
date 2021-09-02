<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{ InvoicingController,};
use App\Http\Controllers\User\{ UserController, PermissionController, RoleController, };
use App\Http\Controllers\Company\{ CompanyController, PartnerController, };

use App\Http\Controllers\Invoice\{
    InvoiceController, InvoiceOutController, NavController, ProcessorController
};
use App\Http\Controllers\Textura\{
    VerzioController, TexturaInvoiceController, DatabaseController
};
use App\Http\Controllers\Revenue\{RevenueController, RevenueDbController, RevenueInvoiceController};



// Nav
Route::get('/invoiceIn', [NavController::class, 'invoiceIn'])->name('invoiceIn'); // KELL
Route::get('/invoiceInItem', [NavController::class, 'invoiceInItem'])->name('invoiceInItem');
Route::get('/invoiceOut', [NavController::class, 'invoiceOut'])->name('invoiceOut'); // KELL
Route::get('/invoiceOutItem', [NavController::class, 'invoiceOutItem'])->name('invoiceOutItem');


// Textura
Route::get('/textura/revenues', [DatabaseController::class, 'revenues'])->name('textura.revenues'); // KELL
Route::get('/textura/revenue/items', [DatabaseController::class, 'revenueItems'])->name('textura.revenue.items');
Route::get('/textura/revenue/items/new', [DatabaseController::class, 'newRevenueItems'])->name('textura.revenue.items.new');
Route::get('/textura/copy', [DatabaseController::class, 'copyAll'])->name('textura.copy');

//Route::get('/textura/new', [DatabaseController::class, 'dataNew'])->name('textura.new');
//Route::get('/textura/verzio', [DatabaseController::class, 'dataVerzio'])->name('textura.verzio');
//Route::get('/textura/verzio/revenueItems', [VerzioController::class, 'revenueItems'])->name('textura.verzio.revenue-items'); // Bevétlezés tételei
// Route::get('/textura/importer', [DatabaseController::class, 'importer'])->name('textura.importer');


// Bevételezések
Route::get('/revenue/create/invoice', [RevenueDbController::class, 'createInvoice'])->name('revenue.create.invoice');
Route::get('/revenue/create/items', [RevenueDbController::class, 'createItem'])->name('revenue.create.item');
Route::get('/revenue/create/textura/invoice', [RevenueDbController::class, 'texturaInvoice'])->name('revenue.create.textura.invoice');
Route::get('/revenue/create/textura/items', [RevenueDbController::class, 'texturaItems'])->name('revenue.create.textura.item');



Auth::routes(['verify' => true]);
Route::redirect('/', 'home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


use App\Http\Controllers\AdminController;


Route::get('/admin/customers-management', [AdminController::class, 'customers']);
Route::get('/admin/customers-management/{operation}', [AdminController::class, 'customers']);
Route::get('/admin/customers-management/{operation}/{id}', [AdminController::class, 'customers']);
Route::post('/admin/customers-management', [AdminController::class, 'customers']);
Route::post('/admin/customers-management/{operation}', [AdminController::class, 'customers']);
Route::post('/admin/customers-management/{operation}/{id}', [AdminController::class, 'customers']);


Route::middleware('auth')->group(function () {

    Route::resource('/user', UserController::class);
    Route::get('get-user', [UserController::class, 'getUser'])->name('get-user');

    Route::resource('/company', CompanyController::class);
    Route::get('get-company', [CompanyController::class, 'getCompany'])->name('get-company');

    Route::resource('/permission', PermissionController::class);
    Route::get('get-permission', [PermissionController::class, 'getPermission'])->name('get-permission');

    Route::resource('/role', RoleController::class);
    Route::get('get-role', [RoleController::class, 'getRole'])->name('get-role');

    Route::resource('/invoice', InvoiceController::class);
    Route::get('get-invoice', [InvoiceController::class, 'getInvoice'])->name('get-invoice');

    Route::resource('/invoiceout', InvoiceOutController::class);
    Route::get('get-invoice-out', [InvoiceOutController::class, 'getInvoiceOut'])->name('get-invoice-out');

    Route::resource('/partner', PartnerController::class);
    Route::get('get-importer', [PartnerController::class, 'getPartner'])->name('get-partner');

    Route::get('/processor', [ProcessorController::class, 'index'])->name('processor.index');

    Route::resource('/textura', TexturaInvoiceController::class);
    Route::get('get-textura', [TexturaInvoiceController::class, 'getTextura'])->name('get-textura');

    Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue');
    Route::get('/revenue/all', [RevenueController::class, 'all'])->name('revenue.all');
    Route::get('get-revenue', [RevenueController::class, 'getRevenue'])->name('get-revenue');
    Route::get('/revenue/{id}/show', [RevenueController::class, 'show'])->name('revenue.show');
    Route::put('/revenue/{id}/inStock', [RevenueController::class, 'inStock'])->name('revenue.inStock');

    Route::get('/revenue/invoice', [RevenueInvoiceController::class, 'index'])->name('revenue.invoice');
    Route::post('/revenue/invoice', [RevenueInvoiceController::class, 'index'])->name('revenue.invoice');
    Route::post('/revenue/revenue/search', [RevenueInvoiceController::class, 'search'])->name('revenue.revenue.search');

    Route::get('/invoicing', [InvoicingController::class, 'index'])->name('invoicing');
    Route::post('/invoicing', [InvoicingController::class, 'index'])->name('invoicing');
    Route::get('/invoicing/{id}', [InvoicingController::class, 'show'])->name('invoicing.show');
    Route::post('/invoicing/status/{id}', [InvoicingController::class, 'status'])->name('invoicing.status');
    Route::put('/invoicing/massStatus', [InvoicingController::class, 'massStatus'])->name('invoicing.massStatus');


});
