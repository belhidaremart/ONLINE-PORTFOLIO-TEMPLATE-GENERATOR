document.addEventListener('DOMContentLoaded', function () {
    // Mobile menu button
    var toggle = document.getElementById('navToggle');
    var links = document.getElementById('navLinks');

    if (toggle && links) {
        toggle.addEventListener('click', function () {
            var isOpen = links.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    // "Add" buttons on the form (skills, projects, education, work)
    document.querySelectorAll('.add-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var list = document.getElementById(btn.dataset.target);
            var tpl = document.getElementById(btn.dataset.template);
            var index = Date.now();
            var html = tpl.innerHTML.replace(/__i__/g, index);
            list.insertAdjacentHTML('beforeend', html);
        });
    });

    // "Remove" buttons
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-btn')) {
            var item = e.target.closest('.repeat-item');
            var list = item.parentElement;
            if (list.children.length > 1) {
                item.remove();
            } else {
                item.querySelectorAll('input, textarea').forEach(function (el) { el.value = ''; });
            }
        }
    });

    // Confirm before deleting a portfolio
    document.querySelectorAll('form.delete-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm('Are you sure you want to delete this portfolio? This cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
});