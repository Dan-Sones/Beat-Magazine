<?php

namespace S246109\BeatMagazine\Services;

class SessionService
{
    public function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

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

    public function getUsername(): ?string
    {
        return $_SESSION['username'] ?? null;
    }

    public function logout(): void
    {
        $_SESSION['authenticated'] = false;
        $_SESSION['username'] = null;
        $_SESSION['role'] = null;
        session_destroy();
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }
}