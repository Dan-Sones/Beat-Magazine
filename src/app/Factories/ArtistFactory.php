<?php

namespace S246109\BeatMagazine\Factories;

use PDO;
use S246109\BeatMagazine\Models\Album;
use S246109\BeatMagazine\Models\Artist;
use S246109\BeatMagazine\Models\Song;

class ArtistFactory
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function getArtistByName(string $name): ?Artist
    {
        $query = '
       SELECT 
           artists.name AS artist_name,
           artists.bio AS artist_bio,
           artists.genre AS artist_genre
         FROM artists
       WHERE artists.name = :name LIMIT 1
    ';

        $statement = $this->db->prepare($query);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->execute();

        $artistData = $statement->fetch(PDO::FETCH_ASSOC);

        if (empty($artistData)) {
            return null;
        }

        return new Artist(
            $artistData['artist_name'],
            $artistData['artist_genre'],
            $artistData['artist_bio']
        );

    }
}