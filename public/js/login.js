// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = this.querySelector('.eye-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.style.background = 'url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'%236B7280\'%3E%3Cpath d=\'M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92 1.11-1.11c-1.73-4.39-6-7.5-11-7.5-1.55 0-3.03.3-4.38.84l.42.42C8.24 5.25 10.06 4.5 12 4.5c5 0 9.27 3.11 11 7.5 0 .69-.1 1.36-.28 2l-1.11-1.11c.17-.63.39-1.23.39-1.89 0-2.76-2.24-5-5-5zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l-.42-.42C15.76 18.75 13.94 19.5 12 19.5c-5 0-9.27-3.11-11-7.5 0-.69.1-1.36.28-2L.73 3.16 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l1.55 1.55.02-.02c.01-.01.02-.02.02-.02L12 9.52c-.01 0-.02.01-.02.02l-.14.14z\'/%3E%3C/svg%3E") no-repeat center';
    } else {
        passwordInput.type = 'password';
        eyeIcon.style.background = 'url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'%236B7280\'%3E%3Cpath d=\'M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z\'/%3E%3C/svg%3E") no-repeat center';
    }
});

// Form validation and loading state
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const btn = document.getElementById('loginBtn');
    const btnText = document.querySelector('.btn-text');
    const spinner = document.querySelector('.spinner');

    // Simple validation
    if (!email || !password) {
        e.preventDefault();
        showError('Harap isi semua field yang diperlukan.');
        return;
    }

    // Show loading state
    btn.disabled = true;
    btnText.style.display = 'none';
    spinner.style.display = 'block';

    // Simulate loading (remove this in production)
    setTimeout(() => {
        // In a real app, the form would submit naturally
        // For demo purposes, we'll just reset after 2 seconds
        btn.disabled = false;
        btnText.style.display = 'inline';
        spinner.style.display = 'none';
    }, 2000);
});

// Show error message
function showError(message) {
    // Remove existing error
    const existingError = document.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }

    // Create new error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.style.cssText = `
        background: rgba(255, 59, 48, 0.1);
        border: 1px solid rgba(255, 59, 48, 0.2);
        color: #dc3545;
        border-radius: 10px;
        padding: 0.75rem;
        margin-bottom: 1rem;
        text-align: left;
        font-size: 0.9rem;
        animation: fadeIn 0.3s ease;
    `;
    errorDiv.textContent = message;

    // Insert before form
    const form = document.getElementById('loginForm');
    form.parentNode.insertBefore(errorDiv, form);

    // Auto-hide after 5 seconds
    setTimeout(() => {
        if (errorDiv.parentNode) {
            errorDiv.remove();
        }
    }, 5000);
}

// Add fadeIn animation for error messages
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);

// Add hover effects for inputs
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentNode.style.transform = 'scale(1.02)';
    });

    input.addEventListener('blur', function() {
        this.parentNode.style.transform = 'scale(1)';
    });
});
