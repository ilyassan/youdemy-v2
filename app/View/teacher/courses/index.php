<?php $titlePage = "Courses" ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900">Your Courses</h1>
        <p class="mt-4 text-xl text-gray-600">Manage and view your courses here</p>
    </div>

        <!-- Filter Section -->
        <form class="bg-white rounded-xl shadow-lg p-6 mb-12">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <!-- Search Input -->
                <div class="relative flex-1 min-w-44">
                    <input type="text" value="<?= $_GET['keyword'] ?? '' ?>" autocomplete="off" name="keyword" placeholder="Search courses..." class="w-full outline-none pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <div class="flex gap-6 items-center justify-center flex-wrap">
                    <!-- Categories (Custom Dropdown) -->
                    <div class="relative flex-1">
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
                            <i class="fas fa-chevron-down ml-2 text-gray-400"></i>
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

                    <!-- Filter Button -->
                    <div class="flex justify-center flex-1 whitespace-nowrap">
                        <button class="px-10 bg-indigo-600 text-white py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                    </div>
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
                    <p class="text-gray-600 max-w-md mx-auto">
                        We couldn't find any courses matching your criteria. Try adjusting your filters or search terms.
                    </p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($courses as $course):?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="<?= $course->getThumbnail() ?>" alt="Course" class="w-full h-48 object-cover">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded"><?= $course->getCategoryName() ?></span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?= $course->getTitle() ?></h3>
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
                    </div>
                    <div class="flex justify-center mt-4 text-indigo-700">
                        <a href="<?= URLROOT . 'courses/edit/' . $course->getId() ?>" class="hover:underline underline-offset-4">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        <?php endif; ?>
    </div>

    <!-- Add New Course Button -->
    <div class="text-center <?= empty($courses) ? '' : 'mt-10' ?>">
        <a href="<?= URLROOT . 'courses/create' ?>" class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
            Add New Course
        </a>
    </div>
</div>



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