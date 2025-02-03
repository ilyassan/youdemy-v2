</div>

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="flex h-16 items-center justify-between px-4 py-3">
            <h1 class="text-xl font-semibold text-gray-800"><?= $titlePage ?? "Dashboard" ?></h1>
            
            <div class="flex items-center gap-4">
                <button id="sidebarToggle" class="lg:hidden bg-indigo-600 text-white p-2 rounded-lg">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        // Mobile menu toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            } else {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
            }
        });

        let successMessage = <?= json_encode(flash("success")); ?>;
        if (successMessage) {
            Swal.fire("Success", successMessage, "success");
        }

        let errorMessage = <?= json_encode(flash("error")); ?>;
        if (errorMessage) {
            Swal.fire("Error", errorMessage, "error");
        }

        let warningMessage = <?= json_encode(flash("warning")); ?>;
        if (warningMessage) {
            Swal.fire("Warning", warningMessage, "warning");
        }

        let forms = document.querySelectorAll('form');
        if (forms.length > 0) {
            forms.forEach(form => {
                if(form.method == "get") return;
                let input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'csrf_token');
                input.value = "<?= generateCsrfToken() ?>";
                form.appendChild(input);
            });
        }
    </script>
</body>
</html>