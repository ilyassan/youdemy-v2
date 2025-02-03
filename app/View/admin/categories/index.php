<?php $titlePage = "Manage Categories" ?>

<section class="p-6">
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Category</h3>
        
        <form action="<?= URLROOT . 'categories/store' ?>" method="POST" class="flex flex-col gap-4">
            <!-- Category Name Input -->
            <div class="flex-1">
                <label for="category_name" class="block mb-2 text-sm font-medium text-gray-700">
                    Category Name
                </label>
                <div id="inputs" class="space-y-3">
                    <input 
                        type="text" 
                        name="categories_name[]" 
                        class="w-full rounded-lg border border-gray-300 p-2.5 text-gray-700 focus:ring-1 focus:ring-indigo-600 focus:border-indigo-600 ring-indigo-600 outline-none"
                        placeholder="Enter category name"
                        autocomplete="off"
                    />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-between items-center">
                <div class="flex gap-6 text-indigo-600 ring-indigo-600 text-3xl">
                    <button 
                        type="button"
                        onclick="addInput()"
                    >
                        <i class="fas fa-plus"></i>
                    </button>
                    <button 
                        type="button"
                        onclick="removeInput()"
                    >
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <button 
                    type="submit"
                    class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 ring-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-600 ring-indigo-600/90 transition-colors"
                >
                    Save
                </button>
            </div>
        </form>
    </div>

    <!-- Categories List Card -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Course Categories</h3>
            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                <?= count($categories) ?> Categories
            </span>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($categories as $category): ?>
            <div class="group shadow-md relative bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                <!-- Category Name -->
                <h4 class="text-gray-700 font-medium"><?= $category->getName() ?></h4>
                
                <!-- Delete Button -->
                <button 
                    onclick="confirmDelete('<?= $category->getName() ?>', '<?= $category->getId() ?>')"
                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity p-2 hover:text-red-600"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-sm mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Delete Category</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to delete "<span id="categoryToDelete"></span>"? This action cannot be undone.</p>
        
        <div class="flex justify-end gap-4">
            <button 
                onclick="closeDeleteModal()"
                class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"
            >
                Cancel
            </button>
            <form action="<?= URLROOT . 'categories/delete' ?>" method="POST">
                <input id="category_id" type="hidden" name="category_id" value="">
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

<script>
    let categoryToDelete = '';

    function confirmDelete(category, id) {
        categoryToDelete = category;
        document.getElementById('category_id').value = id;

        document.getElementById('categoryToDelete').textContent = category;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('flex');
        document.getElementById('deleteModal').classList.add('hidden');
        categoryToDelete = '';
        document.getElementById('category_id').value = category;
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    let inputsContainer = document.getElementById('inputs');
    let count = 1;
    let inputCopy = inputsContainer.firstElementChild.cloneNode(true);

    function addInput() {
        count++;
        inputsContainer.appendChild(inputCopy.cloneNode(true));
    }

    function removeInput(){
        if (count > 1) {
            count--;
            inputsContainer.removeChild(inputsContainer.lastElementChild);
        }
    }
</script>