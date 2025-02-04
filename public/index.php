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

    $router->get('/', [HomePage::class, 'index'], ["visitor", "student"]);
    $router->get('/courses', [CoursesPage::class, 'index'], ["visitor", "student"]);
    $router->post('/courses/enroll/{id}', [CoursesPage::class, 'enroll'], ["student"]);
    $router->post('/courses/completed/{id}', [CoursesPage::class, 'completed'], ["student"]);
    $router->get('/courses/content/{id}', [CourseContentPage::class, 'index'], ["visitor", "student"]);
    $router->get('/courses/{id}', [CoursesPage::class, 'show'], ["visitor", "student"]);
    $router->get('/my-courses', [MyCoursesPage::class, 'index'], ["student"]);

    $router->post('/api/rate/create', [MyCoursesPage::class, 'rateCourse'], ["student"]);
    $router->post('/api/rate/delete', [MyCoursesPage::class, 'deleteCourseRate'], ["student"]);

    $router->get('/', [DashboardTeacherPage::class, 'index'], ["teacher"]);
    $router->get('/courses', [CoursesTeacherPage::class, 'index'], ["teacher"]);
    $router->get('/courses/create', [CoursesTeacherPage::class, 'create'], ["teacher"]);
    $router->post('/courses/store', [CoursesTeacherPage::class, 'store'], ["teacher"]);
    $router->get('/courses/edit/{id}', [CoursesTeacherPage::class, 'edit'], ["teacher"]);
    $router->post('/courses/update/{id}', [CoursesTeacherPage::class, 'update'], ["teacher"]);
    $router->post('/courses/delete/{id}', [CoursesTeacherPage::class, 'delete'], ["teacher"]);
    $router->get('/students', [StudentsTeacherPage::class, 'index'], ["teacher"]);

    $router->get('/', [DashboardAdminPage::class, 'index'], ["admin"]);
    $router->get('/courses', [CoursesAdminPage::class, 'index'], ["admin"]);
    $router->get('/courses/{id}', [CoursesAdminPage::class, 'show'], ["admin"]);
    $router->post('/courses/delete/{id}', [CoursesAdminPage::class, 'delete'], ["admin"]);
    $router->get('/teachers', [TeachersAdminPage::class, 'index'], ["admin"]);
    $router->get('/students', [StudentsAdminPage::class, 'index'], ["admin"]);
    $router->get('/banned-students', [BannedStudentsAdminPage::class, 'index'], ["admin"]);
    $router->post('/students/ban/{id}', [BannedStudentsAdminPage::class, 'ban'], ["admin"]);
    $router->post('/students/unban/{id}', [BannedStudentsAdminPage::class, 'unBan'], ["admin"]);
    $router->get('/unverified-teachers', [UnverifiedTeachersAdminPage::class, 'index'], ["admin"]);
    $router->post('/teachers/verify/{id}', [UnverifiedTeachersAdminPage::class, 'verify'], ["admin"]);
    $router->get('/categories', [CategoriesAdminPage::class, 'index'], ["admin"]);
    $router->post('/categories/store', [CategoriesAdminPage::class, 'store'], ["admin"]);
    $router->post('/categories/delete', [CategoriesAdminPage::class, 'delete'], ["admin"]);
    $router->get('/tags', [TagsAdminPage::class, 'index'], ["admin"]);
    $router->post('/tags/store', [TagsAdminPage::class, 'store'], ["admin"]);
    $router->post('/tags/delete', [TagsAdminPage::class, 'delete'], ["admin"]);

    $router->get('/login', [LoginPage::class, 'index'], ["visitor"]);
    $router->post('/login', [LoginPage::class, 'login'], ["visitor"]);
    $router->get('/signup', [SignupPage::class, 'index'], ["visitor"]);
    $router->post('/signup', [SignupPage::class, 'signup'], ["visitor"]);

    $router->post('/logout', [LoginPage::class, 'logout'], ["student", "teacher", "admin"]);

    $router->dispatch($request);