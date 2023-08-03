<?php
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\teacher\UnitController;
use App\Http\Controllers\teacher\MarksController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\viewGradesController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

//dashboards
Route::get('/student.dashboard', function () {
    return view('student.dashboard');
});
Route::get('/admin.dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/teacher.dashboard', function () {
    return view('teacher.dashboard');
});


Route::get('/dashboard', function () {
    return view('partial.menu');

})->middleware(['auth'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');


//Adding courses by Admin
Route::resource('courses', CourseController::class)
->middleware('auth')
->middleware('role_as:1')
->names([
    'index' => 'courses.index',
    'create' => 'courses.create',
    'store' => 'courses.store',
    'show' => 'courses.show',
    'edit' => 'courses.edit',
    'update' => 'courses.update',
    'destroy' => 'courses.destroy',
]);

Route::get('mycourses', [EnrollmentController::class, 'mycourses'])
->middleware('auth') // Apply the built-in auth middleware for authentication
->middleware('role_as:0') // Apply the role middleware with the specified roles
->name('enrollments.mycourses');

//Adding Units by teacher
Route::resource('units', UnitController::class)
->middleware('auth')
->middleware('role_as:2')
->names([
    'index' => 'units.index',
    'create' => 'units.create',
    'store' => 'units.store',
    'show' => 'units.show',
    'edit' => 'units.edit',
    'update' => 'units.update',
    'destroy' => 'units.destroy',
]); 

//student enrollment
Route::resource('enrollments', EnrollmentController::class)
->middleware('auth')
->middleware('role_as:0')
->names([
    'index' => 'enrollments.index',
    'create' => 'enrollments.create',
    'store' => 'enrollments.store',
    'show' => 'enrollments.show',
    'edit' => 'enrollments.edit',
    'update' => 'enrollments.update',
    'destroy' => 'enrollments.destroy',
]); 


//Teacher adding student marks
Route::resource('marks', MarksController::class)
->middleware('auth')
->middleware('role_as:2')
->names([
    'index' => 'marks.index',
    'create' => 'marks.create',
    'store' => 'marks.store',
    'show' => 'marks.show',
    'edit' => 'marks.edit',
    'update' => 'marks.update',
    'destroy' => 'marks.destroy',
]);


//student grades
Route::resource('grades', viewGradesController::class)
->middleware('auth')
->middleware('role_as:0')
->names([
    'index' => 'grades.index',
    'create' => 'grades.create',
    'store' => 'grades.store',
    'show' => 'grades.show',
    'edit' => 'grades.edit',
    'update' => 'grades.update',
    'destroy' => 'grades.destroy',
]);

// Admin Users Management
Route::resource('usermanagement', UserController::class)->names([
    'index' => 'users.index',
    'create' => 'users.create',
    'store' => 'users.store',
    'show' => 'users.show',
    'edit' => 'users.edit',
    'update' => 'users.update',
    'destroy' => 'users.destroy',
]);


require __DIR__.'/auth.php';

