<?php $titlePage = "Students" ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Student Table Section -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-6">        
        <!-- Table Header -->
        <form class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="relative">
                    <input type="text" name="keyword" value="<?=$_GET['keyword'] ?? ''?>" autocomplete="off" placeholder="Search by name or email" class="bg-white border border-gray-300 rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    <i class="fas fa-search absolute right-2 -translate-y-1/2 top-1/2 text-gray-500"></i>
                </div>
            </div>
            <div class="flex space-x-4">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none">Filter</button>
            </div>
        </form>
        
        <?php if (empty($students)): ?>
            <div class="text-center py-8">
                <div class="mb-4">
                    <i class="fas fa-users text-6xl text-indigo-200"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">No Students Found</h3>
            </div>
        <?php else: ?>
            <!-- Table -->
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="border-b border-gray-200 text-gray-600">
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Enrolled Courses</th>
                        <th class="py-3 px-4">Total Spent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-4 px-4 text-gray-800"><?= $student->getFullName() ?></td>
                        <td class="py-4 px-4 text-gray-500"><?= $student->getEmail() ?></td>
                        <td class="py-4 px-4 text-gray-800"><?= $student->getTotalCourses() ?></td>
                        <td class="py-4 px-4 text-gray-800">$<?= $student->getTotalSpents() ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>