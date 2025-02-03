
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">YouDemy</h3>
                    <p class="text-gray-400">Empowering learners worldwide with quality education and practical skills.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Cookie Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Connect With Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                    <div class="mt-4">
                        <h5 class="text-sm font-semibold mb-2">Subscribe to our newsletter</h5>
                        <div class="flex">
                            <input type="email" placeholder="Enter your email" class="px-4 py-2 rounded-l-md w-full text-gray-900">
                            <button class="bg-primary-600 px-4 py-2 rounded-r-md hover:bg-primary-700">
                                Subscribe
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>© 2025 YouDemy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close the menu when clicking outside of it
        document.addEventListener('click', (event) => {
            const targetElement = event.target;

            if (mobileMenu.classList.contains('hidden')) {
                return;
            }

            if (targetElement === mobileMenuButton || mobileMenuButton.contains(targetElement)) {
                return;
            }

            if (targetElement === mobileMenu || mobileMenu.contains(targetElement)) {
                return;
            }

            mobileMenu.classList.add('hidden');
        });

        // Ensure the mobile menu is hidden on larger screens
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                mobileMenu.classList.add('hidden');
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