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
    require_all_files(__DIR__ . '/../app/Controllers');

    // Define the routes
    $router = new Router();
    $request = new Request();

    $router->get('/', [HomeController::class, 'index'], ["visitor", "student"]);
    $router->get('/courses', [CoursesController::class, 'index'], ["visitor", "student"]);
    $router->post('/courses/enroll/{id}', [CoursesController::class, 'enroll'], ["student"]);
    $router->post('/courses/completed/{id}', [CoursesController::class, 'completed'], ["student"]);
    $router->get('/courses/content/{id}', [CourseContentController::class, 'index'], ["student"]);
    $router->get('/courses/certify/{id}', [CourseContentController::class, 'certify'], ["student"]);
    $router->get('/courses/{id}', [CoursesController::class, 'show'], ["visitor", "student"]);
    $router->get('/my-courses', [MyCoursesController::class, 'index'], ["student"]);

    $router->post('/api/rate/create', [MyCoursesController::class, 'rateCourse'], ["student"]);
    $router->post('/api/rate/delete', [MyCoursesController::class, 'deleteCourseRate'], ["student"]);

    $router->get('/', [DashboardTeacherController::class, 'index'], ["teacher"]);
    $router->get('/courses', [CoursesTeacherController::class, 'index'], ["teacher"]);
    $router->get('/courses/create', [CoursesTeacherController::class, 'create'], ["teacher"]);
    $router->post('/courses/store', [CoursesTeacherController::class, 'store'], ["teacher"]);
    $router->get('/courses/edit/{id}', [CoursesTeacherController::class, 'edit'], ["teacher"]);
    $router->post('/courses/update/{id}', [CoursesTeacherController::class, 'update'], ["teacher"]);
    $router->post('/courses/delete/{id}', [CoursesTeacherController::class, 'delete'], ["teacher"]);
    $router->get('/students', [StudentsTeacherController::class, 'index'], ["teacher"]);

    $router->get('/', [DashboardAdminController::class, 'index'], ["admin"]);
    $router->get('/courses', [CoursesAdminController::class, 'index'], ["admin"]);
    $router->get('/courses/{id}', [CoursesAdminController::class, 'show'], ["admin"]);
    $router->post('/courses/delete/{id}', [CoursesAdminController::class, 'delete'], ["admin"]);
    $router->get('/teachers', [TeachersAdminController::class, 'index'], ["admin"]);
    $router->get('/students', [StudentsAdminController::class, 'index'], ["admin"]);
    $router->get('/banned-students', [BannedStudentsAdminController::class, 'index'], ["admin"]);
    $router->post('/students/ban/{id}', [BannedStudentsAdminController::class, 'ban'], ["admin"]);
    $router->post('/students/unban/{id}', [BannedStudentsAdminController::class, 'unBan'], ["admin"]);
    $router->get('/unverified-teachers', [UnverifiedTeachersAdminController::class, 'index'], ["admin"]);
    $router->post('/teachers/verify/{id}', [UnverifiedTeachersAdminController::class, 'verify'], ["admin"]);
    $router->get('/categories', [CategoriesAdminController::class, 'index'], ["admin"]);
    $router->post('/categories/store', [CategoriesAdminController::class, 'store'], ["admin"]);
    $router->post('/categories/delete', [CategoriesAdminController::class, 'delete'], ["admin"]);
    $router->get('/tags', [TagsAdminController::class, 'index'], ["admin"]);
    $router->post('/tags/store', [TagsAdminController::class, 'store'], ["admin"]);
    $router->post('/tags/delete', [TagsAdminController::class, 'delete'], ["admin"]);

    $router->get('/login', [LoginController::class, 'index'], ["visitor"]);
    $router->post('/login', [LoginController::class, 'login'], ["visitor"]);
    $router->get('/signup', [SignupController::class, 'index'], ["visitor"]);
    $router->post('/signup', [SignupController::class, 'signup'], ["visitor"]);

    $router->post('/logout', [LoginController::class, 'logout'], ["student", "teacher", "admin"]);

    $router->dispatch($request);