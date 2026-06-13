// ============================================================
// RIDALLY CMS — MAIN JAVASCRIPT
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    // ----------------------------------------------------------
    // AUTO-DISMISS flash alerts after 4 seconds
    // ----------------------------------------------------------
    const alerts = document.querySelectorAll('.alert.alert-dismissible');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 4000);
    });

    // ----------------------------------------------------------
    // CONFIRM DIALOGS — handled via onclick in HTML
    // (already present in views; this is for any dynamic ones)
    // ----------------------------------------------------------

    // ----------------------------------------------------------
    // FILE INPUT PREVIEW
    // Shows a small preview of selected image before upload.
    // ----------------------------------------------------------
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(function (input) {
        input.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            // Find or create preview element
            let preview = this.parentElement.querySelector('.img-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.classList.add('img-preview', 'img-thumbnail', 'mt-2');
                preview.style.maxHeight = '100px';
                this.parentElement.appendChild(preview);
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    });

    // ----------------------------------------------------------
    // SEARCH INPUT — auto-focus if on search page
    // ----------------------------------------------------------
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput && window.location.href.includes('/search')) {
        searchInput.focus();
    }

    // ----------------------------------------------------------
    // ACTIVE SIDEBAR LINK HIGHLIGHT
    // Adds 'active' class to the matching sidebar link.
    // ----------------------------------------------------------
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    sidebarLinks.forEach(function (link) {
        const href = link.getAttribute('href');
        if (href && currentPath.endsWith(href.split('/public/')[1] ?? '')) {
            link.classList.add('active');
        }
    });

});