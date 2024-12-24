const submitUpgradeForm = async (event) => {
    event.preventDefault();

    await fetch('/api/upgrade', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            password: document.getElementById('password').value,
        }),
    })
        .then(response => {
            if (response.ok) {
                alert('Account upgraded successfully');
                window.location.href = '/albums';
            } else {
                alert('Failed to upgrade account');
            }

        })
}