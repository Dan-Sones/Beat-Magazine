<?php

namespace S246109\BeatMagazine\Models;

class Journalist
{
    private string $name;
    private string $profilePicture;
    private string $bio;

    /**
     * @param string $name
     * @param string $profilePicture
     * @param string $bio
     */
    public function __construct(string $name, string $profilePicture, string $bio)
    {
        $this->name = $name;
        $this->profilePicture = $profilePicture;
        $this->bio = $bio;
    }

    public function getName(): string
    {
        return $this->name;
    }
    // TODO: This property wil need to be added back in when we have profile pages
//    private string $username;

    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    public function getBio(): string
    {
        return $this->bio;
    }


}