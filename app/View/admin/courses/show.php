<?php $titlePage = "Course Details" ?>

<div class="bg-white shadow-lg rounded-lg p-6 max-w-3xl mx-auto">
    <div class="flex justify-end">
        <button type="button" class="text-gray-400 hover:text-red-500" onclick="confirmCourseDelete('<?= $course->getTitle() ?>', '<?= $course->getId() ?>')">
            <i class="far fa-trash-alt text-xl"></i>
        </button>
    </div>

    <!-- Thumbnail Upload with Dynamic Behavior -->
    <div class="flex justify-center mb-6">
        <div class="relative flex justify-center w-full md:w-96 h-60 border-2 border-gray-300 rounded-lg overflow-hidden">
            <!-- Current Image Preview -->
            <img
                id="thumbnail-preview"
                src="<?= $course->getThumbnail() ?>"
                class="w-full h-full object-cover"
                alt="Current Thumbnail"
            >
            <!-- Title Overlay -->
            <span
                id="thumbnail-title"
                class="absolute inset-0 flex items-center justify-center bg-gray-50 text-gray-500 font-medium rounded-lg opacity-0"
            >
                Change Thumbnail
            </span>
        </div>
    </div>

    <!-- Teacher Name -->
    <div class="mb-4">
        <label for="teacher_name" class="block mb-2 text-sm font-medium text-gray-700">Teacher</label>
        <input type="text" disabled autocomplete="off" id="teacher_name" name="teacher_name" value="<?= htmlspecialchars($course->getTeacherName()) ?>" class="bg-gray-50 outline-none border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter course title">
    </div>

    <!-- Course Title -->
    <div class="mb-4">
        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Course Title</label>
        <input type="text" disabled autocomplete="off" id="title" name="title" value="<?= htmlspecialchars($course->getTitle()) ?>" class="bg-gray-50 outline-none border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter course title">
    </div>

    <!-- Description -->
    <div class="mb-4">
        <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" disabled name="description" rows="4" class="bg-gray-50 outline-none border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Write a brief description"><?= htmlspecialchars($course->getDescription()) ?></textarea>
    </div>

    <!-- Categories (Custom Dropdown) -->
    <div class="relative mb-4">
        <label for="category" class="block mb-2 text-sm font-medium text-gray-700">Category</label>
        <input id="selectedCategories_value" type="hidden" name="category_id" value="<?= $course->getCategoryId() ?>">
        <button
            type="button"
            id="categoriesDropdown"
            class="flex items-center border border-gray-300 rounded-md px-4 py-2 w-full bg-white text-gray-900 focus:outline-none"
        >
            <i class="fas fa-layer-group text-gray-500 mr-2"></i>
            <span id="selectedCategories">
                <?= htmlspecialchars($course->getCategoryName()) ?>
            </span>
            <i class="fas fa-chevron-down ml-auto text-gray-400"></i>
        </button>
        <!-- Dropdown Options -->
        <ul
            id="categoriesDropdownMenu"
            class="absolute dropdown-menu hidden bg-white shadow-md rounded-md w-full mt-2 z-10"
        >
            <?php foreach ($categories as $category): ?>
                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectOption('categoriesDropdown', 'selectedCategories', '<?= htmlspecialchars($category->getName()) ?>', '<?= htmlspecialchars($category->getId()) ?>')"><?= htmlspecialchars($category->getName()) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Course Price -->
    <div class="mb-4">
        <label for="price" class="block mb-2 text-sm font-medium text-gray-700">Price</label>
        <input type="number" disabled autocomplete="off" id="price" name="price" value="<?= $course->getPrice() ?>" class="bg-gray-50 outline-none border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter course price">
    </div>

    <!-- Tags (Custom Dropdown) -->
    <div class="mb-4">
        <label for="tags" class="block mb-2 text-sm font-medium text-gray-700">Tags</label>
        <div class="relative">
            <button
                type="button"
                id="tagsDropdown"
                class="flex items-center border border-gray-300 rounded-md px-4 py-3 w-full bg-white text-gray-500 focus:outline-none"
            >
                <span id="selectedTags">Select Tags</span>
                <i class="fas fa-chevron-down ml-auto text-gray-400"></i>
            </button>
            <!-- Dropdown Options -->
            <ul
                id="tagsDropdownMenu"
                class="absolute dropdown-menu hidden bg-white shadow-md rounded-md w-full mt-2 z-10"
            >
            </ul>
        </div>

        <div id="tagsContainer" class="flex mt-3 gap-2 flex-wrap">
        </div>
    </div>

    <!-- Current Content Info -->
    <div class="mb-6">
        <label class="block mb-2 text-sm font-medium text-gray-700">Content</label>
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-gray-600">
                Current <?= ucfirst($course->getContentType()) ?>: 
                <?php $temp = explode("/", $course->getContent()); ?>
                <span class="font-medium text-gray-800"><?= htmlspecialchars(end($temp)) ?></span>
            </p>
        </div>
    </div>
