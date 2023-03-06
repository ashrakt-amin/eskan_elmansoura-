<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PrivilegeController;
use App\Http\Controllers\FormFilterController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\MainProjectController;
use App\Http\Controllers\ManagerFundController;
use App\Http\Controllers\PaymentKindController;
use App\Http\Controllers\SubPropertyController;
use App\Http\Controllers\ConstructionController;
use App\Http\Controllers\UnitStatusDateController;
use App\Http\Controllers\FinancePercentageController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\OverMuchUnitController;
use App\Models\OverMuchUnit;

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

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/hi', function () {
    return view('EnterpriseIndex');
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/dash', function () {
    return view('my_dashboard.index');
});

Auth::routes();

// Route::get('/index', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post("/logout",[LogoutController::class, "store"])->name("logout");

Route::controller(AdminController::class)->group(function () {
    Route::get('/index', 'index')->name('index');
    Route::get('/main/new', 'new')->name('main/new');
    Route::get('/main/filter/{propertyId}/{constructionId}', 'filter')->name('mainPropertiesFilter');
    Route::get('/main/allPaymentsFilter/', 'allPaymentsFilter')->name('allPaymentsFilter');
});


                // UserController start
                // UserController start
                // UserController start
Route::prefix("users")->group(function(){
    Route::controller(UserController::class)->group(function () {
        Route::get('/',            'index')->name('users.index');
        Route::get('/create',     'create')->name('users.create');
        Route::post('/',           'store')->name('users.store');
        Route::get('/{user}/edit',  'edit')->name('users.edit');
        Route::put('/{user}',     'update')->name('users.update');
        Route::delete('/{user}', 'destroy')->name('users.destroy');
        Route::get('/{user}',       'show')->name('users.show');
    });
});

                // UserController end
                // UserController end
                // UserController end


                // PrivilegeController start
                // PrivilegeController start
                // PrivilegeController start
Route::prefix("privileges")->group(function(){
    Route::controller(PrivilegeController::class)->group(function () {
        Route::get('/',                  'index')->name('privileges.index');
        Route::get('/create',           'create')->name('privileges.create');
        Route::post('/',                 'store')->name('privileges.store');
        Route::get('/{privilege}/edit',   'edit')->name('privileges.edit');
        Route::put('/{privilege}',      'update')->name('privileges.update');
        Route::delete('/{privilege}',  'destroy')->name('privileges.destroy');
        // Route::get('/{privilege}',        'show')->name('privileges.show');
    });
});

                // PrivilegeController end
                // PrivilegeController end
                // PrivilegeController end



                // ManagerController start
                // ManagerController start
                // ManagerController start
Route::prefix("manager")->group(function(){
    Route::controller(ManagerController::class)->group(function () {
        Route::get('/',                'index')->name('manager.index');
        Route::get('/create',         'create')->name('manager.create');
        Route::post('/',               'store')->name('manager.store');
        Route::get('/{manager}/edit',   'edit')->name('manager.edit');
        Route::put('/{manager}',      'update')->name('manager.update');
        Route::delete('/{manager}',  'destroy')->name('manager.destroy');
        Route::get('/{manager}',        'show')->name('manager.show');
    });
});
                // ManagerController end
                // ManagerController end
                // ManagerController end


                // ManagerFundController start
                // ManagerFundController start
                // ManagerFundController start
Route::controller(ManagerFundController::class)->group(function () {
    Route::get('/managerFundIndex',       'index')->name('managerFundIndex');
    Route::get('/addManagerFund',         'create')->name('addManagerFund');
    Route::post('/insertManagerFund',      'store')->name('insertManagerFund');
    Route::get('/searchManagerFund/{id}', 'search')->name('searchManagerFund');
    Route::get('/searchByAll',       'searchByAll')->name('searchByAll');
    Route::get('/editManagerFund/{id}',     'edit')->name('editManagerFund');
    // Route::put('updateManagerFund/{id}',  'update')->name('updateManagerFund');
    Route::get('/showManagerFund/{id}',     'show')->name('showManagerFund');
});
// Route::put('/updateManagerFund', [App\Http\Controllers\ManagerFundController::class, 'update'])->name('updateManagerFund');
// Route::get('/addManagerFund', [App\Http\Controllers\ManagerFundController::class, 'index'])->name('addManagerFund');

                // ManagerFundController end
                // ManagerFundController end
                // ManagerFundController end



                // CustomerController start
                // CustomerController start
                // CustomerController start
