<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Course Header -->
        <div class="mb-12 lg:flex lg:items-start lg:justify-between gap-12">
            <!-- Course Details -->
            <div class="lg:w-1/2">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight"><?= $course->getTitle() ?></h1>
                <p class="text-indigo-600 font-medium text-lg mb-6"><?= $course->getCategoryName() ?></p>
                <p class="text-gray-700 text-base leading-relaxed mb-6">
                    <?= $course->getDescription() ?>
                </p>

                <div class="mb-6">
                    <span class="text-3xl font-bold text-indigo-600">$<?= number_format($course->getPrice(), 2) ?></span>
                    <span class="text-gray-500 line-through ml-3">$<?= number_format($course->getPrice() * 1.25, 2) ?></span>
                </div>

                <form action="<?= URLROOT . 'courses/enroll/' . $course->getId() ?>" method="POST">
                    <button class="w-full bg-indigo-600 text-white py-3 rounded-lg font-medium text-lg hover:bg-indigo-700 transition duration-300 shadow-lg mb-6">
                        Enroll Now
                    </button>
                </form>

                <div class="flex flex-wrap items-center gap-4 mb-6 text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        <span><?= $course->getEnrollmentsCount() ?> students</span>
                    </div>
                    <div class="flex items-center text-yellow-400">
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
                        <span class="ml-2 text-gray-600">(<?= $course->getRate() ?>)</span>
                    </div>
                </div>

                <p class="text-gray-600 text-sm">30-Day Money-Back Guarantee</p>
            </div>

            <!-- Course Thumbnail -->
            <div class="lg:w-1/2">
                <div class="rounded-xl overflow-hidden shadow-xl transform hover:scale-105 transition duration-300">
                    <img src="<?= $course->getThumbnail() ?>" alt="The Complete Guide to Web Development" class="w-full object-cover aspect-video">
                </div>
            </div>
        </div>

        <!-- Course Content -->
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">
            <div class="lg:col-span-2">
                <!-- About the Course -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">About this course</h2>
                    <p class="text-gray-700 leading-relaxed">
                        This course is designed to provide you with the skills needed to become a proficient web developer. You'll learn everything from front-end technologies to back-end development, databases, and beyond.
                    </p>
                </div>

                <!-- What You'll Learn -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">What you'll learn</h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-3">
                        <li>Master the fundamentals of HTML, CSS, and JavaScript.</li>
                        <li>Build responsive and user-friendly web layouts with Tailwind CSS.</li>
                        <li>Work with popular JavaScript frameworks like React.</li>
                        <li>Develop server-side logic using Node.js and Express.</li>
                        <li>Manage and interact with databases using MongoDB.</li>
                    </ul>
                </div>

                <!-- Instructor Info -->
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Meet your instructor</h2>
                    <div class="flex items-center gap-6">
                        <img src="https://placehold.co/100x100" alt="Instructor" class="w-20 h-20 rounded-full object-cover shadow-lg">
                        <div>
                            <h3 class="text-xl font-medium text-gray-900"><?= $course->getTeacherName() ?></h3>
                            <p class="text-gray-600">Full-Stack Developer & Educator</p>
                            <p class="text-gray-700 mt-2 text-sm leading-relaxed">
                                John has over 10 years of experience in web development and a passion for teaching. He specializes in creating dynamic and engaging learning experiences.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="bg-white rounded-xl shadow-lg p-6 h-fit">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Frequently asked questions</h2>
                <div class="space-y-6">
                    <div>
                        <h4 class="font-medium text-gray-800">Will I get a certificate?</h4>
                        <p class="text-gray-700 text-sm">Yes, you'll receive a certificate upon completing the course.</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">What are the prerequisites?</h4>
                        <p class="text-gray-700 text-sm">No prior experience needed; just basic computer literacy.</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">How long will I have access?</h4>
                        <p class="text-gray-700 text-sm">You'll have lifetime access after enrolling.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Courses -->
        <div class="mt-16">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Related courses</h2>
            <?php
            // Define an array of colors
            $colors = ['indigo', 'blue', 'purple', 'green', 'red', 'orange'];
            ?>

            <div class="flex flex-wrap gap-3 mb-4">
                <?php foreach ($course->getTags() as $key => $tag): ?>
                    <?php 
                        // Pick a random color from the colors array
                        $color = $colors[$key % count($colors)];
                    ?>
                    <a href="#" 
                        class="px-6 py-2 bg-white text-<?= $color ?>-600 rounded-full text-sm font-medium border border-<?= $color ?>-100 hover:bg-<?= $color ?>-50 hover:border-<?= $color ?>-200 transition-all">
                        <?= htmlspecialchars($tag) ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($relatedCourses as $course):?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                    <img src="<?= $course->getThumbnail() ?>" alt="Course" class="w-full object-cover h-48">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900"><?= $course->getTitle() ?></h3>
                        <p class="text-gray-600 text-sm mt-2"><?= $course->getDescription() ?></p>
                        <a href="<?= URLROOT . 'courses/' . $course->getId() ?>" class="text-indigo-600 font-medium hover:text-indigo-700 mt-4 block">Learn More</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
