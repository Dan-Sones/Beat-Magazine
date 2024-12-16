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

    public function createAlbum(string $name, string $artistID, string $genre, string $label, string $releaseDate, $albumArt): bool
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
        return $statement->execute();
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

}