<main class="py-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo/Icon -->
        <div class="flex justify-center">
            <div class="h-12 w-12 rounded-xl bg-indigo-500 flex items-center justify-center">
                <i class="fas fa-user text-white text-xl"></i>
            </div>
        </div>
        
        <!-- Heading -->
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Welcome back
        </h2>
    </div>

    <!-- Login Form -->
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-lg sm:rounded-xl sm:px-10">
            <form class="space-y-6" action="<?= URLROOT . 'login' ?>" method="POST">
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="block outline-none w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter your email"
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="block outline-none w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter your password"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center items-center gap-2 py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                    >
                        Sign in
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>

            <!-- Sign Up Link -->
            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="<?= URLROOT . 'signup' ?>" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Sign Up
                </a>
            </p>
        </div>
    </div>
</main>