<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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

//Route::get('/test', [App\Http\Controllers\AdminDashboardHome::class, 'index'])->name('test');

Route::get('/', function () {
    return view('web.home');
})->name('home');

Route::get('/services', [App\Http\Controllers\DisplayService::class, 'index'])->name('services');
Route::get('/services/{slug}', [App\Http\Controllers\DisplayService::class, 'show'])->name('view-service');

// Route::get('/services/{id}', [App\Http\Controllers\ServiceDisplay::class, 'show'])->name('services.show');
Route::get('/deals', [App\Http\Controllers\DisplayDeal::class, 'index'])->name('deals');

//Route::post('/botCreate', [App\Http\Controllers\BotAppointmentController::class, 'indexPost'])->name('botCreatePost');
Route::get('/bot_create/get&key={key}&method={method}', [App\Http\Controllers\BotAppointmentController::class, 'getArray']);
Route::get('/bot_create/get_time_slots&key={key}&date={date}', [App\Http\Controllers\BotAppointmentController::class, 'getTimeSlots']);
Route::get('/bot_create/save_appointment&key={key}'
    . '&creator_id={creator_id}'
    . '&receiving_name={receiving_name}'
    . '&date={date}'
    . '&start_time={start_time}'
    . '&location_id={location_id}'
    . '&service_id={service_id}'
    , [App\Http\Controllers\BotAppointmentController::class, 'saveAppointment']);

// Users needs to be logged in for these routes


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
//    Route::prefix('translation')->group(function () {

//    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [App\Http\Controllers\DashboardHomeController::class, 'index'])->name('dashboard');

        // middleware to give access only for admin
        Route::middleware([
            'validatePermission:edit_translations'
        ])->group(function () {
            Route::get('translation', function () {
                if (auth()->user()->hasPermission('new_style_access')) {
                    return view('dashboard.settings.translations.index');
                }
                return view('dashboard.translation-settings.index');
            })->name('settings.translation');
        });

        Route::middleware([
            'validatePermission:edit_roles'
        ])->group(function () {
            Route::controller(RoleController::class)->group(function () {
                Route::get('/roles', 'index')->name('settings.roles');
                Route::put('/roles/store', 'store')->name('settings.roles.store');
                Route::put('/roles/{id}/update', 'update')->name('settings.roles.update');
            });
        });

        Route::middleware([
            'validatePermission:edit_permissions'
        ])->group(function () {
            Route::controller(PermissionController::class)->group(function () {
                Route::get('/permissions', 'index')->name('settings.permissions');
                Route::put('/permissions/store', 'store')->name('settings.permissions.store');
                Route::put('/permissions/{id}/update', 'update')->name('settings.permissions.update');
            });
        });

        Route::prefix('manage')->group(function () {
            Route::middleware([
                'validatePermission:manage_users'
            ])->group(function () {
                Route::resource('users', App\Http\Controllers\UserController::class)->name('index', 'manage.users');
                Route::resource('users/create', App\Http\Controllers\UserController::class,)->name('create', 'users.create');
                Route::resource('users/create/put', App\Http\Controllers\UserController::class)->name('store', 'manage.users.store');
                Route::put('users/{id}/suspend', [App\Http\Controllers\UserSuspensionController::class, 'suspend'])->name('manage.users.suspend');
                Route::put('users/{id}/activate', [App\Http\Controllers\UserSuspensionController::class, 'activate'])->name('manage.users.activate');
                Route::put('users/{id}/update_role/{roleId}', [App\Http\Controllers\UserSuspensionController::class, 'updateRole'])->name('users.updateRole');
            });
            Route::middleware([
                'validatePermission:manage_locations'
            ])->group(function () {
                Route::get('locations', function () {
                    if (auth()->user()->hasPermission('new_style_access')) {
                        return view('dashboard.manage.locations.index');
                    }
                    return view('dashboard.manage-locations.index');
                })->name('manage.locations');
            });
            Route::middleware([
                'validatePermission:manage_services'
            ])->group(function () {
                Route::get('services', function () {
                    if (auth()->user()->hasPermission('new_style_access')) {
                        return view('dashboard.manage.services.index');
                    }
                    return view('dashboard.manage-services.index');
                })->name('manage.services');
            });
            Route::middleware([
                'validatePermission:manage_deals'
            ])->group(function () {
                Route::get('deals', function () {
                    if (auth()->user()->hasPermission('new_style_access')) {
                        return view('dashboard.manage.deals.index');
                    }
                    return view('dashboard.manage-deals.index');
                })->name('manage.deals');
            });
            Route::middleware([
                'validatePermission:manage_categories'
            ])->group(function () {
                Route::controller(CategoriesController::class)->group(function () {
                    Route::get('/categories', 'index')->name('manage.categories');
                    Route::put('/categories/store', 'store')->name('manage.categories.store');
                    Route::put('/categories/{id}/update', 'update')->name('manage.categories.update');
                });
                Route::get('categories/create', function () {
                    return view('dashboard.manage-categories.index');
                })->name('managecategories.create');

            });
            Route::middleware([
                'validatePermission:manage_appointment'
            ])->group(function () {
                Route::get('appointments', function () {
                    if (auth()->user()->hasPermission('new_style_access')) {
                        return view('dashboard.manage.appointments.index');
                    }
                    return view('dashboard.manage-appointments.index');
                })->name('manage.appointments');
            });
        });

