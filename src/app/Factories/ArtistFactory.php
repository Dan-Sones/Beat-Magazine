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

    public function searchArtists(string $searchTerm): array
    {
        $query = '
        SELECT
            artists.id,
            artists.name
        FROM artists
        WHERE artists.name LIKE :searchTerm
    ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $statement->execute();

        $artists = [];
        while ($artistData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $artists[$artistData['name']] = $artistData['id'];
        }

        return $artists;
    }


    public function getArtistByName(string $name): ?Artist
    {

        $query = '
    SELECT
        artists.name AS artist_name,
        artists.genre AS artist_genre,
        artists.bio AS artist_bio,
        CAST(AVG(journalist_reviews.rating) AS UNSIGNED) AS average_journalist_rating,
        CAST(AVG(user_reviews.rating) AS UNSIGNED) AS average_user_rating
    FROM artists
    LEFT JOIN albums ON artists.id = albums.artist_id
    LEFT JOIN journalist_reviews ON albums.id = journalist_reviews.album_id
    LEFT JOIN user_reviews ON albums.id = user_reviews.album_id
    WHERE artists.name = :name
    GROUP BY artists.id
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
            $artistData['artist_bio'],
            $artistData['average_journalist_rating'] ?? '',
            $artistData['average_user_rating'] ?? ''
        );

    }

    public function createArtist(string $artistName, string $artistBio, string $artistGenre): string
    {
        // create an artist and return the id
        $query = '
        INSERT INTO artists (name, bio, genre) VALUES (:name, :bio, :genre)
    ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':name', $artistName, PDO::PARAM_STR);
        $statement->bindValue(':bio', $artistBio, PDO::PARAM_STR);
        $statement->bindValue(':genre', $artistGenre, PDO::PARAM_STR);
        $statement->execute();

        return $this->db->lastInsertId();


    }
}