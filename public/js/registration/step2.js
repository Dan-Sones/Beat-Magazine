document.addEventListener('DOMContentLoaded', function () {
    const step2Form = document.getElementById('step2Form');
    const nextButton = step2Form.querySelector('.next-btn');
    const firstNameInput = document.getElementById('firstName');
    const lastNameInput = document.getElementById('lastName');

    const validateInput = (input, isValid, message) => {
        if (!isValid) {
            input.classList.add('is-invalid');
            input.setAttribute('title', message);
        } else {
            input.classList.remove('is-invalid');
            input.removeAttribute('title');
        }
    };

    const validateFirstName = () => {
        const firstName = firstNameInput.value.trim();
        const isValid = firstName.length > 0;
        validateInput(firstNameInput, isValid, 'First name is required.');
        return isValid;
    };

    const validateLastName = () => {
        const lastName = lastNameInput.value.trim();
        const isValid = lastName.length > 0;
        validateInput(lastNameInput, isValid, 'Last name is required.');
        return isValid;
    };

    const checkFormValidity = () => {
        const isFormValid = validateFirstName() && validateLastName();
        nextButton.disabled = !isFormValid;
    };

    firstNameInput.addEventListener('blur', validateFirstName);
    lastNameInput.addEventListener('blur', validateLastName);

    step2Form.addEventListener('input', checkFormValidity);

    nextButton.disabled = true;

})