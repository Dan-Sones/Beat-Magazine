<?php

namespace S246109\BeatMagazine\Models;

class Artist
{
    private string $name;
    private string $genre;
    private string $bio;

    /**
     * @param string $name
     * @param string $genre
     * @param string $bio
     */
    public function __construct(string $name, string $genre, string $bio)
    {
        $this->name = $name;
        $this->genre = $genre;
        $this->bio = $bio;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function getBio(): string
    {
        return $this->bio;
    }


}