<?php    
    require_once __DIR__ . '/../app/Config/config.php';

    function require_all_files($directory) {
        foreach (glob($directory . '/*.php') as $filename) {
            require_once $filename;
        }
    }

    // Require all core files
    require_all_files(__DIR__ . '/../app/Core');
    $db = new Database();
    BaseModel::setDatabase($db);

    require_all_files(__DIR__ . '/../app/Helpers');
    require_once __DIR__ . '/../app/Models/User.php';
    require_all_files(__DIR__ . '/../app/Models');

    // Define the routes
    $router = new Router();
    $request = new Request();

    $router->add('GET', '/', 'HomePage@index', ["visitor", "student"]);
    $router->add('GET', '/courses', 'CoursesPage@index', ["visitor", "student"]);
    $router->add('POST', '/courses/enroll/{id}', 'CoursesPage@enroll', ["student"]);
    $router->add('POST', '/courses/completed/{id}', 'CoursesPage@completed', ["student"]);
    $router->add('GET', '/courses/content/{id}', 'CourseContentPage@index', ["visitor", "student"]);
    $router->add('GET', '/courses/{id}', 'CoursesPage@show', ["visitor", "student"]);
    $router->add('GET', '/my-courses', 'MyCoursesPage@index', ["student"]);


    $router->add('POST', '/api/rate/create', 'MyCoursesPage@rateCourse', ["student"]);
    $router->add('POST', '/api/rate/delete', 'MyCoursesPage@deleteCourseRate', ["student"]);

    $router->add('GET', '/', 'DashboardTeacherPage@index', ["teacher"]);
    $router->add('GET', '/courses', 'CoursesTeacherPage@index', ["teacher"]);
    $router->add('GET', '/courses/create', 'CoursesTeacherPage@create', ["teacher"]);
    $router->add('POST', '/courses/store', 'CoursesTeacherPage@store', ["teacher"]);
    $router->add('GET', '/courses/edit/{id}', 'CoursesTeacherPage@edit', ["teacher"]);
    $router->add('POST', '/courses/update/{id}', 'CoursesTeacherPage@update', ["teacher"]);
    $router->add('POST', '/courses/delete/{id}', 'CoursesTeacherPage@delete', ["teacher"]);
    $router->add('GET', '/students', 'StudentsTeacherPage@index', ["teacher"]);

    $router->add('GET', '/', 'DashboardAdminPage@index', ["admin"]);
    $router->add('GET', '/courses', 'CoursesAdminPage@index', ["admin"]);
    $router->add('GET', '/courses/{id}', 'CoursesAdminPage@show', ["admin"]);
    $router->add('POST', '/courses/delete/{id}', 'CoursesAdminPage@delete', ["admin"]);
    $router->add('GET', '/teachers', 'TeachersAdminPage@index', ["admin"]);
    $router->add('GET', '/students', 'StudentsAdminPage@index', ["admin"]);
    $router->add('GET', '/banned-students', 'BannedStudentsAdminPage@index', ["admin"]);
    $router->add('POST', '/students/ban/{id}', 'BannedStudentsAdminPage@ban', ["admin"]);
    $router->add('POST', '/students/unban/{id}', 'BannedStudentsAdminPage@unBan', ["admin"]);
    $router->add('GET', '/unverified-teachers', 'UnverifiedTeachersAdminPage@index', ["admin"]);
    $router->add('POST', '/teachers/verify/{id}', 'UnverifiedTeachersAdminPage@verify', ["admin"]);
    $router->add('GET', '/categories', 'CategoriesAdminPage@index', ["admin"]);
    $router->add('POST', '/categories/store', 'CategoriesAdminPage@store', ["admin"]);
    $router->add('POST', '/categories/delete', 'CategoriesAdminPage@delete', ["admin"]);
    $router->add('GET', '/tags', 'TagsAdminPage@index', ["admin"]);
    $router->add('POST', '/tags/store', 'TagsAdminPage@store', ["admin"]);
    $router->add('POST', '/tags/delete', 'TagsAdminPage@delete', ["admin"]);



    $router->add('GET', '/login', 'LoginPage@index', ["visitor"]);
    $router->add('POST', '/login', 'LoginPage@login', ["visitor"]);
    $router->add('GET', '/signup', 'SignupPage@index', ["visitor"]);
    $router->add('POST', '/signup', 'SignupPage@signup', ["visitor"]);
    
    $router->add('POST', '/logout', 'LoginPage@logout', ["student", "teacher", "admin"]);

    $router->dispatch($request);