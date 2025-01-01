<?php

namespace S246109\BeatMagazine\Services;

use PDO;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Ramsey\Uuid\Uuid;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;
use RobThree\Auth\TwoFactorAuth;


class UserService
{
    protected PDO $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function registerUser(string $email, string $username, string $password, string $firstName, string $lastName, string $google2fa_secret): void
    {
        $query = '
            INSERT INTO users (email, username, password, first_name, last_name, google2fa_secret)
            VALUES (:email, :username, :password, :first_name, :last_name, :google2fa_secret)
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $statement->bindValue(':first_name', $firstName, PDO::PARAM_STR);
        $statement->bindValue(':last_name', $lastName, PDO::PARAM_STR);
        $statement->bindValue(':google2fa_secret', $google2fa_secret, PDO::PARAM_STR);
        $statement->execute();
    }

    public function isUsernameTaken(string $username): bool
    {
        $query = 'SELECT COUNT(*) FROM users WHERE username = :username';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }

    public function isEmailTaken(string $email): bool
    {
        $query = 'SELECT COUNT(*) FROM users WHERE email = :email';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }

    public function validateOTP(int $userID, string $otp): bool
    {
        $google2fa_secret = $this->getGoogle2fa_secretForUser($userID);
        $tfa = new TwoFactorAuth(new BaconQrCodeProvider());
        return $tfa->verifyCode($google2fa_secret, $otp);
    }

    public function getGoogle2fa_secretForUser(int $userID): ?string
    {
        $query = 'SELECT google2fa_secret FROM users WHERE id = :id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $userID, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function isUserAuthenticated(): bool
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
    }

    public function getUserIdFromUsername(mixed $username)
    {
        $query = 'SELECT id FROM users WHERE username = :username LIMIT 1';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function uploadProfilePicture($uploadedFile): void
    {
        $directory = $this->ensureDirectoryExists(PUBLIC_PATH . '/images/user-profile-pictures');
        $filename = $this->moveUploadedFile($uploadedFile, $directory);
        $currentProfilePicture = $this->getCurrentProfilePicture();
        $this->updateProfilePictureInDatabase($filename);
        $this->deleteOldProfilePicture($currentProfilePicture, $directory);
    }

    private function ensureDirectoryExists(string $directory): string
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        return $directory;
    }

    private function moveUploadedFile($uploadedFile, string $directory): string
    {
        $filename = Uuid::uuid4() . '.' . pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
        return $filename;
    }

    private function getCurrentProfilePicture(): ?string
    {
        $query = 'SELECT profile_picture FROM users WHERE id = :id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchColumn();
    }

    private function updateProfilePictureInDatabase(string $filename): void
    {
        $query = 'UPDATE users SET profile_picture = :profile_picture WHERE id = :id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':profile_picture', $filename, PDO::PARAM_STR);
        $statement->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->execute();
    }

    private function deleteOldProfilePicture(?string $currentProfilePicture, string $directory): void
    {
        if ($currentProfilePicture !== null) {
            $oldFilePath = $directory . DIRECTORY_SEPARATOR . $currentProfilePicture;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
    }

}