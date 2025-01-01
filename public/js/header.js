const getProfileHref = () => {
    // if the user is not authenticated, redirect to login page
    if (!authenticated) {
        return '/login';
    }
    // if the user is authenticated, redirect to their profile page
    return '/user/' + username;
}

const logout = async () => {
    try {
        const response = await fetch('/api/logout', {
            method: 'POST',
        });

        if (response.ok) {
            window.location.reload();
        } else {
            Swal.fire({
                title: 'An error occurred while logging out',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'error',
                confirmButtonText: 'Got It'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'Network error occurred while logging out',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            icon: 'error',
            confirmButtonText: 'Got It'
        });
    }
};