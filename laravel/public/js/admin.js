// Admin panel scripts
document.addEventListener('DOMContentLoaded', () => {
    // Confirm delete
    document.querySelectorAll('form[data-confirm]').forEach(f => {
        f.addEventListener('submit', (e) => {
            if (!confirm(f.getAttribute('data-confirm') || 'Are you sure?')) e.preventDefault();
        });
    });

    // Image preview on file input
    document.querySelectorAll('input[type="file"][data-preview]').forEach(inp => {
        const targetId = inp.getAttribute('data-preview');
        inp.addEventListener('change', () => {
            const f = inp.files?.[0];
            if (!f) return;
            const img = document.getElementById(targetId);
            if (img) img.src = URL.createObjectURL(f);
        });
    });

    // Dynamic array rows (stats/values/features)
    document.querySelectorAll('[data-dyn-add]').forEach(btn => {
        btn.addEventListener('click', () => {
            const container = document.querySelector(btn.getAttribute('data-dyn-target'));
            const tmpl = document.querySelector(btn.getAttribute('data-dyn-template'));
            if (!container || !tmpl) return;
            const idx = container.querySelectorAll('.dyn-row').length;
            const html = tmpl.innerHTML.replace(/__i__/g, idx);
            const div = document.createElement('div');
            div.className = 'dyn-row';
            div.innerHTML = html;
            container.appendChild(div);
        });
    });
    document.addEventListener('click', (e) => {
        if (e.target.matches('[data-dyn-remove]') || e.target.closest('[data-dyn-remove]')) {
            const row = e.target.closest('.dyn-row');
            if (row) row.remove();
        }
    });
});
