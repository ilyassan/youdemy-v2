<?php $titlePage = "Dashboard" ?>

<!-- Stats Overview Cards -->
<section class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Monthly Course Completions Card -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500">Monthly Profits</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">$<?= $monthProfit ?></h3>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <i class="fas fa-graduation-cap text-green-500 text-xl"></i>
                </div>
            </div>
            <span class="text-sm font-medium <?= $ratioProfit > 0 ? 'text-green-600' : 'text-red-600' ?> flex items-center gap-1 mt-1">
                <i class="fas fa-arrow-<?= $ratioProfit > 0 ? 'up' : 'down' ?> text-xs"></i> <?= htmlspecialchars(number_format($ratioProfit, 2)) ?>% from last month
            </span>
        </div>

        <!-- Monthly Enrollments Card -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500">Monthly Enrollments</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2"><?= $monthEnrollments ?></h3>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <i class="fas fa-user-plus text-blue-500 text-xl"></i>
                </div>
            </div>
            <span class="text-sm font-medium <?= $diffEnrollments > 0 ? 'text-green-600' : 'text-red-600' ?> flex items-center gap-1 mt-1">
                <i class="fas fa-arrow-<?= $diffEnrollments > 0 ? 'up' : 'down' ?> text-xs"></i> <?= $diffEnrollments ?> from last month
            </span>
        </div>

        <!-- Total Students Card -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500">Total Students</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2"><?= $studentsCount ?></h3>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <i class="fas fa-users text-purple-500 text-xl"></i>
                </div>
            </div>
            <span class="text-sm font-medium text-gray-600 flex items-center gap-1 mt-1">
                Total registered students
            </span>
        </div>

        <!-- Average Rating Card -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500">Average Course Rating</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2"><?= htmlspecialchars(number_format($averageRate, 2)) ?></h3>
                    <div class="flex items-center gap-1 mt-1 text-yellow-400 text-sm">
                        <?php
                            $fullStars = floor($averageRate);
                            $halfStar = ($averageRate - $fullStars) >= 0.5 ? 1 : 0;
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
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <i class="fas fa-star text-yellow-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Charts Section -->
<section class="mb-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Student Enrollment Over Time Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Student Enrollment Over Time</h3>
            <canvas id="enrollmentChart" height="300"></canvas>
        </div>

        <!-- Course Popularity Distribution -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Course Popularity Distribution</h3>
            <canvas id="popularityChart" height="300"></canvas>
        </div>
    </div>
</section>

<!-- Highlights Section -->
<section>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <?php if ($topCourse): ?>
            <!-- Most Popular Course Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Most Popular Course</h3>
                <div class="flex gap-4">
                    <div class="max-w-[55%]">
                        <img src="<?= $topCourse->getThumbnail() ?>" alt="Top Course" class="object-cover rounded-lg">
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-gray-800"><?= $topCourse->getTitle() ?></h4>
                        <div class="flex items-center gap-1 text-yellow-400 mt-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ml-2 text-gray-600">(<?= $topCourse->getRate() ?>)</span>
                        </div>
                        <p class="text-gray-600 mt-2">Category: <?= $topCourse->getCategoryName() ?></p>
                        <p class="text-blue-600 font-semibold mt-2">Price: $<?= $topCourse->getPrice() ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Recent Educational Activities Card -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Educational Activities</h3>
            <div class="space-y-4">
            <?php if (empty($recentActivities)): ?>
                    <p class="text-gray-600">No recent activities.</p>
                <?php else: ?>
                    <?php foreach ($recentActivities as $activity): ?>
                        <div class="flex items-center gap-4">
                            <?php if ($activity['type'] === 'enrollment'): ?>
                                <div class="bg-green-100 p-2 rounded-full">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                            <?php elseif ($activity['type'] === 'rate'): ?>
                                <div class="bg-yellow-100 p-2 rounded-full">
                                    <i class="fas fa-star text-yellow-600"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <p class="text-gray-800"><?= htmlspecialchars($activity['message']) ?></p>
                                <p class="text-sm text-gray-500">
                                    <?= getTimeAgoFromDate($activity['created_at']) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- JavaScript for Charts -->
<script>
    // Enrollment Chart Data

    const enrollments = <?= json_encode($lastSixMonthsEnrollments) ?>;

    const enrollmentData = {
        labels: Object.keys(enrollments),
        datasets: [{
            label: 'Enrollments',
            data: Object.values(enrollments),
            borderColor: '#3B82F6',
            tension: 0.4,
            fill: true,
            backgroundColor: 'rgba(59, 130, 246, 0.1)'
        }]
    };


    const categories = <?= json_encode($popularCategories) ?>;

    // Popularity Chart Data
    const popularityData = {
        labels: categories.map(c => c.name),
        datasets: [{
            data: categories.map(c => c.courses_count),
            backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#7C3AED']
        }]
    };

    // Render Enrollment Chart
    const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
    new Chart(enrollmentCtx, {
        type: 'line',
        data: enrollmentData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Render Popularity Chart
    const popularityCtx = document.getElementById('popularityChart').getContext('2d');
    new Chart(popularityCtx, {
        type: 'doughnut',
        data: popularityData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>