//        Route::prefix('manage')->group(function () {
//            Route::resource('users', App\Http\Controllers\UserController::class)->name('index', 'manageusers');
//            Route::put('users/{id}/suspend', [App\Http\Controllers\UserSuspensionController::class, 'suspend'])->name('manageusers.suspend');
//            Route::put('users/{id}/activate', [App\Http\Controllers\UserSuspensionController::class, 'activate'])->name('manageusers.activate');
//
//            Route::get('locations', function () {
//                return view('dashboard.manage-locations.index');
//            })->name('managelocations');
//        });


        // middlleware to give access only for admin and employee
//        Route::middleware([
//            'validateRole:Admin,Employee'
//        ])->group(function () {
//
//            Route::prefix('manage')->group(function () {
//
//                Route::get('deals', function () {
//                    return view('dashboard.manage-deals.index');
//                })->name('managedeals');
//
//                Route::get('categories', function () {
//                    return view('dashboard.manage-categories.index');
//                })->name('managecategories');
//
//                Route::get('categories/create', function () {
//                    return view('dashboard.manage-categories.index');
//                })->name('managecategories.create');
//
//                Route::get('appointments', function () {
//                    return view('dashboard.manage-appointments.index');
//                })->name('manageappointments');
//            });


        // analytics route group
//            Route::prefix('analytics')->group(function () {
//                Route::get('/', [App\Http\Controllers\AnalyticsController::class, 'index'])->name('analytics');
//                Route::get('/revenue', [App\Http\Controllers\AnalyticsController::class, 'revenue'])->name('analytics.revenue');
//                Route::get('/appointments', [App\Http\Controllers\AnalyticsController::class, 'appointments'])->name('analytics.appointments');
//                Route::get('/customers', [App\Http\Controllers\AnalyticsController::class, 'customers'])->name('analytics.customers');
//                Route::get('/employees', [App\Http\Controllers\AnalyticsController::class, 'employees'])->name('analytics.employees');
//                Route::get('/services', [App\Http\Controllers\AnalyticsController::class, 'services'])->name('analytics.services');
//                Route::get('/locations', [App\Http\Controllers\AnalyticsController::class, 'locations'])->name('analytics.locations');
//            });
//                // graph route group
//                Route::prefix('graph')->group(function () {
//                    Route::get('/revenue', [App\Http\Controllers\GraphController::class, 'revenue'])->name('graph.revenue');
//                    Route::get('/appointments', [App\Http\Controllers\GraphController::class, 'appointments'])->name('graph.appointments');
//                    Route::get('/customers', [App\Http\Controllers\GraphController::class, 'customers'])->name('graph.customers');
//                    Route::get('/employees', [App\Http\Controllers\GraphController::class, 'employees'])->name('graph.employees');
//                    Route::get('/services', [App\Http\Controllers\GraphController::class, 'services'])->name('graph.services');
//                    Route::get('/locations', [App\Http\Controllers\GraphController::class, 'locations'])->name('graph.locations');
//                });


//        });

        Route::middleware([
            'validateRole:Customer'
        ])->group(function () {

            Route::prefix('cart')->group(function () {
                Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
                Route::post('/', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
                Route::delete('/item/{cart_service_id}', [App\Http\Controllers\CartController::class, 'removeItem'])->name('cart.remove-item');
                Route::delete('/{id}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
                Route::post('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
            });


            // Get the appointments of the user
//            Route::get('appointments', [App\Http\Controllers\AppointmentController::class, 'index'])->name('appointments');
//
//            // View an appointment
//            Route::get('appointments/{appointment_code}', [App\Http\Controllers\AppointmentController::class, 'show'])->name('appointments.show');
//
//            // Cancel an appointment
//            Route::delete('appointments/{appointment_code}', [App\Http\Controllers\AppointmentController::class, 'destroy'])->name('appointments.destroy');


        });
    });
});