Route::controller(CustomerController::class)->group(function () {
    Route::get('/customerIndex',       'index')->name('customerIndex');
    Route::get('/addCustomer',        'create')->name('addCustomer');
    Route::post('/insertCustomer',     'store')->name('insertCustomer');
    Route::get('/editCustomer/{id}',    'edit')->name('editCustomer');
    Route::put('updateCustomer/{id}', 'update')->name('updateCustomer');
    Route::get('/customerShow/{id}',    'show')->name('customerShow');
    Route::post('/customers.search/', 'search')->name('customers.search');
});
                // CustomerController end
                // CustomerController end
                // CustomerController end


                // ConstructionController start
                // ConstructionController start
                // ConstructionController start
Route::controller(ConstructionController::class)->group(function () {
    Route::get('/constructionsIndex', 'index')->name('constructionsIndex');
    Route::get('/addConstruction', 'create')->name('addConstruction');
    Route::post('/insertConstruction', 'store')->name('insertConstruction');
    Route::get('/addConstructions', 'createConstructionsRows')->name('addConstructions');
    Route::post('/insertMultipleConstructions', 'storeMultipleConstructions')->name('insertMultipleConstructions');
    Route::get('/showConstruction/{id}', 'show')->name('showConstruction');
    Route::get('/searchConstruction/{id}/', 'search')->name('searchConstruction');
    Route::get('/editConstruction/{id}', 'edit')->name('editConstruction');
    Route::put('updateConstruction/{id}', 'update')->name('updateConstruction');
    Route::delete('constructions/{id}', 'destroy')->name('constructions.destroy');
});
                // ConstructionController end
                // ConstructionController end
                // ConstructionController end


                // PropertyController start
                // PropertyController start
                // PropertyController start
Route::controller(PropertyController::class)->group(function () {
    Route::get('/propertiesIndex',      'index')->name('propertiesIndex');
    Route::get('/addProperty',         'create')->name('addProperty');
    Route::get('/showProperties/{id}',   'show')->name('showProperties');
    Route::post('/insertProperty',      'store')->name('insertProperty');
    Route::get('/editProperty/{id}',     'edit')->name('editProperty');
    Route::put('updateProperty/{id}',  'update')->name('updateProperty');
    Route::get('deleteProperty/{id}', 'destroy')->name('deleteProperty');
    // Route::get('/searchProperties/{id}/{main_project}',   'search')->name('searchProperties');
});
Route::get('/showProperties/{id}', [App\Http\Controllers\PropertyController::class, 'show'])->name('showProperties');
Route::get('/searchProperties/{id}/{main_project}', [App\Http\Controllers\PropertyController::class, 'search'])->name('searchProperties');
                // PropertyController end
                // PropertyController end
                // PropertyController end


                // SubPropertyController start
                // SubPropertyController start
                // SubPropertyController start
Route::prefix("subProperties")->group(function(){
    Route::controller(SubPropertyController::class)->group(function () {
        Route::get('/',                   'index')->name('subProperties.index');
        Route::get('/create',            'create')->name('subProperties.create');
        Route::post('/',                  'store')->name('subProperties.store');
        Route::get('/{subProperty}',       'show')->name('subProperties.show');
        Route::get('/search',            'search')->name('subProperties.search');
        Route::get('/{subProperty}/edit',  'edit')->name('subProperties.edit');
        Route::put('/{subProperty}',     'update')->name('subProperties.update');
        Route::delete('/{subProperty}', 'destroy')->name('subProperties.destroy');
    });
});
                // SubPropertyController end
                // SubPropertyController end
                // SubPropertyController end


                // MainProjectcoController start
                // MainProjectcoController start
                // MainProjectcoController start
Route::controller(MainProjectController::class)->group(function () {
    Route::get('/main_projectsIndex',    'index')->name('main_projectsIndex');
    Route::get('/add_main_project',     'create')->name('add_main_project');
    Route::post('/insert_main_project',  'store')->name('insert_main_project');
    Route::get('/show_main_project/{id}', 'show')->name('show_main_project');
    Route::get('/search_main_project/{id}', 'search')->name('search_main_project');
    Route::get('/edit_main_project/{id}', 'edit')->name('edit_main_project');
    Route::put('update_main_project/{id}', 'update')->name('update_main_project');
    Route::get('/show_main_project/{id}', 'show')->name('show_main_project');
    Route::get('mainProject/delete/{id}', 'destroy')->name('mainProject.delete');
});
                // MainProjectcoController end
                // MainProjectcoController end
                // MainProjectcoController end


                // LevelController start
                // LevelController start
                // LevelController start
