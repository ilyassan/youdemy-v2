<?php $titlePage = "Students" ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Search and Filters Section -->
    <section class="mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars("Students") ?></h3>
                <span class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">
                    <?= count($students) ?> Students
                </span>
            </div>
            <form class="flex flex-col md:flex-row gap-4 justify-between">
                <!-- Search Bar -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="keyword" value="<?= $_GET['keyword'] ?? '' ?>" autocomplete="off" placeholder="Search students..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <!-- Filters -->
                <div class="flex flex-wrap gap-3">
                    <!-- Categories (Custom Dropdown) -->
                    <div class="relative">
                        <input id="selectedStatus_value" type="hidden" name="status" value="<?= $_GET['status'] ?? 'All' ?>">
                        <button
                            type="button"
                            id="statusDropdown"
                            class="flex items-center border border-gray-300 rounded-md px-4 py-2 w-full bg-white text-gray-500 focus:outline-none"
                        >
                            <i class="fas fa-layer-group text-gray-500 mr-2"></i>
                            <span id="selectedStatus">
                                <?= $_GET['status'] ?? 'All' ?>
                            </span>
                            <i class="fas fa-chevron-down ml-2 text-gray-400"></i>
                        </button>
                        <!-- Dropdown Options -->
                        <ul
                            id="statusDropdownMenu"
                            class="absolute dropdown-menu hidden bg-white shadow-md rounded-md w-full mt-2 z-10"
                        >
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectOption('statusDropdown', 'selectedStatus', '<?= htmlspecialchars('All') ?>')"><?= htmlspecialchars("All") ?></li>
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectOption('statusDropdown', 'selectedStatus', '<?= htmlspecialchars('Active') ?>')"><?= htmlspecialchars("Active") ?></li>
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectOption('statusDropdown', 'selectedStatus', '<?= htmlspecialchars('Unactive') ?>')"><?= htmlspecialchars("Unactive") ?></li>
                        </ul>
                    </div>
                    <button class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600">
                        <i class="fas fa-filter mr-2"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </section>

    <?php if (empty($students)): ?>
        <div class="pt-10 px-6">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="h-24 w-24 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-4xl text-indigo-500"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Students Found</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8">
                    <?php if (!empty($_GET['keyword']) || !empty($_GET['status'])): ?>
                        We couldn't find any students matching your search criteria. Try adjusting your filters or try a different search term.
                    <?php else: ?>
                        There are no students registered in the system yet.
                    <?php endif; ?>
                </p>
            </div>
        </div>
    <?php else: ?>
        <!-- Students Table -->
        <section class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Student
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Joined Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Enrolled Courses
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://placehold.co/40x40" alt="Student">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?= $student->getFullName() ?></div>
                                        <div class="text-sm text-gray-500"><?= $student->getEmail() ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= (new DateTime($student->getCreatedAt()))->format('F d, Y') ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= $student->getTotalCourses() ?> courses</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="<?= URLROOT . 'students/ban/' . $student->getId() ?>" method="POST" class="w-fit bg-red-500 px-2 py-1 rounded-lg text-white">
                                    <button class="flex gap-1 items-center"><i class="fas fa-ban"></i>Ban</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endif; ?>

</div>


<script>
    function toggleDropdown(dropdownId, menuId) {
        closeAllDropdowns();
        
        const menu = document.getElementById(menuId);
        menu.classList.toggle('hidden');
    }

    function selectOption(dropdownId, labelId, value) {
        document.getElementById(labelId + "_value").value = value;
        document.getElementById(labelId).innerText = value;
        document.getElementById(dropdownId).classList.remove("text-gray-500");
        document.getElementById(`${dropdownId}Menu`).classList.add('hidden');
    }

    function closeAllDropdowns() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    }

    document.getElementById('statusDropdown').addEventListener('click', function (event) {
        event.stopPropagation();
        toggleDropdown('statusDropdown', 'statusDropdownMenu');
    });

    document.addEventListener('click', function () {
        closeAllDropdowns();
    });
</script>