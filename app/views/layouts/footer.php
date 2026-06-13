```php
</main>

<!-- ============================================================
     FOOTER
     ============================================================ -->
<footer class="cms-footer mt-5">
    <div class="container">
        <div class="row g-4">

            <div class="col-md-6">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-journal-richtext me-2"></i>RideAlly CMS
                </h5>

                <p class="small mb-3 text-white-50">
                    RideAlly CMS is a role-based content management platform
                    designed to simplify article publishing, collaboration,
                    and community engagement. Built using PHP MVC architecture,
                    MySQL, and Bootstrap, it demonstrates modern web development
                    principles through a practical publishing ecosystem.
                </p>

                <small class="text-white-50">
                    Empowering authors, editors, and administrators to create
                    meaningful digital experiences.
                </small>
            </div>

            <div class="col-md-3">
                <h6 class="fw-semibold mb-3">Quick Links</h6>

                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="<?= BASE_URL ?>" class="footer-link">Home</a>
                    </li>

                    <li class="mb-2">
                        <a href="<?= BASE_URL ?>posts" class="footer-link">Explore Articles</a>
                    </li>

                    <?php if (!isLoggedIn()): ?>
                        <li class="mb-2">
                            <a href="<?= BASE_URL ?>auth/login" class="footer-link">Sign In</a>
                        </li>

                        <li class="mb-2">
                            <a href="<?= BASE_URL ?>auth/register" class="footer-link">Create Account</a>
                        </li>
                    <?php else: ?>
                        <li class="mb-2">
                            <a href="<?= BASE_URL ?>dashboard" class="footer-link">Dashboard</a>
                        </li>

                        <li class="mb-2">
                            <a href="<?= BASE_URL ?>auth/logout" class="footer-link">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="col-md-3">
                <h6 class="fw-semibold mb-3">Project Details</h6>

                <p class="small text-white-50 mb-2">
                    <strong>Project:</strong> RideAlly CMS
                </p>

                <p class="small text-white-50 mb-2">
                    <strong>Academic Project:</strong> BTech Mini Project
                </p>

                <p class="small text-white-50 mb-2">
                    <strong>Technology Stack:</strong><br>
                    PHP • MySQL • MVC • Bootstrap 5
                </p>

                <p class="small text-white-50 mb-0">
                    Developed as a demonstration of secure authentication,
                    role-based access control, and content publishing workflows.
                </p>
            </div>

        </div>

        <hr class="border-secondary my-4">

        <p class="text-center small text-white-50 mb-0">
            &copy; <?= date('Y') ?> RideAlly CMS.
            All rights reserved. Crafted with PHP MVC Architecture for academic learning and practical implementation.
        </p>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="<?= BASE_URL ?>assets/js/main.js"></script>

</body>
</html>
```
