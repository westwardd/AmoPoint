(() => {
    const getContainer = (el) => {
        return el.closest('[data-field-container], .field, .form-group, .form-row, .row, .col, .input-group, label') || el;
    };

    const normalize = (value) => (value || '').toString().trim();

    const update = (selectEl) => {
        const selected = normalize(selectEl.value);
        if (!selected) {
            return;
        }

        const fields = document.querySelectorAll('[name]');
        fields.forEach((field) => {
            if (field === selectEl) {
                return;
            }
            const name = normalize(field.getAttribute('name'));
            const container = getContainer(field);
            const shouldShow = name.includes(selected);
            container.style.display = shouldShow ? '' : 'none';
        });
    };

    const bind = () => {
        const selects = Array.from(document.querySelectorAll('select'));
        if (selects.length === 0) {
            return;
        }

        selects.forEach((selectEl) => {
            selectEl.addEventListener('change', () => update(selectEl));
            update(selectEl);
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bind);
    } else {
        bind();
    }
})();
