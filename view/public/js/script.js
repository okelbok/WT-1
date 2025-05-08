document.addEventListener('DOMContentLoaded', function() {
    const latitudeInput = document.getElementById('latitude-input');
    const longitudeInput = document.getElementById('longitude-input');
    const submitButton = document.getElementById('submit-button');
    const resetButton = document.getElementById('reset-button');
    const form = document.querySelector('form');

    function validateLatitude(latitude) {
        const num = parseFloat(latitude);
        return !isNaN(num) && num >= -90 && num <= 90;
    }

    function validateLongitude(longitude) {
        const num = parseFloat(longitude);
        return !isNaN(num) && num >= -180 && num <= 180;
    }

    function showError(input, message) {
        input.setAttribute('title', message);
        input.style.border = '1px solid red';
        input.classList.add('error');
    }

    function clearError(input) {
        input.removeAttribute('title');
        input.style.border = '';
        input.classList.remove('error');
    }

    function validateField(input, validator, errorMessage) {
        if (!validator(input.value)) {
            showError(input, errorMessage);
            return false;
        }
        clearError(input);
        return true;
    }

    function validateForm(event) {
        if (event) event.preventDefault();

        let isLatValid = validateField(
            latitudeInput,
            validateLatitude,
            'Latitude must be between -90 and 90'
        );

        let isLngValid = validateField(
            longitudeInput,
            validateLongitude,
            'Longitude must be between -180 and 180'
        );

        return isLatValid && isLngValid;
    }

    function resetForm() {
        clearError(latitudeInput);
        clearError(longitudeInput);
    }

    if (form) {
        form.addEventListener('submit', validateForm);
    } else if (submitButton) {
        submitButton.addEventListener('click', validateForm);
    }

    if (resetButton) {
        resetButton.addEventListener('click', resetForm);
    }

    latitudeInput.addEventListener('input', function() {
        clearError(latitudeInput);
    });

    longitudeInput.addEventListener('input', function() {
        clearError(longitudeInput);
    });
});