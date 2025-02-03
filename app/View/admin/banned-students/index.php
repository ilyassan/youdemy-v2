<?php $titlePage = "Banned Students" ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Banned Students Table -->
    <section class="bg-white rounded-xl shadow-sm overflow-hidden">

    <?php if (empty($bannedStudents)): ?>
            <div class="py-16 px-6">
                <div class="text-center">
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div class="h-24 w-24 bg-blue-50 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-shield text-4xl text-blue-500"></i>
                            </div>
                            <div class="absolute -bottom-2 -right-2 h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-lg text-green-500"></i>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Banned Students</h3>
                    <p class="text-gray-500 max-w-md mx-auto">
                        Great news! There are currently no banned students in the system.
                    </p>
                </div>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Student
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ban Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Duration
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($bannedStudents as $student): ?>
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
                                <span class="text-sm text-gray-900">Permanent</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <form action="<?= URLROOT . 'students/unban/' . $student->getId() ?>" method="POST" class="flex gap-3">
                                    <button class="px-3 py-1 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                        <i class="fas fa-undo mr-1"></i>
                                        Unban
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</div>