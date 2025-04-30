document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form[action*="delete"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Вы уверены?')) {
                e.preventDefault();
            }
        });
    });

    const editor = document.querySelector('.editor');
    if (editor) {
        editor.style.height = editor.scrollHeight + 'px';
        editor.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
});