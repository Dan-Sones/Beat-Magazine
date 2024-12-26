<?php

namespace S246109\BeatMagazine\Models;

class Artist
{
    private string $name;
    private string $genre;
    private string $bio;
    private string $averageJournalistRating;

    private string $averageUserRating;

    /**
     * @param string $name
     * @param string $genre
     * @param string $bio
     * @param string $averageJournalistRating
     * @param string $averageUserRating
     */
    public function __construct(string $name, string $genre, string $bio, string $averageJournalistRating, string $averageUserRating)
    {
        $this->name = $name;
        $this->genre = $genre;
        $this->bio = $bio;
        $this->averageJournalistRating = $averageJournalistRating;
        $this->averageUserRating = $averageUserRating;
    }

    public function getAverageUserRating(): string
    {
        return $this->averageUserRating;
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