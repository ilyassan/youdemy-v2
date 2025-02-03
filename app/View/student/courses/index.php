<!-- Main Container -->
<section class="bg-gray-50 py-12">
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900">Explore Our Courses</h1>
            <p class="mt-4 text-xl text-gray-600">Discover the perfect course to advance your skills and career</p>
        </div>

        <!-- Filter Section -->
        <form class="bg-white rounded-xl shadow-lg p-6 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-6 items-center">
                <!-- Search Input -->
                <div class="relative">
                    <input type="text" autocomplete="off" value="<?= $_GET['keyword'] ?? '' ?>" name="keyword" placeholder="Search courses..." class="w-full outline-none pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>

                <!-- Categories (Custom Dropdown) -->
                <div class="relative">
                    <input id="category_id" type="hidden" name="category_id" value="">
                    <button
                        type="button"
                        id="categoriesDropdown"
                        class="flex items-center border border-gray-300 rounded-md px-4 py-2 w-full bg-white text-gray-500 focus:outline-none"
                    >
                        <i class="fas fa-layer-group text-gray-500 mr-2"></i>
                        <span id="selectedCategories">
                            <?= htmlspecialchars(($category = current(array_filter($categories, fn($cat) => $cat->getId() == ($_GET['category_id'] ?? 0)))) ? $category->getName() : "Categories") ?>
                        </span>
                        <i class="fas fa-chevron-down ml-auto text-gray-400"></i>
                    </button>
                    <!-- Dropdown Options -->
                    <ul
                        id="categoriesDropdownMenu"
                        class="absolute dropdown-menu hidden bg-white shadow-md rounded-md w-full mt-2 z-10"
                    >
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectOption('categoriesDropdown', 'selectedCategories', '<?= htmlspecialchars('All') ?>')"><?= htmlspecialchars("All") ?></li>
                        <?php foreach ($categories as $category): ?>
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectOption('categoriesDropdown', 'selectedCategories', '<?= htmlspecialchars($category->getName()) ?>', '<?= htmlspecialchars($category->getId()) ?>')"><?= htmlspecialchars($category->getName()) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Min Price -->
                <div class="group">
                    <div class="flex items-center border border-gray-300 rounded-md px-4 py-2 group-focus-within:ring-2 group-focus-within:ring-indigo-500 group-focus-within:border-indigo-500">
                        <i class="fas fa-dollar-sign text-gray-500"></i>
                        <input
                            id="min_price"
                            type="number"
                            value="<?= $_GET['min_price'] ?? '' ?>"
                            name="min_price"
                            placeholder="Min Price"
                            class="ml-2 text-gray-500 focus:outline-none w-full"
                        />
                    </div>
                </div>
                
                <!-- Max Price -->
                <div class="group">
                    <div class="flex items-center border border-gray-300 rounded-md px-4 py-2 group-focus-within:ring-2 group-focus-within:ring-indigo-500 group-focus-within:border-indigo-500">
                        <i class="fas fa-dollar-sign text-gray-500"></i>
                        <input
                            id="max_price"
                            type="number"
                            value="<?= $_GET['max_price'] ?? '' ?>"
                            name="max_price"
                            placeholder="Max Price"
                            class="ml-2 text-gray-500 focus:outline-none w-full"
                        />
                    </div>
                </div>

                <!-- Filter Button -->
                <div class="col-span-1 md:col-span-4 flex justify-center">
                    <button class="px-10 bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Course Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
        <?php if (empty($courses)): ?>
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <div class="rounded-xl p-8 text-center">
                    <div class="flex justify-center mb-6">
                        <i class="fas fa-book-open text-6xl text-indigo-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        No Courses Found
                    </h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        We couldn't find any courses matching your criteria. Try adjusting your filters or search terms.
                    </p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($courses as $course): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="<?= $course->getThumbnail() ?>" alt="Course" class="w-full h-48 object-cover">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded"><?= $course->getCategoryName() ?></span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?= $course->getTitle() ?></h3>
                    <p class="text-gray-600 text-sm mb-4"><?= $course->getDescription() ?></p>
                    <div class="flex items-center mb-4">
                        <img src="https://placehold.co/32x32" alt="Instructor" class="w-8 h-8 rounded-full">
                        <span class="ml-2 text-sm text-gray-600"><?= $course->getTeacherName() ?></span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span class="flex items-center">
                            <i class="fas fa-user-graduate mr-2"></i>
                            <?= $course->getEnrollmentsCount() ?> students
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
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
                            <span class="ml-2 text-sm text-gray-600">(<?= $course->getRate() ?>)</span>
                        </div>
                        <span class="text-2xl font-bold text-indigo-600">$<?= number_format($course->getPrice(), 2) ?></span>
                    </div>
                </div>
                <div class="px-6 pb-6">
                    <a href="<?= URLROOT . 'courses/' . $course->getId() ?>" class="w-full block text-center bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                        Enroll Now
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            <nav role="navigation" aria-label="Pagination Navigation">
                <ul class="flex items-center space-x-2">
                    <?php
                    $coursesPerPage = 10;
                    $totalPages = ceil($coursesTotalCount / $coursesPerPage);
                    $currentPage = (int) ($_GET['page'] ?? 1);

                    if ($currentPage < 1) {
                        $currentPage = 1;
                    } elseif ($currentPage > $totalPages) {
                        $currentPage = $totalPages;
                    }

                    $visiblePages = 5;
                    $halfVisible = floor($visiblePages / 2);

                    $startPage = max(1, $currentPage - $halfVisible);
                    $endPage = min($totalPages, $currentPage + $halfVisible);

                    if ($currentPage <= $halfVisible) {
                        $endPage = min($visiblePages, $totalPages);
                    } elseif ($currentPage + $halfVisible > $totalPages) {
                        $startPage = max(1, $totalPages - $visiblePages + 1);
                    }

                    $previousPage = ($currentPage > 1) ? $currentPage - 1 : null;
                    $nextPage = ($currentPage < $totalPages) ? $currentPage + 1 : null;
                    ?>

                    <!-- Previous Button -->
                    <li>
                        <a href="<?= $previousPage ? "?page=" . htmlspecialchars($previousPage) : '#' ?>"
                           class="px-4 py-2 rounded-md bg-white text-gray-500 hover:bg-gray-100 <?= !$previousPage ? 'opacity-50 cursor-not-allowed' : '' ?>"
                           <?= !$previousPage ? 'aria-disabled="true"' : '' ?>>
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>

                    <!-- First Page -->
                    <?php if ($startPage > 1): ?>
                        <li>
                            <a href="?page=1" class="px-4 py-2 rounded-md bg-white text-gray-700 hover:bg-gray-100">1</a>
                        </li>
                        <!-- Ellipsis -->
                        <?php if ($startPage > 2): ?>
                            <li>
                                <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-700">...</span>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li>
                            <a href="?page=<?= htmlspecialchars($i) ?>"
                               class="px-4 py-2 rounded-md <?= $i == $currentPage ? 'bg-indigo-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-indigo-400' ?>">
                                <?= htmlspecialchars($i) ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Last Page -->
                    <?php if ($endPage < $totalPages): ?>
                        <!-- Ellipsis -->
                        <?php if ($endPage < $totalPages - 1): ?>
                            <li>
                                <span class="px-4 py-2 rounded-md bg-gray-100 text-gray-700">...</span>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="?page=<?= htmlspecialchars($totalPages) ?>" class="px-4 py-2 rounded-md bg-white text-gray-700 hover:bg-gray-100">
                                <?= htmlspecialchars($totalPages) ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Next Button -->
                    <li>
                        <a href="<?= $nextPage ? "?page=" . htmlspecialchars($nextPage) : '#' ?>"
                           class="px-4 py-2 rounded-md bg-white text-gray-500 hover:bg-gray-100 <?= !$nextPage ? 'opacity-50 cursor-not-allowed' : '' ?>"
                           <?= !$nextPage ? 'aria-disabled="true"' : '' ?>>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</section>


<script>
        function toggleDropdown(dropdownId, menuId) {
        closeAllDropdowns();
        
        const menu = document.getElementById(menuId);
        menu.classList.toggle('hidden');
    }

    function selectOption(dropdownId, labelId, value, id = '') {
        document.getElementById("category_id").value = id;
        document.getElementById(labelId).innerText = value;
        document.getElementById(`${dropdownId}Menu`).classList.add('hidden');
    }

    function closeAllDropdowns() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    }

    // Event listeners for dropdown toggles
    document.getElementById('categoriesDropdown').addEventListener('click', function (event) {
        event.stopPropagation();
        toggleDropdown('categoriesDropdown', 'categoriesDropdownMenu');
    });

    document.addEventListener('click', function () {
        closeAllDropdowns();
    });
</script>