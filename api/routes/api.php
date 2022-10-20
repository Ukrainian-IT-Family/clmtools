<?php

use App\Http\Controllers\Api\CourseControllers;
use App\Http\Controllers\Api\LectureControllers;
use App\Http\Controllers\Api\LecturerChatController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\TaskControllers;
use App\Http\Controllers\Api\UserControllers;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\StudentTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HandbookControllers;
use App\Http\Controllers\Api\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/status/{serviceName?}', [StatusController::class, 'status']);
Route::post('/mail', [StatusController::class, 'mail']);
Route::post('/broadcast', [StatusController::class, 'event']);

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [RegistrationController::class, 'register']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
        Route::post('reset', [AuthController::class, 'reset'])->name('reset-password');
        Route::post('change-password', [AuthController::class, 'change_password'])->name('change-password');
        Route::put('me', [AuthController::class, 'update'])->name('profile.update');
        Route::get('me', [AuthController::class, 'me'])->name('profile.me');
        Route::post('me/image', [AuthController::class, 'uploadProfileImage']);
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::post('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend/{id}', [VerificationController::class, 'resend'])->name('verification.resend');

    Route::middleware('auth:api')->group(function () {
        Route::post('user-lectures/{id}', [LectureControllers::class, 'userLectures'])->name('user.lectures');
        Route::post('lecture/{id}', [LectureControllers::class, 'lecture'])->name('lecture');

        Route::middleware('lecturer')->group(function () {
            Route::get('lectures', [LectureControllers::class, 'getLectures'])->name('get.lectures');
            Route::post('lectures', [LectureControllers::class, 'createLecture'])->name('create.lecture');
            Route::put('lectures/{id}', [LectureControllers::class, 'editLecture'])->name('edit.lecture');
            Route::delete('lectures/{id}', [LectureControllers::class, 'deleteLecture'])->name('delete.lecture');

            Route::get('students', [UserControllers::class, 'getStudents'])->name('get.students');

            Route::get('courses', [CourseControllers::class, 'getCourses'])->name('get.courses');
            Route::post('courses', [CourseControllers::class, 'createCourse'])->name('create.course');
            Route::put('courses/{id}', [CourseControllers::class, 'editCourse'])->name('edit.course');
            Route::delete('courses/{id}', [CourseControllers::class, 'deleteCourse'])->name('delete.course');

            Route::get('tasks', [TaskControllers::class, 'getTasks'])->name('get.tasks');
            Route::get('tasks/{id}', [TaskControllers::class, 'getTaskById'])->name('get.task');
            Route::post('tasks', [TaskControllers::class, 'createTask'])->name('create.task');
            Route::put('tasks/{id}', [TaskControllers::class, 'editTask'])->name('edit.task');
            Route::put('tasks/{id}/rating', [TaskControllers::class, 'setRatingTask'])->name('set-rating.task');
            Route::delete('tasks/{id}', [TaskControllers::class, 'deleteTask'])->name('delete.task');
        });

        Route::middleware('admin')->group(function () {
            Route::get('users', [UserControllers::class, 'getUsers'])->name('get.users');
            Route::put('users/{id}', [UserControllers::class, 'editUser'])->name('edit.user');
            Route::delete('users/{id}', [UserControllers::class, 'deleteUser'])->name('delete.user');
            Route::get('roles', [UserControllers::class, 'getUserRoles'])->name('get.roles');
        });

        Route::post('chat', [ChatController::class, 'store'])->name('chat.store');
        Route::get('chat', [ChatController::class, 'chat'])->name('chat');
        Route::get('messages', [ChatController::class, 'messages'])->name('messages');
        Route::post('message', [ChatController::class, 'storeMessage'])->name('chat.store-message');

        Route::get('lectures-chat', [LecturerChatController::class, 'getLecturesByLecturerId'])->name('lecturer-chat.lectures');
        Route::post('lecturer-chat', [LecturerChatController::class, 'store'])->name('lecturer-chat.store');
        Route::post('lecturer-message', [LecturerChatController::class, 'storeMessage'])->name('lecturer-chat.store-message');
        Route::get('students-by-lecture', [LecturerChatController::class, 'getStudentsByLectureId'])->name('lecturer-chat.students-by-lecture');
        Route::post('mark-messages', [LecturerChatController::class, 'markMessagesAsReadByChatId'])->name('lecturer-chat.mark-messages');

        Route::get('task', [StudentTaskController::class, 'task'])->name('student-task.task');
        Route::post('answer', [StudentTaskController::class, 'answer'])->name('student-task.answer');
        Route::get('answer-info', [StudentTaskController::class, 'answerInfo'])->name('student-task.answer-info');
        Route::get('task-list', [StudentTaskController::class, 'taskList'])->name('student-task.task-list');
        Route::get('task-wo-lecture', [StudentTaskController::class, 'taskWOLecture'])->name('student-task.task-wo-lecture');

        Route::get('notifications', [NotificationController::class, 'getNotifications'])->name('notifications.list');
        Route::delete('notifications', [NotificationController::class, 'deleteNotifications'])->name('notifications.delete');
        Route::delete('notification', [NotificationController::class, 'deleteNotificationById'])->name('notification.delete');

        Route::group(['prefix' => '/cities'], function () {
            Route::get('/', [HandbookControllers::class, 'getCities']);
            Route::get('/{id}', [HandbookControllers::class, 'city']);
        });

        Route::group(['prefix' => '/universities'], function () {
            Route::get('/', [HandbookControllers::class, 'getUniversities']);
            Route::get('/{id}', [HandbookControllers::class, 'university']);
        });
    });
});
