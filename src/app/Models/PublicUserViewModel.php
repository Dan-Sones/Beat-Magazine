<?php

namespace S246109\BeatMagazine\Models;

class PublicUserViewModel
{

    private string $username;
    private string $profilePictureUri;

    private string $id;

    /**
     * @param string $username
     * @param string $profilePictureUri
     * @param string $id
     */
    public function __construct(string $username, string $profilePictureUri, string $id)
    {
        $this->username = $username;
        $this->profilePictureUri = $profilePictureUri;
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getProfilePictureUri(): string
    {
        return $this->profilePictureUri;
    }

    public function getId(): string
    {
        return $this->id;
    }


}