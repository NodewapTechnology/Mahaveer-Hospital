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

    // WYSIWYG: TinyMCE for any textarea.wysiwyg
    if (document.querySelector('textarea.wysiwyg') && typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: 'textarea.wysiwyg',
            height: 380,
            menubar: false,
            branding: false,
            promotion: false,
            plugins: 'lists link image table code autoresize',
            toolbar: 'undo redo | blocks | bold italic underline | forecolor | alignleft aligncenter alignright | bullist numlist | link image table | removeformat code',
            content_style: "body{font-family:'Manrope',sans-serif;font-size:15px;color:#1a1523;line-height:1.6;padding:12px} h1,h2,h3{font-family:'Fraunces',serif;font-weight:500;color:#1a1523}",
            skin: 'oxide',
            paste_as_text: false,
            relative_urls: false,
        });
    }
});

