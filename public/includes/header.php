<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="BeatMagazine.com is your go-to source for the latest album reviews.">
    <meta name="keywords" content="music, albums, reviews, artists">
    <meta name="author" content="Beat Magazine">
    <title>BeatMagazine.com</title>
    <link rel="stylesheet" href="/css/custom-bootstrap.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
          rel="stylesheet">

    <link href="/css/aos.css" rel="stylesheet">
    <link href="/css/sweetalert2.min.css" rel="stylesheet">
</head>
<script src="/dist/sweetalert2.min.js"></script>
<script src="/dist/popper.min.js"></script>
<script src="/dist/bootstrap.bundle.min.js"></script>

<body>
<div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Beat Magazine</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item active">
                    <a class="nav-link text-light" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/albums" class="nav-link text-light">Albums</a>
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
            const authenticated = <?= json_encode($_SESSION['authenticated'] ?? false) ?>;
            const username = <?= json_encode($_SESSION['username'] ?? '') ?>;
        </script>
        <script src="/js/header.js"></script>

    </nav>

