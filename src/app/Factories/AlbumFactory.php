<?php

namespace S246109\BeatMagazine\Factories;

use PDO;
use S246109\BeatMagazine\Models\Album;
use S246109\BeatMagazine\Models\Song;

class AlbumFactory
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAlbumByName(string $name, string $artistName): ?Album
    {
        $query = '
        SELECT album_art, name, artist_name, genre, record_label, 
               average_user_rating, journalist_rating, release_date
        FROM albums
        WHERE name = :album_name AND artist_name = :artist_name
    ';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_name', $name, PDO::PARAM_STR);
        $statement->bindValue(':artist_name', $artistName, PDO::PARAM_STR);
        $statement->execute();

        $albumData = $statement->fetch(PDO::FETCH_ASSOC);

        return new Album(
            $albumData['album_art'],
            $albumData['name'],
            $albumData['artist_name'],
            $albumData['genre'],
            $albumData['record_label'],
            $albumData['average_user_rating'],
            $albumData['journalist_rating'],
            $albumData['release_date'],
            [new Song("1", "Example", '2:11')] // Pass an empty array for songs since they are ignored
        );
    }


}