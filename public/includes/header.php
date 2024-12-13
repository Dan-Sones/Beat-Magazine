<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beat Magazines</title>
    <link rel="stylesheet" href="/css/custom-bootstrap.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>
<body class="bg-light text-dark d-flex flex-column">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Beat Magazine</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item active">
                    <a class="nav-link text-light">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/albums" class="nav-link text-light">Albums</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light">Artists</a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" onclick="window.location.href = getProfileHref();"
                       class="nav-link text-light">My Profile</a>
                </li>
            </ul>
            <div class="user-info">
                <?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true): ?>
                    <span class="text-light user-text">Hi, <?= $_SESSION['username'] ?>!</span>
                    <a onclick="logout()" class="btn btn-outline-light">Logout</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-outline-light">Login</a>
                    <a href="/register" class="btn btn-outline-light">Register</a>
                <?php endif; ?>
            </div>
        </div>

        <script>


            const getProfileHref = () => {
                // if the user is not authenticated, redirect to login page
                if (!<?= json_encode($_SESSION['authenticated'] ?? false) ?>) {
                    return '/login';
                }
                // if the user is authenticated, redirect to their profile page
                return '/user/' + <?= json_encode($_SESSION['username'] ?? '') ?>;
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
        </script>

    </nav>

