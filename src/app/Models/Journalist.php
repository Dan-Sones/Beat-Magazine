<?php

namespace S246109\BeatMagazine\Models;

class Journalist extends PublicUserViewModel
{
    private string $bio;

    private string $firstName;
    private string $lastName;

    /**
     * @param string $name
     * @param string $bio
     * @param string $username
     * @param string $profilePictureUri
     * @param int $id
     * @param string $created_at
     */
    public function __construct(string $firstName, string $lastName, string $bio, string $username, string|null $profilePictureUri, int $id, string $created_at)
    {
        parent::__construct($username, $profilePictureUri, $id, $created_at);
        $this->bio = $bio;
        $this->firstName = $firstName;
        $this->lastName = $lastName;

    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getBio(): string
    {
        return $this->bio;
    }
}