<?php

namespace S246109\BeatMagazine\Services;

use PDO;

class ArtistService
{
    private PDO $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function doesArtistExist(string $name): bool
    {
        $query = 'SELECT COUNT(*) FROM artists WHERE name = :name';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn() > 0;

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