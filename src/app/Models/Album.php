<?php

namespace S246109\BeatMagazine\Models;

class Album
{
    public $albumArt;
    public $albumName;
    public $artistName;
    public $genre;
    public $label;
    public $averageUserRating;
    public $journalistRating;
    public $releaseDate;

    /**
     * @param $albumArt
     * @param $albumName
     * @param $artistName
     * @param $genre
     * @param $label
     * @param $averageUserRating
     * @param $journalistRating
     */
    public function __construct($albumArt, $albumName, $artistName, $genre, $label, $averageUserRating, $journalistRating, $releaseDate)
    {
        $this->albumArt = $albumArt;
        $this->albumName = $albumName;
        $this->artistName = $artistName;
        $this->genre = $genre;
        $this->label = $label;
        $this->averageUserRating = $averageUserRating;
        $this->journalistRating = $journalistRating;
        $this->releaseDate = $releaseDate;
    }


}