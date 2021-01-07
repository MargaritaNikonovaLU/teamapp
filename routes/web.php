<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DarbiniekiController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {        return view('userhome');});
Route::get('/userhome', function () {     return view('userhome'); });


Route::group(['middleware' => ['auth']], function () {

    //priekš skata 'Darbinieki'
    Route::get('/darbinieki', [DarbiniekiController::class, 'userIndex'])->name('darbinieki');
    Route::post('/darbinieki/{id}', [DarbiniekiController::class, 'deleteUser'])->name('user.delete');
    Route::post('/darbinieki/status/{id}', [DarbiniekiController::class, 'userStatus'])->name('user.approve');
    Route::post('/darbinieki/staffname/{id}', [DarbiniekiController::class, 'userAdd_user_id'])->name('add.staffname');


   //priekš skata 'Uzdevumi'
    Route::get('/uzdevumi', [TasksController::class, 'taskShow'])->name('taskAdd');
    Route::post('/uzdevumi', [TasksController::class, 'taskAdd'])->name('taskAdd');
    Route::post('/uzdevumi/{id}', [TasksController::class, 'deleteTask'])->name('task.delete');
    Route::post('/uzdevumi/approve/{id}', [TasksController::class, 'taskStatus'])->name('task.approve');
    Route::post('/uzdevumi/taskadd/{id}', [TasksController::class, 'taskAddComment'])->name('task.addComment');
    Route::get('/uzdevumi/taskpassed', [TasksController::class, 'taskPassed'])->name('task.passed');
    Route::post('/uzdevumi/edit/{id}',[TasksController::class, 'editTask'])->name('editTask');
    Route::post('/uzdevumi/update/{id}',[TasksController::class, 'updateTask'])->name('updateTask');


    ///priekš skata 'Chat'
    Route::get('/chat', [ChatController::class, 'selectUsers'])->name('chat');
    Route::get('/message/{id}', [ChatController::class, 'getMessage'])->name('message');
    Route::post('message', [ChatController::class, 'sendMessage']);


    ///priekš skata 'Profile'
    Route::get('/userprofile', [ProfileController::class, 'userProfileCart'])->name('userprofile');
    Route::get('/userprofilebyid/{id}', [ProfileController::class, 'userProfileById'])->name('userProfileById');
    Route::get('/userprofile/edit', [ProfileController::class, 'userProfileCart2'])->name('edit.UserInfo');
    Route::post('/userprofile/edit/{id}', [ProfileController::class, 'updateUserInfo'])->name('user.editInfo');


    ///priekš skata 'Jaunumi'
    Route::get('/news', [NewsController::class, 'showNews'])->name('news');
    Route::post('/news', [NewsController::class, 'addNews'])->name('addNews');
    Route::post('/news/{id}', [NewsController::class, 'showNewsByTopic'])->name('showTopicById');
    Route::post('/news/delete/{id}', [NewsController::class, 'deleteNews'])->name('news.delete');



    ///priekš skata 'Dokumenti'
    Route::get('/upload-file', [FileController::class, 'createForm'])->name('file-upload');
    Route::post('/upload-file', [FileController::class, 'fileUpload'])->name('fileUpload');
    Route::post('/upload-file/{id}', [FileController::class, 'deleteFile'])->name('file.delete');



});    // te beidzas routes, kuri atlauti tikai ielogotiem lietotajiem


        ///priekš skata 'Ielogošana un Registresana'

        Route::get('/registerlhj', [AuthController::class, 'getSignup'])->name('auth.signup');
        Route::post('/registerlhj', [AuthController::class, 'postSignup']);
        Route::get('/signin', [AuthController::class, 'getSignin'])->name('auth.signin');
        Route::post('/signin', [AuthController::class, 'postSignin']);
        Route::get('/logout', [AuthController::class, 'getLogout'])->name('logout');





