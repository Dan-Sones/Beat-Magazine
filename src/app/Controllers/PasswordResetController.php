<?php

namespace S246109\BeatMagazine\Controllers;

use PDO;
use S246109\BeatMagazine\Models\User;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PasswordResetController
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        ob_start();
        include PRIVATE_PATH . '/src/app/Views/passwordReset.php';
        $output = ob_get_clean();
        $response->getBody()->write($output);

        return $response;
    }

//    public function requestPasswordReset(string $email)
//    {
//        $token = bin2hex(random_bytes(16));
//        $expires = date('U') + 1800; // 30 minutes from now
//
//        $stmt = $this->db->prepare('INSERT INTO password_resets (email, token, expires) VALUES (:email, :token, :expires)');
//        $stmt->execute(['email' => $email, 'token' => $token, 'expires' => $expires]);
//
//        $this->sendPasswordResetEmail($email, $token);
//    }
//
//    private function sendPasswordResetEmail(string $email, string $token)
//    {
//        $mail = new PHPMailer(true);
//        $mail->setFrom('no-reply@example.com', 'BeatMagazine');
//        $mail->addAddress($email);
//        $mail->Subject = 'Password Reset Request';
//        $mail->Body = "Click the link to reset your password: http://example.com/reset-password?token=$token";
//        $mail->send();
//    }


}