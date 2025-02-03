<main class="py-8">
    <!-- Signup Container -->
    <div class="sm:mx-auto sm:w-full sm:max-w-xl">
        <!-- Logo/Icon -->
        <div class="flex justify-center">
            <div class="h-12 w-12 rounded-xl bg-indigo-500 flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
        </div>
        
        <!-- Heading -->
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Create your account
        </h2>
    </div>

    <!-- Role Selection -->
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-xl">
        <div class="bg-white py-8 px-4 shadow-lg sm:rounded-xl sm:px-10">
            <!-- Signup Form -->
            <form class="space-y-6" action="<?= URLROOT . 'signup' ?>" method="POST">
                <!-- Role Toggle -->
                <div class="flex justify-center space-x-4 mb-8">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="role" value="student" class="peer sr-only">
                        <div class="w-40 px-4 py-3 bg-white border-2 border-gray-200 rounded-lg peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <i class="fas fa-user-graduate text-xl text-gray-500 peer-checked:text-indigo-600"></i>
                                <span class="font-medium text-gray-700 peer-checked:text-indigo-600">Student</span>
                            </div>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="role" value="teacher" class="peer sr-only">
                        <div class="w-40 px-4 py-3 bg-white border-2 border-gray-200 rounded-lg peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <i class="fas fa-chalkboard-teacher text-xl text-gray-500 peer-checked:text-indigo-600"></i>
                                <span class="font-medium text-gray-700 peer-checked:text-indigo-600">Teacher</span>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Name Fields -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                            First name
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input
                                type="text"
                                autocomplete="off"
                                name="first_name"
                                id="first_name"
                                class="block outline-none w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter first name"
                            >
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                            Last name
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input
                                type="text"
                                autocomplete="off"
                                name="last_name"
                                id="last_name"
                                class="block outline-none w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter last name"
                            >
                        </div>
                    </div>
                </div>

                <!-- Email -->
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
                            autocomplete="off"
                            name="email"
                            id="email"
                            class="block outline-none w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter your email"
                        >
                    </div>
                </div>

                <!-- Password -->
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
                            placeholder="Create password"
                        >
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">
                        Confirm password
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            type="password"
                            name="confirm_password"
                            id="confirm_password"
                            class="block outline-none w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Confirm password"
                        >
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-center">
                    <input
                        id="terms"
                        name="terms"
                        value="accept"
                        type="checkbox"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    >
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        I agree to the
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Terms of Service</a>
                        and
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                    >
                        Create account
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>

            <!-- Already have account -->
            <p class="mt-6 text-center text-sm text-gray-600">
                Already have an account?
                <a href="<?= URLROOT . 'login' ?>" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Login
                </a>
            </p>
        </div>
    </div>
</main>