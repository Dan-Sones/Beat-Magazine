<?php

namespace S246109\BeatMagazine\Services;

class SessionService
{
    public function isAuthenticated(): bool
    {
        return isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
    }

    public function getUserID(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public function isJournalist(): bool
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'journalist';
    }
}