Route::controller(LevelController::class)->group(function () {
    Route::get('/levelsIndex',                     'index')->name('levelsIndex');
    // Route::get('/showLevel/{id}/{constructions}', 'showLevel')->name('showLevel');
    Route::get('/singleLevel/{id}/{constructionId}', 'show')->name('levels.show');
    Route::get('/levels/{construction_id}',        'search')->name('levels.search');
    Route::get('/singleLevel',                      'show2')->name('levels.show2');
    Route::get('/addLevel',                        'create')->name('addLevel');
    Route::post('/insertLevel',                     'store')->name('insertLevel');
    Route::get('/editLevel/{id}',                    'edit')->name('editLevel');
    Route::put('updateLevel/{id}',                 'update')->name('updateLevel');
    Route::get('/level/delete/{id}',              'destroy')->name('level/delete');
});
Route::get('/showLevel{id}/{constructions}', [App\Http\Controllers\LevelController::class, 'showLevel'])->name('showLevel');

// Route::get('/showLevel/{id}'         , 'LevelController@showLevel');
Route::get('showLevel/{id}/{constructions}'  , [LevelController::class, 'showLevel']);
                // LevelController end
                // LevelController end
                // LevelController end


                // SiteController start
                // SiteController start
                // SiteController start
Route::controller(SiteController::class)->group(function () {
    Route::get('/sites/',                  'index')->name('sites.index');
    Route::get('/sites/create',           'create')->name('sites.create');
    Route::post('/sites/',                 'store')->name('sites.store');
    Route::get('/sites/{id}/edit',          'edit')->name('sites.edit');
    Route::put('/sites/{id}',             'update')->name('sites.update');
    Route::delete('/sites/destroy/{id}', 'destroy')->name('sites.destroy');
});
                // SiteController end
                // SiteController end
                // SiteController end


                // UnitController start
                // UnitController start
                // UnitController start
Route::controller(UnitController::class)->group(function () {
    Route::get('/unitsIndex', 'index')->name('unitsIndex');
    Route::get('/addUnit', 'create')->name('addUnit');
    Route::get('/addUnitTest', 'create')->name('addUnitTest');
    Route::get('/createUnitCustom', 'createUnitCustom')->name('createUnitCustom');
    Route::post('/insertUnit', 'store')->name('insertUnit');
    Route::post('/unitMultipleStore', 'unitMultipleStore')->name('unitMultipleStore');
    Route::get('/editUnit/{id}', 'edit')->name('editUnit');
    Route::put('updateUnit/{id}', 'update')->name('updateUnit');
    Route::put('firstUnitPayment{id}', 'firstUnitPayment')->name('firstUnitPayment');
    Route::get('/editUnitStatus/{id}', 'editUnitStatus')->name('editUnitStatus');
    Route::put('/updateUnitStatus/{id}', 'updateUnitStatus')->name('updateUnitStatus');
    Route::get('deleteUnit/{id}', 'destroy')->name('unit.destroy');
    Route::get('/unitShow/{id}', 'show')->name('unitShow');
    Route::put('/units/{id}', 'addFinanceIdOrInstallments')->name('addFinanceIdOrInstallments');
    Route::get('units/{id}', 'search')->name('units.search');
    // Route::put('/units/{id}', 'addUnitInstallments')->name('addUnitInstallments');
});
Route::get('/editUnitStatus/{id}', [App\Http\Controllers\UnitController::class, 'editUnitStatus'])->name('editUnitStatus');
// Route::Put('/units/{id}', [App\Http\Controllers\UnitController::class, 'updateUnitStatus'])->name('updateUnitStatus');
Route::get('/cancellationUnits/{id}', [App\Http\Controllers\UnitController::class, 'cancel'])->name('cancellationUnits');

                // UnitController end
                // UnitController end
                // UnitController end


                // FinanceController start
                // FinanceController start
                // FinanceController start
