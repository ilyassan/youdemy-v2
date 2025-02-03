<?php $titlePage = "Unverified Teachers" ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Verification Table -->
    <section class="bg-white rounded-xl shadow-sm overflow-hidden">
        <?php if (empty($unverifiedTeachers)): ?>
            <div class="p-6">
                <div class="text-center">
                    <div class="flex justify-center mb-6">
                        <div class="h-24 w-24 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clipboard-check text-4xl text-green-500"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">All Caught Up!</h3>
                    <p class="text-gray-500 max-w-md mx-auto">
                        There are no pending teacher verification requests at the moment.
                    </p>
                </div>
            </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Teacher
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Applied For
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Registration Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($unverifiedTeachers as $teacher): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="https://placehold.co/40x40" alt="Teacher">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?= $teacher->getFullName() ?></div>
                                    <div class="text-sm text-gray-500"><?= $teacher->getEmail() ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Teacher</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?= (new DateTime($teacher->getCreatedAt()))->format('F d, Y') ?></div>
                            <div class="text-sm text-gray-500"><?= getTimeAgoFromDate($teacher->getCreatedAt()) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending Review
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <form action="<?= URLROOT . 'teachers/verify/' . $teacher->getId() ?>" method="POST" class="w-fit bg-green-500 px-2 py-1 rounded-lg text-white">
                                <button class="flex gap-1 items-center"><i class="fas fa-check"></i>Verify</button>
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