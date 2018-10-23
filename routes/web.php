<?php

// MIDDLEWARES ------------------------------------------------------------

Route::group(['middleware' => 'guest'], function () {

// Guest Users ============================================================

        // Login
        Route::get('/', 'LoginController@index')->name('login');
        Route::post('/login','LoginController@login')->name('login.submit');
        
        Route::view('request', 'authenticate.register')->name('showRegister');
        Route::post('request', 'RequestController@store')->name('request.submit');
        
});
        // Logout
        Route::post('logout', 'LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'home'], function () {
        Route::get('/home','HomeController@latestPost')->name('home');   
        Route::resource('jobPosts','JobPostController')->except('create');
        Route::resource('announcements','AnnouncementController')->except('create');
    });


    // Student
    Route::group(['middleware' => 'student'], function () {  
        Route::view('/student/class', 'user.student.class')->name('students');
        Route::view('/student/profile', 'user.student.profile');

    });
    Route::group(['middleware' => 'guest'], function () {  
    });
    // Alumnus
    Route::group(['middleware' => 'alumnus'], function () {  
      
        Route::view('/alumnus/profile', 'user.alumnus.profile');
        Route::view('/alumnus/jobs', 'user.alumnus.jobs');
        Route::view('/alumnus/communicate', 'user.alumnus.communicate');
        Route::view('/alumnus/form', 'user.alumnus.form');       

    });

    
    // Teacher
    Route::group(['middleware' => 'teacher'], function () {

        Route::view('/teacher/profile', 'user.teacher.profile');
        
    });
    

    // Admin
    Route::group(['middleware' => 'admin'], function () { 
        Route::view('/admin', 'user.admin.index')->name('admins');

        Route::get('/user/students', 'Admin\UserController@students')->name('ShowStudents');
        Route::get('/user/alumni', 'Admin\UserController@alumni')->name('ShowAlumni');
        Route::get('/user/teachers', 'Admin\UserController@teachers')->name('ShowTeachers');
        Route::get('/user/coordinators', 'Admin\UserController@coordinators')->name('ShowCoordinators');
        Route::get('/user/chairs', 'Admin\UserController@chairs')->name('ShowChairs');
        Route::get('/user/admins', 'Admin\UserController@admins')->name('ShowAdmins');
        Route::post('/user/store', 'Admin\UserController@store')->name('StoreUser');
        Route::patch('/user/update', 'Admin\UserController@update')->name('UpdateUser');
        Route::delete('/user/delete', 'Admin\UserController@destroy')->name('DeleteUser');

        Route::get('/SM/classes', 'Admin\SchoolMgmtController@classes')->name('Classes');
        Route::post('/SM/store', 'Admin\SchoolMgmtController@storeClass')->name('StoreClass');
        Route::patch('/SM/update', 'Admin\SchoolMgmtController@updateClass')->name('UpdateClass');
        Route::delete('/SM/destroy', 'Admin\SchoolMgmtController@destroyClass')->name('DeleteClass');
        Route::post('/SM/students', 'Admin\SchoolMgmtController@studentClass')->name('StudentClass');
        Route::post('/SM/store/student', 'Admin\SchoolMgmtController@storeStudent')->name('StoreStudent');
        Route::delete('/SM/remove/student', 'Admin\SchoolMgmtController@removeStudent')->name('RemoveStudent');

        Route::get('/SM/school', 'Admin\SchoolMgmtController@school')->name('School');
        Route::post('/SM/school/store', 'Admin\SchoolMgmtController@storeSchool')->name('StoreSchool');
        Route::post('/SM/department/store', 'Admin\SchoolMgmtController@storeDepartment')->name('StoreDepartment');
        Route::post('/SM/course/store', 'Admin\SchoolMgmtController@storeCourse')->name('StoreCourse');
        Route::patch('/SM/school/update', 'Admin\SchoolMgmtController@updateSchool')->name('UpdateSchool');
        Route::patch('/SM/department/update', 'Admin\SchoolMgmtController@updateDepartment')->name('UpdateDepartment');
        Route::patch('/SM/course/update', 'Admin\SchoolMgmtController@updateCourse')->name('UpdateCourse');
        Route::delete('/SM/school/delete', 'Admin\SchoolMgmtController@destroySchool')->name('DeleteSchool');
        Route::delete('/SM/department/delete', 'Admin\SchoolMgmtController@destroyDepartment')->name('DeleteDepartment');
        Route::delete('/SM/course/delete', 'Admin\SchoolMgmtController@destroyCourse')->name('DeleteCourse');

        Route::get('/track/nation', 'Admin\TrackController@nationwide')->name('ShowNation');
        Route::get('/track/unitedstates', 'Admin\TrackController@unitedstates')->name('ShowUS');
        Route::get('/track/world', 'Admin\TrackController@worldwide')->name('ShowWorld');
    });
    

// Resources ==============================================================

    //Student


    // Teacher

    // Admin
    Route::resource('registration', 'Admin\UserRegistrationController', 
    ['only' => ['index', 'edit', 'update', 'destroy']]);

   

});