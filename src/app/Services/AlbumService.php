<?php

namespace S246109\BeatMagazine\Services;

use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use Ramsey\Uuid\Uuid;


class AlbumService
{
    protected PDO $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function createAlbum(string $name, string $artistID, string $genre, string $label, string $releaseDate, array $songs, $albumArt): bool
    {
        $genreQuery = '
        SELECT id FROM genres WHERE name = :genre
    ';
        $statement = $this->db->prepare($genreQuery);
        $statement->bindValue(':genre', $genre, PDO::PARAM_STR);
        $statement->execute();

        $genreData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($genreData === false) {
            $insertGenreQuery = '
            INSERT INTO genres (name) VALUES (:genre)
        ';
            $genreStatement = $this->db->prepare($insertGenreQuery);
            $genreStatement->bindValue(':genre', $genre, PDO::PARAM_STR);
            $genreSuccess = $genreStatement->execute();

            if (!$genreSuccess) {
                return false;
            }

            $genreID = $this->db->lastInsertId();
        } else {
            $genreID = $genreData['id'];
        }

        $albumArt = $this->uploadAlbumArt($albumArt);

        $albumQuery = '
        INSERT INTO albums (name, artist_id, genre_id, record_label, album_art, release_date)
        VALUES (:name, :artist_id, :genre_id, :record_label, :album_art, :release_date)
    ';

        $albumStatement = $this->db->prepare($albumQuery);
        $albumStatement->bindValue(':name', $name, PDO::PARAM_STR);
        $albumStatement->bindValue(':artist_id', $artistID, PDO::PARAM_INT);
        $albumStatement->bindValue(':genre_id', $genreID, PDO::PARAM_INT);
        $albumStatement->bindValue(':record_label', $label, PDO::PARAM_STR);
        $albumStatement->bindValue(':album_art', $albumArt, PDO::PARAM_STR);
        $albumStatement->bindValue(':release_date', $releaseDate, PDO::PARAM_STR);
        $albumSuccess = $albumStatement->execute();

        if (!$albumSuccess) {
            return false;
        }

        $albumID = $this->db->lastInsertId();

        $songQuery = '
        INSERT INTO songs (album_id, name, length)
        VALUES (:album_id, :name, :length)
    ';
        $songStatement = $this->db->prepare($songQuery);
        $songStatement->bindValue(':album_id', $albumID, PDO::PARAM_INT);

        foreach ($songs as $song) {
            $songStatement->bindValue(':name', $song['name'], PDO::PARAM_STR);
            $songStatement->bindValue(':length', $song['length'], PDO::PARAM_STR);
            $songSuccess = $songStatement->execute();

            if (!$songSuccess) {
                return false;
            }
        }

        return true;
    }

    private function uploadAlbumArt($uploadedFile): string
    {
        $directory = $this->ensureDirectoryExists(PUBLIC_PATH . '/images/album-art');
        return $this->moveUploadedFile($directory, $uploadedFile);
    }

    private function ensureDirectoryExists(string $directory): string
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        return $directory;
    }

    private function moveUploadedFile($directory, $uploadedFile): string
    {
        $filename = Uuid::uuid4() . '.' . pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
        return $filename;
    }

    public function deleteAlbum(string $albumID): bool
    {
        $query = '
            DELETE FROM albums
            WHERE id = :id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $albumID, PDO::PARAM_INT);
        return $statement->execute();
    }

    public function doesAlbumExist(string $albumName, string $artistID): bool
    {
        $query = '
            SELECT COUNT(*) FROM albums
            WHERE name = :name AND artist_id = :artist_id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':name', $albumName, PDO::PARAM_STR);
        $statement->bindValue(':artist_id', $artistID, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchColumn() > 0;
    }
}