<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900"><?= $course->getTitle() ?></h1>
            <p class="text-gray-600 mt-2"><?= $course->getDescription() ?></p>
        </div>

        <!-- Main Content -->
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">
            <!-- PDF Section -->
            <div class="lg:col-span-2">
                <!-- PDF Viewer -->
                <div class="mb-8">
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg" style="width: 960px; max-width: 100%;">
                        <!-- PDF Controls -->
                        <div class="border-b border-gray-200 p-4 flex items-center justify-between bg-gray-50">
                            <div class="flex items-center space-x-4">
                                <button class="text-gray-700 hover:text-indigo-600 transition" id="zoomOut">
                                    <i class="fas fa-search-minus"></i>
                                </button>
                                <select id="zoomLevel" class="text-sm border-gray-300 rounded-md">
                                    <option value="1" selected>100%</option>
                                    <option value="1.25">125%</option>
                                    <option value="1.5">150%</option>
                                </select>
                                <button class="text-gray-700 hover:text-indigo-600 transition" id="zoomIn">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button class="text-gray-700 hover:text-indigo-600 transition" id="fullscreen">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                        <!-- PDF Container -->
                        <div class="relative bg-gray-100" style="height: 800px;">
                            <iframe 
                                src="<?= $course->getContent() ?>#toolbar=0" 
                                class="w-full h-full"
                                id="pdfViewer"
                            >
                            </iframe>
                        </div>
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
                        <i class="fas fa-star text-yellow-400 mr-3"></i>
                        <span class="text-gray-700">Rating: <?= $course->getRate() ?> (<?= $course->getRatesCount() ?> reviews)</span>
                    </li>
                </ul>

                <!-- Download PDF Button -->
                <div class="mt-6">
                    <a 
                        href="<?= URLASSETS . 'pdfs/ilyass.pdf' ?>" 
                        download
                        class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-200 transition flex items-center justify-center"
                    >
                        <i class="fas fa-download mr-2"></i>
                        Download PDF
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
document.addEventListener('DOMContentLoaded', function() {
    const pdfViewer = document.getElementById('pdfViewer');
    const zoomSelect = document.getElementById('zoomLevel');
    const currentPageEl = document.getElementById('currentPage');
    const totalPagesEl = document.getElementById('totalPages');

    // Zoom controls
    zoomSelect.addEventListener('change', function() {
        const zoom = this.value;
        pdfViewer.style.transform = `scale(${zoom})`;
        pdfViewer.style.transformOrigin = 'top left';
    });

    document.getElementById('zoomIn').addEventListener('click', function() {
        const currentIndex = zoomSelect.selectedIndex;
        if (currentIndex < zoomSelect.options.length - 1) {
            zoomSelect.selectedIndex = currentIndex + 1;
            zoomSelect.dispatchEvent(new Event('change'));
        }
    });

    document.getElementById('zoomOut').addEventListener('click', function() {
        const currentIndex = zoomSelect.selectedIndex;
        if (currentIndex > 0) {
            zoomSelect.selectedIndex = currentIndex - 1;
            zoomSelect.dispatchEvent(new Event('change'));
        }
    });

    // Fullscreen control
    document.getElementById('fullscreen').addEventListener('click', function() {
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            pdfViewer.requestFullscreen();
        }
    });
});
</script>