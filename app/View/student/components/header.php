<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - Transform Your Learning Journey</title>
    <link href=<?= URLASSETS ."css/all.min.css"?> rel="stylesheet" />
    <link href=<?= URLASSETS ."css/fontawesome.min.css"?> rel="stylesheet" />
    <link href=<?= URLASSETS ."css/output.css"?> rel="stylesheet" />
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <a href="<?= URLROOT ?>" class="flex items-center">
                        <span class="text-indigo-600 text-3xl font-bold">YouDemy</span>
                    </a>
                </div>

                <?php
                    function isActive($path, $useBase = true)
                    {
                        $reference = $useBase ? baseUrl() : requestPath();
                        return (URLROOT . $path) == $reference ? 'text-indigo-700' : 'text-gray-700 hover:text-indigo-600';
                    }
                ?>
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600" aria-label="Open navigation">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?= URLROOT ?>" class="<?= isActive('') ?> flex items-center">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                    <a href="<?= URLROOT . 'courses'?>" class="<?= isActive('courses') ?> flex items-center">
                        <i class="fas fa-book mr-2"></i>
                        Courses
                    </a>
                    <?php if(isLoggedIn() && user()->isStudent()): ?>
                    <a href="<?= URLROOT . 'my-courses'?>" class="<?= isActive('my-courses') ?> flex items-center">
                        <i class="fas fa-user-graduate mr-2"></i>
                        My Courses
                    </a>
                    <form action="<?= URLROOT . 'logout'?>" method="POST">
                        <button class="text-red-500 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                    <?php else: ?>
                    <a href="<?= URLROOT . 'login'?>" class="bg-indigo-600 text-white px-6 py-2 rounded-full font-medium hover:bg-indigo-700 transition">
                        Get Started
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="mobile-menu absolute top-full left-0 w-full bg-white shadow-md z-50 hidden md:hidden" id="mobile-menu">
            <div class="px-4 py-2 border-b border-gray-200">
                <input type="text" class="w-full px-4 py-2 rounded-md bg-gray-100 focus:ring-2 focus:ring-indigo-500" placeholder="Search...">
            </div>
            <a href="<?= URLROOT?>" class="block px-4 py-3 text-gray-800 hover:bg-gray-100 border-b border-gray-200">Home</a>
            <a href="<?= URLROOT . 'courses'?>" class="block px-4 py-3 text-gray-800 hover:bg-gray-100 border-b border-gray-200">Courses</a>
            <a href="<?= URLROOT . 'my-courses'?>" class="block px-4 py-3 text-gray-800 hover:bg-gray-100 border-b border-gray-200">My Courses</a>
            <a href="<?= URLROOT . 'logout'?>" class="block px-4 py-3 text-gray-800 hover:bg-gray-100 border-b border-gray-200">Logout</a>
            <button class="block w-full px-4 py-3 text-center bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">
                Get Started
            </button>
        </div>
    </nav>