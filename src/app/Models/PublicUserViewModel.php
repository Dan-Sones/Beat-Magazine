<?php

namespace S246109\BeatMagazine\Models;

class PublicUserViewModel
{

    private string $username;
    private string|null $profilePictureUri;
    private int $id;

    private string $role;

    private string $created_at;

    /**
     * @param string $username
     * @param string|null $profilePictureUri
     * @param int $id
     * @param string $role
     * @param string $created_at
     */
    public function __construct(string $username, ?string $profilePictureUri, int $id, string $role, string $created_at)
    {
        $this->username = $username;
        $this->profilePictureUri = $profilePictureUri;
        $this->id = $id;
        $this->role = $role;
        $this->created_at = $created_at;
    }

    public function getRole(): string
    {
        return $this->role;
    }


    public function getCreatedAt(): string
    {
        return $this->created_at;
    }


    public function getUsername(): string
    {
        return $this->username;
    }

    public function getProfilePictureUri(): string
    {
        if ($this->profilePictureUri === null || $this->profilePictureUri === '') {
            return 'https://via.placeholder.com/150';
        }

        return '/images/user-profile-pictures/' . $this->profilePictureUri;
    }

    public function getId(): string
    {
        return $this->id;
    }


}