document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('cmd-palette-modal');
    var input = document.getElementById('cmd-palette-input');
    var triggerBtn = document.getElementById('open-cmd-palette-btn');
    var resultsContainer = document.getElementById('cmd-palette-results');
    var searchDebounce = null;

    if (!modal || !input) return;

    function openModal() {
        modal.style.display = 'flex';
        input.value = '';
        input.focus();
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    if (triggerBtn) {
        triggerBtn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal();
        });
    }

    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
            e.preventDefault();
            if (modal.style.display === 'flex') {
                closeModal();
            } else {
                openModal();
            }
        }
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            closeModal();
        }
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    input.addEventListener('input', function () {
        clearTimeout(searchDebounce);
        var q = input.value.trim();
        if (q.length < 2) return;

        searchDebounce = setTimeout(function () {
            var url = (window.URLROOT || '') + '/dashboard/globalSearch?q=' + encodeURIComponent(q);
            fetch(url)
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (!data || !data.results) return;
                    renderResults(data.results);
                })
                .catch(function (err) {
                    console.error('Command Palette Search Error:', err);
                });
        }, 200);
    });

    function renderResults(results) {
        if (!resultsContainer) return;
        if (results.length === 0) {
            resultsContainer.innerHTML = '<div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 14px;">No se encontraron resultados</div>';
            return;
        }

        var html = '<div class="cmd-group-title">Resultados de búsqueda</div>';
        results.forEach(function (item) {
            html += '<a href="' + item.url + '" class="cmd-item">' +
                '<i class="' + (item.icon || 'fas fa-chevron-right') + '"></i>' +
                '<div><strong>' + escapeHtml(item.title) + '</strong><div style="font-size: 11px; color: #64748b;">' + escapeHtml(item.subtitle || '') + '</div></div>' +
                '<span class="cmd-badge">' + escapeHtml(item.category) + '</span>' +
                '</a>';
        });
        resultsContainer.innerHTML = html;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
});
