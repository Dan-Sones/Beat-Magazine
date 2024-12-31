const submitUpgradeForm = async (event) => {
    event.preventDefault();

    const password = document.getElementById('password').value;

    try {
        const response = await fetch('/api/upgrade', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({password}),
        });

        if (response.ok) {
            Swal.fire({
                title: 'Account upgraded successfully',
                icon: 'success',
                confirmButtonText: 'Got It'
            }).then(() => {
                window.location.href = '/albums';
            });
        } else {
            Swal.fire({
                title: 'An error occurred while upgrading your account',
                icon: 'error',
                confirmButtonText: 'Got It'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'An error occurred while upgrading your account',
            icon: 'error',
            confirmButtonText: 'Got It'
        });
    }
};

document.getElementById('upgradeForm').addEventListener('submit', submitUpgradeForm);