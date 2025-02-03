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
            <span class="text-indigo-600 font-bold text-2xl">YouDemy Admin</span>
        </div>
    
        <!-- Navigation Menu -->
        <nav class="py-4">
            <?php
                function isActive($path)
                {
                    return (URLROOT . $path) == baseUrl() ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-100';
                }
            ?>

            <!-- Admin Info -->
            <div class="px-4 mb-3">
                <div class="flex items-center gap-3 px-4 py-2 text-gray-600">
                    <i class="fas fa-user-shield text-xl"></i>
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
    
                <!-- Content Management -->
                <div class="space-y-1 pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Content Management</p>
                    <a href="<?= URLROOT . 'categories' ?>" class="<?= isActive("categories") ?> flex items-center gap-3 px-4 py-2 rounded-lg">
                        <i class="fas fa-folder"></i>
                        <span>Categories</span>
                    </a>
                    <a href="<?= URLROOT . 'tags' ?>" class="<?= isActive("tags") ?> flex items-center gap-3 px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-tags"></i>
                        <span>Tags</span>
                    </a>
                </div>

                <!-- Course Management Section -->
                <div class="space-y-1 pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Courses</p>
                    <a href="<?= URLROOT . 'courses' ?>" class="<?= isActive("courses") ?> flex items-center gap-3 px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-book"></i>
                        <span>Explore Courses</span>
                    </a>
                </div>
    
                <!-- Teacher Management -->
                <div class="space-y-1 pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Teacher Management</p>
                    <a href="<?= URLROOT . 'teachers' ?>" class="<?= isActive("teachers") ?> flex items-center gap-3 px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Verified Teachers</span>
                    </a>
                    <a href="<?= URLROOT . 'unverified-teachers' ?>" class="<?= isActive("unverified-teachers") ?> flex items-center gap-3 px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-user-clock"></i>
                        <span>Unverified Teachers</span>
                    </a>
                </div>
    
                <!-- Student Management -->
                <div class="space-y-1 pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Student Management</p>
                    <a href="<?= URLROOT . 'students' ?>" class="<?= isActive("students") ?> flex items-center gap-3 px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-user-graduate"></i>
                        <span>Active Students</span>
                    </a>
                    <a href="<?= URLROOT . 'banned-students' ?>" class="<?= isActive("banned-students") ?> flex items-center gap-3 px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-user-slash"></i>
                        <span>Banned Students</span>
                    </a>
                </div>
    
                <!-- Logout Section -->
                <form action="<?= URLROOT . 'logout' ?>" method="POST" class="space-y-1 pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Account</p>
                    <button class="flex w-full items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>
    <main class="lg:ml-64 min-h-screen flex flex-col-reverse">
    <div class="p-4 bg-gray-100 min-h-screen">