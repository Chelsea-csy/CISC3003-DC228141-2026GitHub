/* =========================================================
   CISC3003 Paper 02 Reference JavaScript
   Client-side validation and simple UI helpers
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('[data-validate="true"]');

    forms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            const invalid = form.querySelector(':invalid');
            if (invalid) {
                event.preventDefault();
                invalid.focus();
            }
        });
    });

    const emailInput = document.querySelector('[data-email-check]');
    const emailMessage = document.querySelector('[data-email-message]');
    if (emailInput && emailMessage) {
        emailInput.addEventListener('blur', async () => {
            const email = emailInput.value.trim();
            if (!email) return;
            try {
                const response = await fetch('php/check_email.php?email=' + encodeURIComponent(email));
                const data = await response.json();
                emailMessage.textContent = data.message;
                emailMessage.className = data.available ? 'alert success' : 'alert error';
            } catch (error) {
                emailMessage.textContent = 'Ajax email check failed. Open developer tools to debug.';
                emailMessage.className = 'alert error';
            }
        });
    }
});