Route::controller(FinanceController::class)->group(function () {
    Route::get('/financesIndex', 'index')->name('financesIndex');
    Route::get('/addFinance', 'create')->name('addFinance');
    Route::post('/insertFinance', 'store')->name('insertFinance');
    Route::get('/financeShow/{id}', 'show')->name('financeShow');
    Route::get('/editFinance/{id}', 'edit')->name('editFinance');
    Route::put('updateFinance{id}', 'update')->name('updatFinance');
    Route::get('deleteFinance/{id}', 'destroy');
});
Route::Put('/updateFinance/{id}', [App\Http\Controllers\FinanceController::class, 'update'])->name('updateFinance');

                // FinanceController end
                // FinanceController end
                // FinanceController end


                // paymentController start
                // paymentController start
                // paymentController start
Route::controller(PaymentController::class)->group(function () {
    Route::get('/paymentsIndex', 'index')->name('paymentsIndex');
    Route::get('/addPayment', 'create')->name('addPayment');
    // Route::get('/addUnitPayment/{id}', 'createUnitPayment')->name('addUnitPayment');
    Route::post('/insertPayment', 'store')->name('insertPayment');
    // Route::post('/insertUnitPayment', 'storeUnitPayment')->name('insertUnitPayment');
    Route::get('/unitPayment/{id}', 'show')->name('unitPayment');
    Route::get('/editPayment/{id}', 'edit')->name('editPayment');
    // Route::put('updatePayment/{payment}', 'update')->name('updatPayment');
    Route::get('deletePayment/{payment}', 'destroy')->name('payment.destroy');
    Route::get('payments/{day}', 'search')->name('payments.search');
});
Route::get('/addUnitPayment/{id}', [App\Http\Controllers\PaymentController::class, 'createUnitPayment'])->name('addUnitPayment');
Route::post('/insertUnitPayment', [App\Http\Controllers\PaymentController::class, 'newPaymentFunction'])->name('insertUnitPayment');
Route::put('/updatePayment/{payment}', [App\Http\Controllers\PaymentController::class, 'update'])->name('updatePayment');

                // paymentController end
                // paymentController end
                // paymentController end


                // paymentController start
                // paymentController start
                // paymentController start
Route::controller(PaymentKindController::class)->group(function () {
    Route::get('/paymentKindsIndex', 'index')->name('paymentKindsIndex');
    Route::get('/addPaymentKind', 'create')->name('addPaymentKind');
    Route::post('/insertPaymentKind', 'store')->name('insertPaymentKind');
    Route::get('/editPaymentKind/{id}', 'edit')->name('editPaymentKind');
    Route::put('/updatePaymentKind/{id}', 'update')->name('updatePaymentKind');
    Route::get('/deletePaymentKind/{id}', 'destroy')->name('deletePaymentKind');

});
Route::put('/updatePaymentKind/{id}', [App\Http\Controllers\PaymentKindController::class, 'update'])->name('updatePaymentKind');
Route::get('/deletePaymentKind/{id}', [App\Http\Controllers\PaymentKindController::class, 'destroy'])->name('deletePaymentKind');


                // paymentController end
                // paymentController end
                // paymentController end



                // InstallmentController start
                // InstallmentController start
                // InstallmentController start
Route::controller(InstallmentController::class)->group(function () {
    Route::get('/installmentsIndex', 'index')->name('installmentsIndex');
    Route::get('/addInstallment', 'create')->name('addInstallment');
    Route::get('/existsInstallmentMonth', 'existsInstallmentMonth')->name('existsInstallmentMonth');
    Route::post('/insertInstallment', 'store')->name('insertInstallment');
    Route::get('/unitInstallment/{id}', 'show')->name('unitInstallment');
    Route::get('/editInstallment/{id}', 'edit')->name('editInstallment');
    // Route::put('updateInstallment{id}', 'update')->name('updateInstallment');
    Route::get('deleteInstallment/{installment}', 'destroy')->name('deleteInstallment');
});
Route::put('/updateInstallment/{id}', [App\Http\Controllers\InstallmentController::class, 'update'])->name('updateInstallment');

                // paymentController end
                // paymentController end
                // paymentController end



                // UnitStatusDateController start
                // UnitStatusDateController start
                // UnitStatusDateController start
Route::controller(UnitStatusDateController::class)->group(function () {
    // Route::put('updateInstallment{id}', 'update')->name('updatInstallment');
});
                // UnitStatusDateController end
                // UnitStatusDateController end
                // UnitStatusDateController end



                // FinancePercentageController start
                // FinancePercentageController start
                // FinancePercentageController start
