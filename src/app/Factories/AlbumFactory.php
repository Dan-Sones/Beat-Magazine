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

    public function getAlbumById(int $id): ?Album
    {
        $query = '
        SELECT 
            albums.id, 
            albums.album_art, 
            albums.name AS album_name, 
            artists.name AS artist_name, 
            genres.name AS genre, 
            albums.record_label, 
            albums.average_user_rating, 
            albums.journalist_rating, 
            albums.release_date
        FROM albums
        INNER JOIN artists ON albums.artist_id = artists.id
        LEFT JOIN genres ON albums.genre_id = genres.id
        WHERE albums.id = :album_id
        ';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $id, PDO::PARAM_INT);
        $statement->execute();

        $albumData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($albumData === false) {
            return null;
        }

        return new Album(
            $albumData['id'],
            $albumData['album_art'],
            $albumData['album_name'],
            $albumData['artist_name'],
            $albumData['genre'],
            $albumData['record_label'],
            $albumData['release_date'],
            [new Song("1", "Example", '2:11')]
        );
    }

    public function getAlbumByName(string $name, string $artistName): ?Album
    {
        $query = '
        SELECT 
            albums.id, 
            albums.album_art, 
            albums.name AS album_name, 
            artists.name AS artist_name, 
            genres.name AS genre, 
            albums.record_label, 
            albums.average_user_rating, 
            albums.journalist_rating, 
            albums.release_date
        FROM albums
        INNER JOIN artists ON albums.artist_id = artists.id
        LEFT JOIN genres ON albums.genre_id = genres.id
        WHERE albums.name = :album_name AND artists.name = :artist_name
        ';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_name', $name, PDO::PARAM_STR);
        $statement->bindValue(':artist_name', $artistName, PDO::PARAM_STR);
        $statement->execute();

        $albumData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($albumData === false) {
            return null;
        }

        $songQuery = '
        SELECT id, name, length FROM songs WHERE album_id = :album_id
        ';
        $songStatement = $this->db->prepare($songQuery);
        $songStatement->bindValue(':album_id', $albumData['id'], PDO::PARAM_INT);
        $songStatement->execute();

        $songs = [];

        while ($songData = $songStatement->fetch(PDO::FETCH_ASSOC)) {
            $songs[] = new Song($songData['id'], $songData['name'], $songData['length']);
        }

        return new Album(
            $albumData['id'],
            $albumData['album_art'],
            $albumData['album_name'],
            $albumData['artist_name'],
            $albumData['genre'],
            $albumData['record_label'],
            $albumData['release_date'],
            $songs
        );
    }

    public function getAllAlbums(): ?array
    {
        $query = '
        SELECT 
            albums.id, 
            albums.album_art, 
            albums.name AS album_name, 
            artists.name AS artist_name, 
            genres.name AS genre, 
            albums.record_label, 
            albums.average_user_rating, 
            albums.journalist_rating, 
            albums.release_date
        FROM albums
        INNER JOIN artists ON albums.artist_id = artists.id
        LEFT JOIN genres ON albums.genre_id = genres.id
        ';
        $statement = $this->db->prepare($query);
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return null;
        }

        $albums = [];
        while ($albumData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $albums[] = new Album(
                $albumData['id'],
                $albumData['album_art'],
                $albumData['album_name'],
                $albumData['artist_name'],
                $albumData['genre'],
                $albumData['record_label'],
                $albumData['release_date'],
                [new Song("1", "Example", '2:11')]
            );
        }

        return $albums;
    }

    public function getAlbumsByArtistName(string $artistName): ?array
    {
        $query = '
        SELECT 
            albums.id, 
            albums.album_art, 
            albums.name AS album_name, 
            artists.name AS artist_name, 
            genres.name AS genre, 
            albums.record_label, 
            albums.average_user_rating, 
            albums.journalist_rating, 
            albums.release_date
        FROM albums
        INNER JOIN artists ON albums.artist_id = artists.id
        LEFT JOIN genres ON albums.genre_id = genres.id
        WHERE artists.name = :artist_name
        ';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':artist_name', $artistName, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return null;
        }

        $albums = [];
        while ($albumData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $albums[] = new Album(
                $albumData['id'],
                $albumData['album_art'],
                $albumData['album_name'],
                $albumData['artist_name'],
                $albumData['genre'],
                $albumData['record_label'],
                $albumData['release_date'],
                [new Song("1", "Example", '2:11')]
            );
        }

        return $albums;
    }

    public function searchAlbums(string $search): array|null
    {
        $query = '
        SELECT 
            albums.id, 
            albums.album_art, 
            albums.name AS album_name, 
            artists.name AS artist_name, 
            genres.name AS genre, 
            albums.record_label, 
            albums.average_user_rating, 
            albums.journalist_rating, 
            albums.release_date
        FROM albums
        INNER JOIN artists ON albums.artist_id = artists.id
        LEFT JOIN genres ON albums.genre_id = genres.id
        WHERE albums.name LIKE :searchOne OR artists.name LIKE :searchTwo OR genres.name LIKE :searchThree
        ';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':searchOne', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindValue(':searchTwo', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindValue(':searchThree', '%' . $search . '%', PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return null;
        }

        $albums = [];
        while ($albumData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $albums[] = new Album(
                $albumData['id'],
                $albumData['album_art'],
                $albumData['album_name'],
                $albumData['artist_name'],
                $albumData['genre'],
                $albumData['record_label'],
                $albumData['release_date'],
                [new Song("1", "Example", '2:11')]
            );
        }

        return $albums;
    }

    public function getAlbumsByIdsMappedByIds(array $albumIds): array
    {
        $query = '
        SELECT 
            albums.id, 
            albums.album_art, 
            albums.name AS album_name, 
            artists.name AS artist_name, 
            genres.name AS genre, 
            albums.record_label, 
            albums.average_user_rating, 
            albums.journalist_rating, 
            albums.release_date
        FROM albums
        INNER JOIN artists ON albums.artist_id = artists.id
        LEFT JOIN genres ON albums.genre_id = genres.id
        WHERE albums.id = :album_id
        ';

        $albums = [];

        foreach ($albumIds as $albumId) {
            $statement = $this->db->prepare($query);
            $statement->bindValue(':album_id', $albumId, PDO::PARAM_INT);
            $statement->execute();

            $albumData = $statement->fetch(PDO::FETCH_ASSOC);

            if ($albumData === false) {
                continue;
            }

            $albums[$albumId] = new Album(
                $albumData['id'],
                $albumData['album_art'],
                $albumData['album_name'],
                $albumData['artist_name'],
                $albumData['genre'],
                $albumData['record_label'],
                $albumData['release_date'],
                [new Song("1", "Example", '2:11')]
            );
        }

        return $albums;
    }

    public function getAlbumsByGenre(string $genre): ?array
    {
        $query = '
    SELECT 
        albums.id, 
        albums.album_art, 
        albums.name AS album_name, 
        artists.name AS artist_name, 
        genres.name AS genre, 
        albums.record_label, 
        albums.average_user_rating, 
        albums.journalist_rating, 
        albums.release_date
    FROM albums
    INNER JOIN artists ON albums.artist_id = artists.id
    LEFT JOIN genres ON albums.genre_id = genres.id
    WHERE genres.name LIKE :genre
    ';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':genre', '%' . $genre . '%', PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() === 0) {
            return null;
        }

        $albums = [];
        while ($albumData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $albums[] = new Album(
                $albumData['id'],
                $albumData['album_art'],
                $albumData['album_name'],
                $albumData['artist_name'],
                $albumData['genre'],
                $albumData['record_label'],
                $albumData['release_date'],
                [new Song("1", "Example", '2:11')]
            );
        }

        return $albums;
    }
}