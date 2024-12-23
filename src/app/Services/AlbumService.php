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

        $query = '
            INSERT INTO albums (name, artist_id, genre, record_label, album_art, release_date)
            VALUES (:name, :artist_id, :genre, :record_label, :album_art, :release_date)
        ';

        $albumArt = $this->uploadAlbumArt($albumArt);

        $statement = $this->db->prepare($query);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->bindValue(':artist_id', $artistID, PDO::PARAM_INT);
        $statement->bindValue(':genre', $genre, PDO::PARAM_STR);
        $statement->bindValue(':record_label', $label, PDO::PARAM_STR);
        $statement->bindValue(':album_art', $albumArt, PDO::PARAM_STR);
        $statement->bindValue(':release_date', $releaseDate, PDO::PARAM_STR);
        $albumSuccess = $statement->execute();

        if (!$albumSuccess) {
            return false;
        }


        $albumID = $this->db->lastInsertId();

        $query = '
            INSERT INTO songs (album_id, name, length)
            VALUES (:album_id, :name, :length)
                
        ';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumID, PDO::PARAM_INT);

        foreach ($songs as $song) {
            $statement->bindValue(':name', $song['name'], PDO::PARAM_STR);
            $statement->bindValue(':length', $song['length'], PDO::PARAM_STR);
            $songSuccess = $statement->execute();

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