Route::controller(FinancePercentageController::class)->group(function () {
    Route::get('/financePercentages/index', 'index')->name('financePercentages.index');
    Route::get('/financePercentages/add', 'create')->name('financePercentages.create');
    Route::post('/financePercentages/insert', 'store')->name('financePercentages.insert');
    Route::get('/financePercentages/show/{id}', 'show')->name('financePercentages.show');
    Route::get('/financePercentages/edit/{id}', 'edit')->name('financePercentages.edit');
    Route::put('financePercentages/update/{id}', 'update')->name('financePercentages.update');
    Route::get('financePercentages/delete/{id}/', 'destroy')->name('financePercentages.delete');
});
Route::put('/financePercentages/update/{id}', [App\Http\Controllers\FinancePercentageController::class, 'update'])->name('financePercentages/update');
                // FinancePercentageController end
                // FinancePercentageController end
                // FinancePercentageController end


                // BalanceController start
                // BalanceController start
                // BalanceController start
Route::prefix("balances")->group(function(){
    Route::controller(BalanceController::class)->group(function () {
        Route::get('/{mainProject}',        'index')->name('balances.index');
        Route::get('/{mainProject}/create', 'create')->name('balances.create');
        Route::post('/',                     'store')->name('balances.store');
        Route::get('/{balance}',              'show')->name('balances.show');
        Route::get('/search',               'search')->name('balances.search');
        Route::get('/{balance}/edit',         'edit')->name('balances.edit');
        Route::put('/{balance}',            'update')->name('balances.update');
        Route::delete('/{balance}',        'destroy')->name('balances.destroy');
    });
});
                // BalanceController end
                // BalanceController end
                // BalanceController end


                // FormFilterController start
                // FormFilterController start
                // FormFilterController start
Route::prefix("form_filters")->group(function(){
    Route::controller(FormFilterController::class)->group(function () {
        // Route::get('/{mainProject}',        'index')->name('form_filters.index');
        // Route::get('/{mainProject}/create', 'create')->name('form_filters.create');
        // Route::post('/',                     'store')->name('form_filters.store');
        // Route::get('/{balance}',              'show')->name('form_filters.show');
        Route::get('/cashFilter',            'cashFilter')->name('form_filters.cashFilter');
        Route::get('/statusFilter',        'statusFilter')->name('form_filters.statusFilter');
        // Route::get('/{balance}/edit',         'edit')->name('form_filters.edit');
        // Route::put('/{balance}',            'update')->name('form_filters.update');
        // Route::delete('/{balance}',        'destroy')->name('form_filters.destroy');
    });
});
                // FormFilterController end
                // FormFilterController end
                // FormFilterController end


                // CommissionController start
                // CommissionController start
                // CommissionController start
Route::prefix("commissions")->group(function(){
    Route::controller(CommissionController::class)->group(function () {
        Route::get('/',        'index')->name('commissions.index');
        // Route::get('/create', 'create')->name('commissions.create');
        Route::post('/',       'store')->name('commissions.store');
        // Route::get('/{balance}',        'show')->name('balances.show');
        // Route::get('/search',         'search')->name('balances.search');
        // Route::get('/{balance}/edit',   'edit')->name('balances.edit');
        // Route::put('/{balance}',      'update')->name('balances.update');
        // Route::delete('/{balance}',  'destroy')->name('balances.destroy');
    });
});
                // CommissionController end
                // CommissionController end
                // CommissionController end


                // OverMuchUnitController start
                // OverMuchUnitController start
                // OverMuchUnitController start
Route::prefix("overMuchUnits")->group(function(){
    Route::controller(OverMuchUnitController::class)->group(function () {
        Route::get('/',        'index')->name('overMuchUnits.index');
        // Route::get('/create', 'create')->name('commissions.create');
        Route::post('/',       'store')->name('overMuchUnits.store');
        // Route::get('/{balance}',        'show')->name('balances.show');
        // Route::get('/search',         'search')->name('balances.search');
        // Route::get('/{balance}/edit',   'edit')->name('balances.edit');
        // Route::put('/{balance}',      'update')->name('balances.update');
        // Route::delete('/{balance}',  'destroy')->name('balances.destroy');
    });
});
                // OverMuchUnitController end
                // OverMuchUnitController end
                // OverMuchUnitController end





