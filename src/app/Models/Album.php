<?php

namespace S246109\BeatMagazine\Models;

class Album
{
    private $albumArt;
    private $albumName;
    private $artistName;
    private $genre;
    private $label;
    private $averageUserRating;
    private $journalistRating;
    private $releaseDate;
    private $songs;

    /**
     * @param $albumArt
     * @param $albumName
     * @param $artistName
     * @param $genre
     * @param $label
     * @param $averageUserRating
     * @param $journalistRating
     */
    public function __construct($albumArt, $albumName, $artistName, $genre, $label, $averageUserRating, $journalistRating, $releaseDate, $songs)
    {
        $this->albumArt = $albumArt;
        $this->albumName = $albumName;
        $this->artistName = $artistName;
        $this->genre = $genre;
        $this->label = $label;
        $this->averageUserRating = $averageUserRating;
        $this->journalistRating = $journalistRating;
        $this->releaseDate = $releaseDate;
        $this->songs = $songs;
    }

    /**
     * @return mixed
     */
    public function getSongs()
    {
        return $this->songs;
    }

    /**
     * @return mixed
     */
    public function getAlbumArt()
    {
        return $this->albumArt;
    }

    /**
     * @return string
     */
    public function getAlbumName()
    {
        return $this->albumName;
    }

    /**
     * @return mixed
     */
    public function getArtistName()
    {
        return $this->artistName;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getAverageUserRating()
    {
        return $this->averageUserRating;
    }

    /**
     * @return mixed
     */
    public function getJournalistRating()
    {
        return $this->journalistRating;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }


}