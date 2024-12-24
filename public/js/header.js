const getProfileHref = () => {
    // if the user is not authenticated, redirect to login page
    if (!authenticated) {
        return '/login';
    }
    // if the user is authenticated, redirect to their profile page
    return '/user/' + username;
}

const logout = async () => {
    return await fetch('/api/logout', {
        method: 'POST',
    })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Failed to logout');
            }
        });

}