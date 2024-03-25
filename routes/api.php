<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Post\PollController;
use App\Http\Controllers\Api\Course\MarkController;
use App\Http\Controllers\Api\Course\LevelController;
use App\Http\Controllers\Api\Admin\PaymentController;
use App\Http\Controllers\Api\Admin\StudentController;
use App\Http\Controllers\Api\Admin\TeacherController;
use App\Http\Controllers\Api\Course\CourseController;
use App\Http\Controllers\Api\Course\BookingController;
use App\Http\Controllers\Api\Course\SubjectController;
use App\Http\Controllers\Api\Post\PhotoPostController;
use App\Http\Controllers\Api\Admin\ComplaintController;
use App\Http\Controllers\Api\Admin\ModeratorController;
use App\Http\Controllers\Api\Post\AdvertisementController;
use App\Http\Controllers\Api\Post\Comment\PhotoCommentController;
use App\Http\Controllers\Api\Post\Comment\AdvertisementCommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('scheduler', function () {
    Artisan::call('schedule:run');
    return 'Task scheduler has been run.';
});


Route::post('user/register', [UserController::class, 'register']);
Route::post('user/login', [UserController::class, 'login']);
Route::get('user/verify', [UserController::class, 'verifyEmail'])->name('mail.verify');
Route::get('user/list', [UserController::class, 'userList']);
Route::get('user/all', [UserController::class, 'userAll']);

Route::middleware('auth:api')->group(function () {
    Route::get('home', [HomeController::class, 'index']);
    Route::get('posts', [HomeController::class, 'posts']);


    Route::group(['prefix' => 'admin'], function(){

        Route::group(['prefix' => 'moderator'], function(){
            Route::get('index',[ ModeratorController::class , 'index']);
            Route::get('show/{moderator_id}',[ ModeratorController::class , 'show']);
            Route::post('store',[ ModeratorController::class , 'store']);
            Route::post('{moderator_id}/update',[ ModeratorController::class , 'update']);
            Route::get('{moderator_id}/delete',[ ModeratorController::class , 'destroy']);
        });

        Route::group(['prefix' => 'teacher'], function(){
            Route::get('index',[ TeacherController::class , 'index']);
            Route::get('show/{teacher_id}',[ TeacherController::class , 'show']);
            Route::post('store',[ TeacherController::class , 'store']);
            Route::get('{teacher_id}/delete',[ TeacherController::class , 'destroy']);
            Route::get('getSubjects',[ TeacherController::class , 'getSubjects']);

        });

        Route::group(['prefix' => 'student'], function(){
            Route::get('index',[ StudentController::class , 'index']);
            Route::get('show/{student_id}',[ StudentController::class , 'show']);
            Route::post('store',[ StudentController::class , 'store']);
            Route::get('{teacher_id}/delete',[ StudentController::class , 'destroy']);
        });

        Route::group(['prefix' => 'payment'], function(){
            Route::post('other/store',[ PaymentController::class , 'storeOtherPayment']);
            Route::get('other/index',[ PaymentController::class , 'indexOtherPayment']);
            Route::post('salary/store',[ PaymentController::class , 'storeSalaryPayment']);
            Route::post('salary/index',[ PaymentController::class , 'indexSalaryPayment']);
        });


    });

    Route::group(['prefix' => 'courses'], function(){
        Route::get('index',[ CourseController::class , 'getAllPublishedCourses']);
        Route::get('closed/index',[ CourseController::class , 'getAllClosedCourses']);
        Route::get('active/index',[ CourseController::class , 'getAllActiveCourses']);
        Route::get('show/{course_id}',[ CourseController::class , 'show']);
        Route::post('store',[ CourseController::class , 'store']);
        Route::post('{course_id}/update',[ CourseController::class , 'update']);
        Route::get('publish/{course_id}',[ CourseController::class , 'publish']);

        Route::group(['prefix' => 'book'], function(){
            Route::get('{course_id}/index',[ BookingController::class , 'index']);
            Route::get('{course_id}/store',[ BookingController::class , 'store']);
            Route::get('{course_id}/request/{book_id}/approve',[ BookingController::class , 'approveStudentRequest']);
            Route::get('{course_id}/request/{book_id}/reject',[ BookingController::class , 'rejectStudentRequest']);
        });


        Route::group(['prefix' => '{course_id}/levels'], function(){
            Route::get('index',[ LevelController::class , 'index']);
            Route::get('show/{level_id}',[ LevelController::class , 'show']);
            Route::post('store',[ LevelController::class , 'store']);
            Route::post('{level_id}/update',[ LevelController::class , 'update']);
            Route::get('{level_id}/delete',[ LevelController::class , 'destroy']);

            Route::group(['prefix' => '{level_id}/subject'], function(){
                Route::get('index',[ SubjectController::class , 'index']);
                Route::get('show/{subject_id}',[ SubjectController::class , 'show']);
                Route::post('store',[ SubjectController::class , 'store']);
                Route::post('{subject_id}/update',[ SubjectController::class , 'update']);
                Route::get('{subject_id}/delete',[ SubjectController::class , 'destroy']);
            });

        });
    });
    Route::group(['prefix' => 'advertisement'], function(){
        Route::get('index',[ AdvertisementController::class , 'index']);
        Route::post('store',[ AdvertisementController::class , 'store']);
        Route::get('{ad_id}/delete',[ AdvertisementController::class , 'destroy']);
        Route::group(['prefix' => '{ad_id}/comment'], function(){
            Route::get('index',[ AdvertisementCommentController::class , 'index']);
            Route::post('store',[ AdvertisementCommentController::class , 'store']);
        });
    });

    Route::group(['prefix' => 'poll'], function(){
        Route::get('index',[ PollController::class , 'index']);
        Route::post('store',[ PollController::class , 'store']);
        Route::get('{poll_id}/delete',[ PollController::class , 'destroy']);
        Route::get('{poll_id}/like',[ PollController::class , 'like']);
        Route::get('{poll_id}/dislike',[ PollController::class , 'dislike']);
    });

    Route::group(['prefix' => 'photo'], function(){
        Route::get('index',[ PhotoPostController::class , 'index']);
        Route::post('store',[ PhotoPostController::class , 'store']);
        Route::get('{photo_id}/delete',[ PhotoPostController::class , 'destroy']);
        Route::group(['prefix' => '{photo_id}/comment'], function(){
            Route::get('index',[ PhotoCommentController::class , 'index']);
            Route::post('store',[ PhotoCommentController::class , 'store']);
        });
    });


    Route::group(['prefix' => 'complaint'], function(){
        Route::get('index',[ ComplaintController::class , 'index']);
        Route::post('store',[ ComplaintController::class , 'store']);
    });

    Route::group(['prefix' => 'mark'], function(){
        Route::get('index/{student_id}',[ MarkController::class , 'index']);
        Route::post('{subject_id}/store',[ MarkController::class , 'store']);
    });


});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
