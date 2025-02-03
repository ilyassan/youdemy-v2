<main>
    <!-- Improved Hero Section with AI Learning Assistant -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid md:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Personalized Learning, Powered by AI</h1>
                <p class="text-lg md:text-xl mb-8 text-indigo-100">Experience adaptive learning paths tailored to your goals, pace, and learning style.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="<?= URLROOT . 'courses' ?>" class="bg-white text-indigo-600 px-8 py-3 rounded-full font-medium hover:bg-indigo-50 transition">
                        Start Learning
                    </a>
                </div>
            </div>
            <div class="relative hidden md:block">
                <img src="<?= URLASSETS . 'images/Elearning_platform.jpg' ?>" alt="Learning Dashboard" class="rounded-lg shadow-xl">
                <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-lg shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-robot text-3xl text-indigo-600"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800">AI Learning Assistant</h3>
                            <p class="text-sm text-gray-600">24/7 personalized support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Categories Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Browse by Category</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <a href="<?= URLROOT . 'courses?category_id='. $categories[0]['id'] ?>" class="group">
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all transform hover:-translate-y-1 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-laptop-code text-2xl text-indigo-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600"><?= $categories[0]["name"] ?></h3>
                            <p class="text-sm text-gray-500"><?= $categories[0]["courses_count"] ?>+ courses</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="<?= URLROOT . 'courses?category_id='. $categories[1]['id'] ?>" class="group">
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all transform hover:-translate-y-1 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-pie text-2xl text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600"><?= $categories[1]["name"] ?></h3>
                            <p class="text-sm text-gray-500"><?= $categories[1]["courses_count"] ?>+ courses</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="<?= URLROOT . 'courses?category_id='. $categories[2]['id'] ?>" class="group">
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all transform hover:-translate-y-1 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-paint-brush text-2xl text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600"><?= $categories[2]["name"] ?></h3>
                            <p class="text-sm text-gray-500"><?= $categories[2]["courses_count"] ?>+ courses</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="<?= URLROOT . 'courses?category_id='. $categories[3]['id'] ?>" class="group">
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all transform hover:-translate-y-1 border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-language text-2xl text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-green-600"><?= $categories[3]["name"] ?></h3>
                            <p class="text-sm text-gray-500"><?= $categories[3]["courses_count"] ?>+ courses</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Popular Tags Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Popular Topics</h3>
            <div class="flex flex-wrap gap-3">
            <?php
            // Define an array of colors
            $colors = ['indigo', 'blue', 'purple', 'green', 'red', 'orange'];

            ?>

            <div class="flex flex-wrap gap-3">
                <?php foreach ($topTags as $key => $tag): ?>
                    <?php 
                        // Pick a random color from the colors array
                        $color = $colors[$key];
                    ?>
                    <a href="<?= URLROOT . 'courses?keyword='. $tag->getName() ?>" 
                        class="px-6 py-2 bg-white text-<?= $color ?>-600 rounded-full text-sm font-medium border border-<?= $color ?>-100 hover:bg-<?= $color ?>-50 hover:border-<?= $color ?>-200 transition-all">
                        <?= htmlspecialchars($tag->getName()) ?>
                    </a>
                <?php endforeach; ?>
            </div>
            </div>
        </div>
    </div>

    <!-- Featured Courses Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Featured Courses</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php foreach($topThreeCourses as $course): ?>
            <div class="bg-white flex flex-col rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition-all">
                <div class="relative">
                    <img src="<?= $course->getThumbnail() ?>" alt="UI/UX Design" class="w-full h-48 object-cover">
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400">
                                <?php
                                    $fullStars = floor($course->getRate());
                                    $halfStar = ($course->getRate() - $fullStars) >= 0.5 ? 1 : 0;
                                    $emptyStars = 5 - $fullStars - $halfStar;

                                    for ($i = 0; $i < $fullStars; $i++) {
                                        echo '<i class="fas fa-star"></i>';
                                    }
                                    if ($halfStar) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    }
                                    for ($i = 0; $i < $emptyStars; $i++) {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                ?>
                            </div>
                            <span class="text-sm text-gray-500 ml-2">(<?= $course->getRate() ?>) · <?= $course->getRatesCount() ?> ratings</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600"><?= $course->getTitle() ?></h3>
                        <p class="text-gray-600 text-sm mb-4"><?= $course->getDescription() ?></p>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <img src="https://placehold.co/32x32" alt="Instructor" class="w-8 h-8 rounded-full">
                                <span class="text-sm text-gray-600"><?= $course->getTeacherName() ?></span>
                            </div>
                            <span class="text-2xl font-bold text-gray-900">$<?= number_format($course->getPrice(), 2) ?></span>
                        </div>
                        <a href="<?= URLROOT . 'courses/' . $course->getId() ?>" class="w-full block text-center mt-6 bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                            Enroll
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
        </div>

        <div class="text-center mt-12">
            <a href="<?= URLROOT . 'courses' ?>" class="px-8 py-3 bg-white text-indigo-600 rounded-lg font-medium border border-indigo-200 hover:bg-indigo-50 transition-all">
                View All Courses
            </a>
        </div>
    </div>

    <!-- Learning Paths Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Curated Learning Paths</h2>
            <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">View All Paths →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                    <i class="fas fa-code text-4xl text-white mb-4"></i>
                    <h3 class="text-xl font-bold text-white">Full-Stack Development</h3>
                    <p class="text-blue-100 mt-2">Master modern web development</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <i class="fas fa-clock mr-2"></i>
                        6 months · 20 courses
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-gray-700">Industry-aligned curriculum</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-gray-700">1-on-1 mentorship</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-gray-700">Real-world projects</span>
                        </div>
                    </div>
                    <button class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                        Explore Path
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                    <i class="fas fa-brain text-4xl text-white mb-4"></i>
                    <h3 class="text-xl font-bold text-white">AI & Machine Learning</h3>
                    <p class="text-purple-100 mt-2">Build intelligent systems</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <i class="fas fa-clock mr-2"></i>
                        8 months · 25 courses
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-gray-700">Advanced algorithms</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-gray-700">Cloud integration</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-gray-700">Research papers access</span>
                        </div>
                    </div>
                    <button class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                        Explore Path
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 p-6">
                    <i class="fas fa-chart-line text-4xl text-white mb-4"></i>
                    <h3 class="text-xl font-bold text-white">Data Analytics</h3>
                    <p class="text-orange-100 mt-2">Drive data-based decisions</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <i class="fas fa-clock mr-2"></i>
                        5 months · 18 courses
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-gray-700">Business intelligence</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-gray-700">Statistical analysis</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-gray-700">Visualization mastery</span>
                        </div>
                    </div>
                    <button class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                        Explore Path
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Learning Features -->
    <div class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Learn by Doing</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-vr-cardboard text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Virtual Labs</h3>
                    <p class="text-gray-600">Practice in real-time with interactive simulations and virtual environments.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-users text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Peer Learning</h3>
                    <p class="text-gray-600">Collaborate with peers worldwide on projects and problem-solving sessions.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-trophy text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Skill Challenges</h3>
                    <p class="text-gray-600">Test your knowledge with industry-standard assessments and earn certificates.</p>
                </div>
            </div>
        </div>
    </div>
</main>