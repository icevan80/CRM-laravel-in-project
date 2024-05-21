<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UserController;
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

Route::prefix('services')->group(function () {
    Route::get('/', [App\Http\Controllers\DisplayService::class, 'index'])->name('services');
    Route::get('/{slug}', [App\Http\Controllers\DisplayService::class, 'show'])->name('services.view');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [App\Http\Controllers\DashboardHomeController::class, 'index'])->name('dashboard');

        Route::middleware([
            'validatePermission:edit_translations'
        ])->group(function () {
            Route::get('translation', function () {
                return view('dashboard.settings.translations.index');
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
                Route::controller(UserController::class)->group(function () {
                    Route::get('/users', 'index')->name('manage.users');
                    Route::get('/users/clients', 'indexClients')->name('manage.users.clients');
                    Route::get('/users/staff', 'indexStaff')->name('manage.users.staff');
                    Route::get('/users/create', 'create')->name('manage.users.create');
                    Route::put('/users/store', 'store')->name('manage.users.store');
                    Route::get('/users/{id}', 'show')->name('manage.users.show');
                    Route::get('/users/{id}/edit', 'edit')->name('manage.users.edit');
                    Route::put('/users/{id}/update', 'update')->name('manage.users.update');
                    Route::put('/users/{id}/destroy', 'destroy')->name('manage.users.destroy');
                    Route::put('/users/{id}/restore', 'restore')->name('manage.users.restore');
                    Route::put('/users/{id}/update_role', 'updateRole')->name('manage.users.updateRole');
                });
            });
            Route::middleware([
                'validatePermission:manage_locations'
            ])->group(function () {
                Route::controller(LocationsController::class)->group(function () {
                    Route::get('/locations', 'index')->name('manage.locations');
                    Route::put('/locations/store', 'store')->name('manage.locations.store');
                    Route::put('/locations/{id}/update', 'update')->name('manage.locations.update');
                    Route::put('/locations/{id}/destroy', 'destroy')->name('manage.locations.destroy');
                });
            });
            Route::middleware([
                'validatePermission:manage_services'
            ])->group(function () {
                Route::controller(ServicesController::class)->group(function () {
                    Route::get('/services', 'index')->name('manage.services');
                    Route::get('/services/create', 'create')->name('manage.services.create');
                    Route::put('/services/store', 'store')->name('manage.services.store');
                    Route::get('/services/{id}', 'show')->name('manage.services.show');
                    Route::get('/services/{id}/edit', 'edit')->name('manage.services.edit');
                    Route::put('/services/{id}/update', 'update')->name('manage.services.update');
                    Route::put('/services/{id}/destroy', 'destroy')->name('manage.services.destroy');
                });
            });
            Route::middleware([
                'validatePermission:manage_deals'
            ])->group(function () {
                Route::get('deals', function () {
                    return view('dashboard.manage.deals.index');
                })->name('manage.deals');
            });
            Route::middleware([
                'validatePermission:manage_categories'
            ])->group(function () {
                Route::controller(CategoriesController::class)->group(function () {
                    Route::get('/categories', 'index')->name('manage.categories');
                    Route::put('/categories/store', 'store')->name('manage.categories.store');
                    Route::put('/categories/{id}/update', 'update')->name('manage.categories.update');
                    Route::put('/categories/{id}/destroy', 'destroy')->name('manage.categories.destroy');
                });
            });
            Route::middleware([
                'validatePermission:manage_appointment'
            ])->group(function () {
                Route::controller(AppointmentsController::class)->group(function () {
                    Route::get('/appointments', 'index')->name('manage.appointments');
                    Route::get('/appointments/create', 'create')->name('manage.appointments.create');
                    Route::put('/appointments/store', 'store')->name('manage.appointments.store');
                    Route::get('/appointments/{id}', 'show')->name('manage.appointments.show');
                    Route::get('/appointments/{id}/edit', 'edit')->name('manage.appointments.edit');
                    Route::put('/appointments/{id}/update', 'update')->name('manage.appointments.update');
                    Route::put('/appointments/{id}/update_implementer', 'updateImplementer')->name('manage.appointments.updateImplementer');
                    Route::put('/appointments/{id}/cancel', 'cancel')->name('manage.appointments.cancel');
                    Route::put('/appointments/{id}/destroy', 'destroy')->name('manage.appointments.destroy');
                });
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
