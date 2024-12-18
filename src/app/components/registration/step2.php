<div class="carousel-item">
    <h3 class="mb-4 text-center">Step 2: Personal Details</h3>
    <form id="step2Form">
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName"
                   placeholder="Enter first name" required>
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName"
                   placeholder="Enter last name" required>
        </div>
        <div class="d-flex justify-content-center">
            <button class="btn btn-secondary prev-btn me-2" type="button"
                    data-bs-target="#registrationCarousel" data-bs-slide="prev">
                Back
            </button>
            <button class="btn btn-primary next-btn" type="button"
                    data-bs-target="#registrationCarousel" data-bs-slide="next">
                Next
            </button>
        </div>
    </form>
</div>

<script>
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
</script>