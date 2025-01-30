document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('car-filter-form');
    if (form) {
        const inputs = form.querySelectorAll('select, input:not([type="submit"])');
        
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                form.submit();
            });
        });
    }
});