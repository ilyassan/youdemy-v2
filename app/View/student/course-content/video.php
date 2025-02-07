<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900"><?= $course->getTitle() ?></h1>
            <p class="text-gray-600 mt-2"><?= $course->getDescription() ?></p>
        </div>

        <!-- Main Content -->
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">
            <!-- Video Section -->
            <div class="lg:col-span-2">
                <!-- Video Player -->
                <div class="mb-8">
                    <div class="rounded-lg overflow-hidden shadow-lg bg-black relative" style="width: 960px; height: 540px; max-width: 100%;">
                        <video 
                            id="courseVideo"
                            class="w-full h-full"
                            controlsList="nodownload"
                            controls
                        >
                            <source src="<?= $course->getContent() ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>

                <!-- Course Description -->
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900">About this course</h2>
                    <p class="text-gray-700 mt-3">
                        Embark on your journey to becoming a full-stack web developer! This course will guide you through modern web development techniques, helping you master HTML, CSS, JavaScript, and back-end technologies.
                    </p>
                </div>

                <!-- Mark as Completed Button -->
                <form action="<?= URLROOT . 'courses/completed/' . $course->getId() ?>" method="POST">
                    <button class="w-full bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                        Mark Course as Completed
                    </button>
                </form>
            </div>

            <!-- Sidebar: Course Details -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <!-- Course Info -->
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Course Details</h3>
                <ul class="space-y-4">
                    <li class="flex items-center">
                        <i class="fas fa-users text-indigo-600 mr-3"></i>
                        <span class="text-gray-700"><?= $course->getEnrollmentsCount() ?> students enrolled</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-clock text-indigo-600 mr-3"></i>
                        <span class="text-gray-700">Duration: <span id="videoDuration">Calculating...</span></span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-star text-yellow-400 mr-3"></i>
                        <span class="text-gray-700">Rating: <?= $course->getRate() ?> (<?= $course->getRatesCount() ?> reviews)</span>
                    </li>
                </ul>

                <!-- New Certification Download Button -->
                <div class="mt-6 space-y-3">
                    <a 
                        href="<?= URLROOT . 'courses/certify/' . $course->getId() ?>"
                        class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white py-3 rounded-lg font-medium hover:from-indigo-700 hover:to-indigo-800 transition flex items-center justify-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                    >
                        <i class="fas fa-certificate mr-2"></i>
                        Download Certificate
                    </a>
                </div>

                <!-- Related Courses -->
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Related Courses</h4>
                    <div class="space-y-4">
                        <?php foreach ($relatedCourses as $course):?>
                        <div class="flex items-center gap-4">
                            <img src="<?= $course->getThumbnail() ?>" alt="Course Image" class="w-20 h-20 rounded-lg object-cover">
                            <div>
                                <h5 class="text-sm font-medium text-gray-900"><?= $course->getTitle() ?></h5>
                                <a href="<?= URLROOT . 'courses/' . $course->getId() ?>" class="text-indigo-600 text-sm hover:underline">View Course</a>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const video = document.getElementById("courseVideo");
    const durationElement = document.getElementById("videoDuration");

    video.addEventListener("loadedmetadata", function () {
        const duration = video.duration;
        const hours = Math.floor(duration / 3600);
        const minutes = Math.floor((duration % 3600) / 60);
        const seconds = Math.floor(duration % 60);

        durationElement.textContent = `${hours > 0 ? hours + 'h ' : ''}${minutes}m ${seconds}s`;
    });
</script>