</div>

    <!-- Delete Article Confirmation -->
    <div id="deleteCourseModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm mx-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Delete Course</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete "<span id="courseToDelete"></span>" Course?</p>
            
            <div class="flex justify-end gap-4">
                <button 
                    onclick="closeCourseDeleteModal()"
                    class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"
                >
                    Cancel
                </button>
                <form action="<?= URLROOT . 'courses/delete/' . $course->getId() ?>" method="POST">
                    <button
                        type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                    >
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

<?php
$temp = [];
foreach ($course->getTags() as $tag) {
    $tagObj = current(array_filter($tags, fn($obj) => $obj->getName() == $tag));
    if ($tagObj) {
        $temp[] = $tagObj;
    }
}
$course->setTags($temp);

$courseTags = array_map(fn($tag) => ["id" => $tag->getId(), "name" => $tag->getName()], $course->getTags());
$availableTags = array_map(fn($tag) => ["id" => $tag->getId(), "name" => $tag->getName()], array_filter($tags, fn($tag) => !in_array($tag->getId(), array_column($courseTags, 'id'))));

?>

<script>

    // Tags Management
    let tags = <?= json_encode(array_values($availableTags)) ?>;
    let selectedTags = <?= json_encode(array_values($courseTags)) ?>;
    let tagsContainer = document.getElementById("tagsContainer");
    
    function refreshTags() {
        tagsContainer.innerHTML = "";

        // Display selected tags with remove button
        for (let tag of selectedTags) {
            tagsContainer.innerHTML += `
                <span class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                    #${tag.name}
                    <input type="hidden" name="tag_ids[]" value="${tag.id}">
                </span>
            `;
        }

        // Refresh available tags in dropdown
        document.getElementById("tagsDropdownMenu").innerHTML = "";
        for (let tag of tags) {
            document.getElementById("tagsDropdownMenu").innerHTML += `
                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">${tag.name}</li>
            `;
        }

        // Update dropdown text based on selection state
        const selectedTagsSpan = document.getElementById("selectedTags");
        if (selectedTags.length === 0) {
            selectedTagsSpan.textContent = "Select Tags";
        } else {
            selectedTagsSpan.textContent = `${selectedTags.length} tag${selectedTags.length === 1 ? '' : 's'}`;
        }
    }

    // Initialize tags on page load
    refreshTags();


    let courseToDelete = '';

    function confirmCourseDelete(courseToDelete) {
        courseToDelete = courseToDelete;

        document.getElementById('courseToDelete').textContent = courseToDelete;
        document.getElementById('deleteCourseModal').classList.remove('hidden');
        document.getElementById('deleteCourseModal').classList.add('flex');
    }

    function closeCourseDeleteModal() {
        document.getElementById('deleteCourseModal').classList.remove('flex');
        document.getElementById('deleteCourseModal').classList.add('hidden');
        courseToDelete = '';
    }

    document.getElementById('deleteCourseModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCourseDeleteModal();
        }
    });
</script>