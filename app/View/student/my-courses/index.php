<!-- My Courses Hero Section -->
<div class="bg-gradient-to-r from-indigo-600 to-blue-500 pt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">My Courses</h1>
        <div class="flex flex-wrap gap-4 text-white mb-6">
            <div class="flex items-center">
                <i class="fas fa-book-open mr-2"></i>
                <span>Your Learning Collection</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>Access anytime, anywhere</span>
            </div>
        </div>
    </div>
</div>

<!-- Course Filters -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <form class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div class="relative">
            <input 
                type="text" 
                autocomplete="off"
                value="<?= $_GET['keyword'] ?? '' ?>"
                name="keyword"
                placeholder="Search your courses..." 
                class="pl-10 outline-none focus:ring-2 focus:ring-indigo-500 pr-4 py-2 border rounded-lg w-full md:w-80"
            >
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        
        <!-- Filter Button -->
        <div class="col-span-1 md:col-span-4 flex justify-center">
            <button class="px-10 bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
        </div>
    </form>

    <!-- Course Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (! empty($courses)):?>
            <?php foreach ($courses as $course):?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition-all">
                    <div class="relative">
                        <img src="<?= $course->getThumbnail() ?>" alt="Course Thumbnail" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600"><?= $course->getTitle() ?></h3>
                        <div class="flex flex-wrap gap-4 text-sm mb-4">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>Enrolled: <?= (new DateTime($course->getCreatedAt()))->format('F d, Y') ?></span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-user mr-2"></i>
                                <span><?= $course->getTeacherName() ?></span>
                            </div>
                        </div>
                        <div class="rating-container flex items-center mb-4" data-course-id="<?= $course->getId() ?>" data-initial-rating="<?= $course->getRate() ?>">
                            <div class="stars flex">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <button class="star-btn p-1 transition-colors <?= $i <= $course->getRate() ? 'text-yellow-400' : 'text-gray-300' ?> hover:text-yellow-500" data-rating="<?= $i ?>">
                                        <i class="fas fa-star"></i>
                                    </button>
                                <?php endfor; ?>
                            </div>
                            <span class="rating-text ml-2 text-sm text-gray-600">
                                <?= $course->getRate() > 0 ? 'Your rating: ' . number_format($course->getRate(), 2) : 'Rate this course' ?>
                            </span>
                        </div>
                        <?php if (! $course->getIsCompleted()): ?>
                            <a href="<?= URLROOT . 'courses/content/' . $course->getId() ?>" class="w-full block text-center bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                                Access Content
                            </a>
                        <?php else: ?>
                            <a href="<?= URLROOT . 'courses/content/' . $course->getId() ?>" class="w-full block text-center bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                                Completed
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else:?>
            <!-- Empty State (shown when no courses) -->
            <div class="bg-gray-50 rounded-xl p-8 text-center col-span-full">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book-open text-2xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No courses yet</h3>
                <p class="text-gray-600 mb-6">Start your learning journey by enrolling in a course</p>
                <button class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                    Browse Courses
                </button>
            </div>
        <?php endif;?>
    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all rating containers
        document.querySelectorAll('.rating-container').forEach(container => {
            const courseId = container.dataset.courseId;
            const stars = container.querySelectorAll('.star-btn');
            const ratingText = container.querySelector('.rating-text');
            let currentRating = parseFloat(container.dataset.initialRating) || 0;
            let isLoading = false;

            // Function to update star appearance
            function updateStars(rating, isHover = false) {
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });

                // Update rating text
                if (!isHover) {
                    ratingText.textContent = rating > 0 ? `Your rating: ${rating.toFixed(2)}` : 'Rate this course';
                }
            }

            // Handle click events
            stars.forEach(star => {
                star.addEventListener('click', async function() {
                    if (isLoading) return;
                    
                    const newRating = parseInt(this.dataset.rating);
                    // If clicking the same rating, remove it
                    const ratingToSet = currentRating === newRating ? 0 : newRating;
                    
                    isLoading = true;
                    // Add loading state
                    container.style.opacity = '0.7';
                    
                    try {
                        if (ratingToSet === 0) {
                            // Delete rating
                            await fetch(`<?= URLROOT ?>api/rate/delete`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    courseId, 
                                    csrf_token: "<?= generateCsrfToken()?>"
                                })
                            });
                        } else {
                            // Create/update rating
                            const res = await fetch(`<?= URLROOT ?>api/rate/create`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    rating: ratingToSet,
                                    courseId,
                                    csrf_token: "<?= generateCsrfToken()?>"
                                })
                            });

                        }
                        
                        currentRating = ratingToSet;
                        updateStars(currentRating);
                    } catch (error) {
                        console.error('Error updating rating:', error);
                        // Revert to previous state on error
                        updateStars(currentRating);
                    } finally {
                        isLoading = false;
                        container.style.opacity = '1';
                    }
                });

                // Handle hover events
                star.addEventListener('mouseenter', function() {
                    if (!isLoading) {
                        const hoverRating = parseInt(this.dataset.rating);
                        updateStars(hoverRating, true);
                    }
                });

                star.addEventListener('mouseleave', function() {
                    if (!isLoading) {
                        updateStars(currentRating);
                    }
                });
            });
        });
    });
</script>