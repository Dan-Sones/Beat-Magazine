<?php

namespace S246109\BeatMagazine\Models;

class Artist
{
    private string $name;
    private string $genre;
    private string $bio;
    private string $averageJournalistRating;

    /**
     * @param string $name
     * @param string $genre
     * @param string $bio
     * @param string $averageJournalistRating
     */
    public function __construct(string $name, string $genre, string $bio, string $averageJournalistRating)
    {
        $this->name = $name;
        $this->genre = $genre;
        $this->bio = $bio;
        $this->averageJournalistRating = $averageJournalistRating;
    }

    public function getAverageJournalistRating(): string
    {
        return $this->averageJournalistRating;
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