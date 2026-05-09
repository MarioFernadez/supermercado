import './bootstrap';

document.addEventListener('alpine:init', () => {
    Alpine.directive('money', (el) => {
        const format = (value) => {
            return value.replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        el.addEventListener('input', (e) => {
            // Store cursor position
            const start = el.selectionStart;
            const oldLength = el.value.length;
            
            // Format
            el.value = format(e.target.value);
            
            // Restore cursor position handling
            const newLength = el.value.length;
            el.setSelectionRange(start + (newLength - oldLength), start + (newLength - oldLength));
        });
        
        // Initial format on load
        if(el.value) {
            el.value = format(el.value);
        }
    });
});
