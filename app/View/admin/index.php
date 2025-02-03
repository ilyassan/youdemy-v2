<?php $titlePage = "Dashboard" ?>

<!-- Stats Overview Cards -->
<section class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Teachers Card -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500">New Teachers</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2"><?= $monthlyTeachers ?></h3>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <i class="fas fa-chalkboard-teacher text-blue-500 text-xl"></i>
                </div>
            </div>
            <span class="text-sm whitespace-nowrap font-medium <?= $monthlyTeachersDiff > 0 ? 'text-green-600' : 'text-red-600' ?> flex items-center gap-1 mt-1">
                <i class="fas fa-arrow-<?= $monthlyTeachersDiff > 0 ? 'up' : 'down' ?> text-xs"></i> <?= $monthlyTeachersDiff ?> Compared to last month
            </span>
        </div>

        <!-- Pending Verifications -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500">Pending Verifications</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2"><?= $pendingVerifications ?></h3>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <i class="fas fa-user-clock text-yellow-500 text-xl"></i>
                </div>
            </div>
            <span class="text-sm font-medium text-indigo-600 flex items-center gap-1 mt-1">
                <i class="fas fa-exclamation-circle text-xs"></i> Requires attention
            </span>
        </div>

        <!-- Active Students -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500">Active Students</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2"><?= $monthlyActiveStudents ?></h3>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <i class="fas fa-user-graduate text-green-500 text-xl"></i>
                </div>
            </div>
            <span class="text-sm font-medium <?= $activeStudentsRatio > 0 ? 'text-green-600' : 'text-red-600' ?> flex items-center gap-1 mt-1">
                <i class="fas fa-arrow-<?= $activeStudentsRatio > 0 ? 'up' : 'down' ?> text-xs"></i> <?= number_format($activeStudentsRatio, 2) ?>% from last month
            </span>
        </div>

        <!-- Banned Users -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500">Banned Users</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2"><?= $bannedStudentsCount ?></h3>
                </div>
                <div class="bg-indigo-50 p-3 rounded-lg">
                    <i class="fas fa-user-slash text-indigo-500 text-xl"></i>
                </div>
            </div>
            <span class="text-sm font-medium text-gray-600 flex items-center gap-1 mt-1">
                Total banned accounts
            </span>
        </div>
    </div>
</section>

<!-- Charts Section -->
<section class="mb-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Growth Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Platform Growth</h3>
            <canvas id="growthChart" height="300"></canvas>
        </div>

        <!-- Categories Distribution -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Course Categories Distribution</h3>
            <canvas id="categoriesChart" height="300"></canvas>
        </div>
    </div>
</section>

<!-- Recent Activities Section -->
<section>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h3>
        <div class="space-y-4">
            <?php if (empty($recentActivities)): ?>
                    <p class="text-gray-600">No recent activities.</p>
            <?php else: ?>
                <?php foreach ($recentActivities as $activity): ?>
                    <div class="flex items-center gap-4">
                        <?php if ($activity['type'] === 'category'): ?>
                            <div class="bg-green-100 p-2 rounded-full">
                                <i class="fas fa-tag text-green-600"></i>
                            </div>
                        <?php elseif ($activity['type'] === 'course'): ?>
                            <div class="bg-indigo-100 p-2 rounded-full">
                                <i class="fas fa-flag text-indigo-600"></i>
                            </div>
                        <?php elseif ($activity['type'] === 'verification'): ?>
                            <div class="bg-blue-100 p-2 rounded-full">
                                <i class="fas fa-user-check text-blue-600"></i>
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
</section>

<!-- JavaScript for Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Growth Chart Data
    const teachersGrowth = <?= json_encode($teachersInscriptionsGrowth) ?>;
    const studentsGrowth = <?= json_encode($studentsInscriptionsGrowth) ?>;

    const growthData = {
        labels: Object.keys(teachersGrowth),
        datasets: [{
            label: 'Teachers',
            data: Object.values(teachersGrowth),
            borderColor: '#3B82F6',
            tension: 0.4,
            fill: false
        }, {
            label: 'Students',
            data: Object.values(studentsGrowth),
            borderColor: '#10B981',
            tension: 0.4,
            fill: false
        }]
    };

    const categories = <?= json_encode($popularCategories) ?>;

    // Categories Chart Data
    const categoriesData = {
        labels: categories.map(c => c.name),
        datasets: [{
            data: categories.map(c => c.courses_count),
            backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#7C3AED', '#EF4444']
        }]
    };

    // Render Growth Chart
    const growthCtx = document.getElementById('growthChart').getContext('2d');
    new Chart(growthCtx, {
        type: 'line',
        data: growthData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
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

    // Render Categories Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'pie',
        data: categoriesData,
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