<?php

namespace S246109\BeatMagazine\Models;

class Album implements \JsonSerializable
{
    private int $albumID;
    private string $albumArt;
    private string $albumName;
    private string $artistName;
    private string $genre;
    private string $label;
    private string $releaseDate;
    private array $songs;

    /**
     * @param int $albumID
     * @param string $albumArt
     * @param string $albumName
     * @param string $artistName
     * @param string $genre
     * @param string $label
     * @param string $releaseDate
     * @param array $songs
     */
    public function __construct(int $albumID, string $albumArt, string $albumName, string $artistName, string $genre, string $label, string $releaseDate, array $songs)
    {
        $this->albumID = $albumID;
        $this->albumArt = $albumArt;
        $this->albumName = $albumName;
        $this->artistName = $artistName;
        $this->genre = $genre;
        $this->label = $label;
        $this->releaseDate = $releaseDate;
        $this->songs = $songs;
    }


    public function getAlbumID(): int
    {
        return $this->albumID;
    }

    public function getAlbumArt(): string
    {
        if ($this->albumArt === '') {
            return 'https://via.placeholder.com/150';
        }

        return '/images/album-art/' . $this->albumArt;
    }

    public function getAlbumName(): string
    {
        return $this->albumName;
    }

    public function getArtistName(): string
    {
        return $this->artistName;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function getSongs(): array
    {
        return $this->songs;
    }


    public function jsonSerialize(): mixed
    {
        return [
            'albumID' => $this->albumID,
            'albumArt' => $this->albumArt,
            'albumName' => $this->albumName,
            'artistName' => $this->artistName,
            'genre' => $this->genre,
            'label' => $this->label,
            'releaseDate' => $this->releaseDate,
            'songs' => $this->songs
        ];
    }
}