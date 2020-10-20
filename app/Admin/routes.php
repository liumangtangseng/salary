<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('staff', StaffController::class);
    $router->resource('salary', SalaryController::class);
    $router->resource('dep', DepController::class);
    $router->get('/staff-salary/add-salary/','SalaryController@addStaffSalary');
    $router->get('/api/dept','ApiController@getDept');
    $router->any('cardnewsimport','SalaryController@doStaffSalary');


});
