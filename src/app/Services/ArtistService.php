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


}