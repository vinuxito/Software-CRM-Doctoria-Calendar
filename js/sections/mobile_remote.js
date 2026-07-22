document.addEventListener('DOMContentLoaded', function () {
    var openBtn = document.getElementById('btn-open-action-sheet');
    var closeBtn = document.getElementById('btn-close-action-sheet');
    var overlay = document.getElementById('mobile-action-sheet-overlay');

    if (openBtn && overlay) {
        openBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            overlay.style.display = 'flex';
        });
    }

    if (closeBtn && overlay) {
        closeBtn.addEventListener('click', function () {
            overlay.style.display = 'none';
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
    }
});
