<?php

namespace S246109\BeatMagazine\Services;

use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use Ramsey\Uuid\Uuid;


class UserService
{
    private PDO $db;

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

    public function handlePasswordResetRequest(string $email): bool
    {

        // Delete any existing password reset tokens for this email
        $stmt = $this->db->prepare('DELETE FROM password_resets WHERE email = :email');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();


        $token = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', time() + 1800); // 30 minutes from now

        $stmt = $this->db->prepare('INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires)');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':token', hash('sha256', $token), PDO::PARAM_STR);
        $stmt->bindValue(':expires', $expires, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            return false;
        }

        $this->sendPasswordResetEmail($email, $token);

        return true;
    }

    private function sendPasswordResetEmail(string $email, string $token): void
    {
        $reset_link = "http://localhost:8000/reset-password?token=$token";
        if ($_ENV('APP_ENV') === 'production') {
            //TODO: Update to HTTPs when the site uses it
            $reset_link = "http://s246109.uosweb.co.uk/reset-password?token=$token";
        }

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.34sp.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'password-reset@s246109.uosweb.co.uk';
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('password-reset@s246109.uosweb.co.uk', 'Password Reset @ BeatMagazine');
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = 'To reset your password, click the following link: ' . $reset_link;

        if (!$mail->send()) {
            error_log('Failed to send password reset email to ' . $email . ': ' . $mail->ErrorInfo);
        }
    }

    public function checkIfValidResetToken(string $token): bool
    {
        $hashedToken = hash('sha256', $token);

        $stmt = $this->db->prepare('SELECT email FROM password_resets WHERE token = :token AND expires_at > NOW()');
        $stmt->bindValue(':token', $hashedToken, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
    }

    public function getUserID(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public function resetPassword(string $token, string $password): bool
    {
        $hashedToken = hash('sha256', $token);

        $stmt = $this->db->prepare('SELECT email FROM password_resets WHERE token = :token AND expires_at > NOW()');
        $stmt->bindValue(':token', $hashedToken, PDO::PARAM_STR);
        $stmt->execute();
        $email = $stmt->fetchColumn();

        if ($email) {
            $stmt = $this->db->prepare('UPDATE users SET password = :password WHERE email = :email');
            $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $this->db->prepare('DELETE FROM password_resets WHERE token = :token');
            $stmt->bindValue(':token', $hashedToken, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } else {
            throw new \Exception('Invalid or expired token.');
        }
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
        $directory = PUBLIC_PATH . '/images/user-profile-pictures';
        // Rename the file to be a UUID
        $filename = Uuid::uuid4() . '.' . pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        // Save the relative path
        $relativePath = '/images/user-profile-pictures/' . $filename;

        $query = 'UPDATE users SET profile_picture = :profile_picture WHERE id = :id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':profile_picture', $relativePath, PDO::PARAM_STR);
        $statement->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->execute();
    }

}