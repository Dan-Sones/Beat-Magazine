<?php

namespace S246109\BeatMagazine\Models;

class Album
{
    public $albumArt;
    public $albumName;
    public $artistName;

    /**
     * @param $albumArt
     * @param $albumName
     * @param $artistName
     */
    public function __construct($albumArt, $albumName, $artistName)
    {
        $this->albumArt = $albumArt;
        $this->albumName = $albumName;
        $this->artistName = $artistName;
    }


}