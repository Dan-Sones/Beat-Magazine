<?php

namespace S246109\BeatMagazine\Services;

use PDO;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class PasswordResetService
{
    protected PDO $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function handlePasswordResetRequest(string $email): bool
    {
        // Delete any existing password reset tokens for this email
        $stmt = $this->db->prepare('DELETE FROM password_resets WHERE email = :email');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $userId = $stmt->fetchColumn();

        if (!$userId) {
            return false;
        }


        $token = bin2hex(random_bytes(16));
        $expires = date('Y-m-d H:i:s', time() + 1800); // 30 minutes from now

        $stmt = $this->db->prepare('INSERT INTO password_resets (user_id, email, token, expires_at) VALUES (:user_id, :email, :token, :expires)');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':token', hash('sha256', $token), PDO::PARAM_STR);
        $stmt->bindValue(':expires', $expires, PDO::PARAM_STR);


        if (!$stmt->execute()) {
            return false;
        }

        return $this->sendPasswordResetEmail($email, $token);
    }


    private function sendPasswordResetEmail(string $email, string $token): bool
    {
        $reset_link = "http://localhost:8000/reset-password?token=$token";
        if ($_ENV['APP_ENV'] === 'production') {
            $reset_link = "https://s246109.uosweb.co.uk/reset-password?token=$token";
        }

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.34sp.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'password-reset@s246109.uosweb.co.uk';
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        try {
            $mail->setFrom('password-reset@s246109.uosweb.co.uk', 'Password Reset @ BeatMagazine');
        } catch (Exception $e) {
            error_log('Failed to set from address: ' . $e->getMessage());
            return false;
        }
        try {
            $mail->addAddress($email);
        } catch (Exception $e) {
            error_log('Failed to add recipient: ' . $e->getMessage());
            return false;
        }
        $mail->Subject = 'Password Reset Request';
        $mail->Body = 'To reset your password, click the following link: ' . $reset_link;

        try {
            if (!$mail->send()) {
                error_log('Failed to send password reset email to ' . $email . ': ' . $mail->ErrorInfo);
                return false;
            }
        } catch (Exception $e) {
            error_log('Failed to send password reset email to ' . $email . ': ' . $e->getMessage());
            return false;

        }
        return true;
    }

    public function checkIfValidResetToken(string $token): bool
    {
        $hashedToken = hash('sha256', $token);

        $stmt = $this->db->prepare('SELECT email FROM password_resets WHERE token = :token AND expires_at > NOW()');
        $stmt->bindValue(':token', $hashedToken, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
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

    public function getUserIDFromResetToken(string $token): ?int
    {
        $hashedToken = hash('sha256', $token);

        $stmt = $this->db->prepare('SELECT user_id FROM password_resets WHERE token = :token AND expires_at > NOW()');
        $stmt->bindValue(':token', $hashedToken, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


}