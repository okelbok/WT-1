const latitudeInput = document.getElementById("latitude-input");
const longitudeInput = document.getElementById("longitude-input");
const form = document.querySelector("form");

function validateLatitude(latitude) {
    const num = parseFloat(latitude);
    return !isNaN(num) && num >= -90 && num <= 90;
}

function validateLongitude(longitude) {
    const num = parseFloat(longitude);
    return !isNaN(num) && num >= -180 && num <= 180;
}

function showError(input, message) {
    input.setAttribute("title", message);
    input.style.border = "2px solid red";
    input.classList.add("error");
}

function clearError(input) {
    input.removeAttribute("title");
    input.style.border = "";
    input.classList.remove("error");
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
    const isLatValid = validateField(
        latitudeInput,
        validateLatitude,
        "Latitude must be between -90 and 90"
    );

    const isLngValid = validateField(
        longitudeInput,
        validateLongitude,
        "Longitude must be between -180 and 180"
    );

    if (!isLatValid || !isLngValid) {
        event.preventDefault();
    }
}

function resetForm() {
    clearError(latitudeInput);
    clearError(longitudeInput);
}



document.addEventListener("DOMContentLoaded", function() {
    if (form) {
        form.addEventListener("submit", validateForm);
        form.addEventListener("reset", resetForm);
    }

    latitudeInput.addEventListener("input", function() {
        clearError(latitudeInput);
    });

    longitudeInput.addEventListener("input", function() {
        clearError(longitudeInput);
    });
});