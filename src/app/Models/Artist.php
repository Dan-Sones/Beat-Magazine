<?php

namespace S246109\BeatMagazine\Models;

class Artist
{
    private string $name;
    private string $genre;
    private array $albums;
    private array $reviews;

    /**
     * @param string $name
     * @param string $genre
     * @param array $albums
     * @param array $reviews
     */
    public function __construct(string $name, string $genre, array $albums, array $reviews)
    {
        $this->name = $name;
        $this->genre = $genre;
        $this->albums = $albums;
        $this->reviews = $reviews;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function getAlbums(): array
    {
        return $this->albums;
    }

    public function getReviews(): array
    {
        return $this->reviews;
    }


}