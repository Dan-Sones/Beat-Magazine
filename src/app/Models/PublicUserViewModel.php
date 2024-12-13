<?php

namespace S246109\BeatMagazine\Models;

class PublicUserViewModel
{

    private string $username;
    private string $profilePictureUri;
    private int $id;

    private string $created_at;

    /**
     * @param string $username
     * @param string $profilePictureUri
     * @param int $id
     * @param string $created_at
     */
    public function __construct(string $username, string $profilePictureUri, int $id, string $created_at)
    {
        $this->username = $username;
        $this->profilePictureUri = $profilePictureUri;
        $this->id = $id;
        $this->created_at = $created_at;
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
        if ($this->profilePictureUri === '') {
            return 'https://via.placeholder.com/150';
        }

        return $this->profilePictureUri;
    }

    public function getId(): string
    {
        return $this->id;
    }


}