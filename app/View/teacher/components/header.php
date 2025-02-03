<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href=<?= URLASSETS ."css/all.min.css"?> rel="stylesheet" />
    <link href=<?= URLASSETS ."css/fontawesome.min.css"?> rel="stylesheet" />
    <link href=<?= URLASSETS ."css/output.css"?> rel="stylesheet" />
</head>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed overflow-y-scroll no-scrollbar top-0 left-0 h-screen w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 border-b">
            <span class="text-indigo-600 font-bold text-2xl">YouDemy</span>
        </div>
    
        <?php
            function isActive($path, $useBase = true)
            {
                $reference = $useBase ? baseUrl() : requestPath();
                return (URLROOT . $path) == $reference ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-100';
            }
        ?>

        <!-- Navigation Menu -->
        <nav class="py-4">
            <!-- User Info -->
            <div class="px-4 mb-3">
                <div class="flex items-center gap-3 px-4 py-2 text-gray-600">
                    <i class="fas fa-user-circle text-xl"></i>
                    <span class="font-medium"><?= user()->getFullName() ?></span>
                </div>
            </div>
    
            <!-- Sidebar Links -->
            <div class="px-4 space-y-1">
                <!-- Dashboard -->
                <a href="<?= URLROOT ?>" class="<?= isActive("") ?> flex items-center gap-3 px-4 py-2 rounded-lg">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
    
                <!-- Course Management Section -->
                <div class="space-y-1 pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Courses</p>
                    <a href="<?= URLROOT . 'courses' ?>" class="<?= isActive("courses", false) ?> flex items-center gap-3 px-4 py-2 rounded-lg">
                        <i class="fas fa-book"></i>
                        <span>My Courses</span>
                    </a>
                    <a href="<?= URLROOT . 'courses/create' ?>" class="<?= isActive("courses/create", false) ?> flex items-center gap-3 px-4 py-2 rounded-lg">
                        <i class="fas fa-plus-circle"></i>
                        <span>Create Course</span>
                    </a>
                </div>
    
                <!-- Student Management Section -->
                <div class="space-y-1 pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Students</p>
                    <a href="<?= URLROOT . 'students' ?>" class="<?= isActive("students") ?> flex items-center gap-3 px-4 py-2 rounded-lg">
                        <i class="fas fa-users"></i>
                        <span>All Students</span>
                    </a>
                </div>
    
                <!-- Logout Section -->
                <form action="<?= URLROOT . 'logout' ?>" method="POST" class="space-y-1 pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Logout</p>
                    <button class="w-full flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>
    <main class="lg:ml-64 min-h-screen flex flex-col-reverse">
        <div class="p-4 bg-gray-100 min-h-screen">
