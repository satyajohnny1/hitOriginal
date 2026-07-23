<?php
declare(strict_types=1);

class SMTPClient {
    private string $host;
    private int $port;
    private string $username;
    private string $password;
    private string $encryption;
    private int $timeout;

    public function __construct(string $host, int $port, string $username, string $password, string $encryption = 'tls', int $timeout = 15) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->encryption = strtolower($encryption);
        $this->timeout = $timeout;
    }

    public function send(string $fromEmail, string $fromName, array $toEmails, string $subject, string $htmlContent, ?string $attachmentPath = null, ?string $attachmentName = null): bool {
        $socketHost = $this->host;
        if ($this->encryption === 'ssl') {
            $socketHost = 'ssl://' . $this->host;
        }

        $socket = @fsockopen($socketHost, $this->port, $errno, $errstr, $this->timeout);
        if (!$socket) {
            throw new Exception("Connection to SMTP server failed: $errstr ($errno)");
        }

        $this->readResponse($socket, '220');
        $this->sendCommand($socket, "EHLO localhost", '250');

        if ($this->encryption === 'tls') {
            $this->sendCommand($socket, "STARTTLS", '220');
            
            $cryptoMethod = STREAM_CRYPTO_METHOD_TLS_CLIENT;
            if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) {
                $cryptoMethod = STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
                if (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT')) {
                    $cryptoMethod |= STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;
                }
            }
            
            if (!stream_socket_enable_crypto($socket, true, $cryptoMethod)) {
                throw new Exception("Failed to establish TLS 1.2+ encryption");
            }
            $this->sendCommand($socket, "EHLO localhost", '250');
        }

        if (!empty($this->username)) {
            try {
                $this->sendCommand($socket, "AUTH LOGIN", '334');
                $this->sendCommand($socket, base64_encode($this->username), '334');
                $this->sendCommand($socket, base64_encode($this->password), '235');
            } catch (Exception $loginEx) {
                try {
                    $this->sendCommand($socket, "EHLO localhost", '250');
                    $authStr = base64_encode("\0" . $this->username . "\0" . $this->password);
                    $this->sendCommand($socket, "AUTH PLAIN " . $authStr, '235');
                } catch (Exception $plainEx) {
                    throw new Exception("Authentication failed. (LOGIN: " . trim($loginEx->getMessage()) . " | PLAIN: " . trim($plainEx->getMessage()) . ")");
                }
            }
        }

        $this->sendCommand($socket, "MAIL FROM:<$fromEmail>", '250');
        foreach ($toEmails as $to) {
            $this->sendCommand($socket, "RCPT TO:<$to>", '250');
        }

        $this->sendCommand($socket, "DATA", '354');

        $boundary = "==Multipart_Boundary_x" . md5((string)time()) . "x";
        
        $headers = "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <$fromEmail>\r\n";
        $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
        $headers .= "To: " . implode(', ', $toEmails) . "\r\n";
        $headers .= "\r\n";

        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= $htmlContent . "\r\n\r\n";

        if ($attachmentPath && file_exists($attachmentPath)) {
            $fileName = $attachmentName ?: basename($attachmentPath);
            $fileData = chunk_split(base64_encode(file_get_contents($attachmentPath)));
            $body .= "--$boundary\r\n";
            $body .= "Content-Type: application/octet-stream; name=\"$fileName\"\r\n";
            $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $body .= $fileData . "\r\n\r\n";
        }

        $body .= "--$boundary--\r\n";

        $emailContent = $headers . $body;
        $emailContent = str_replace("\r\n", "\n", $emailContent);
        $emailContent = str_replace("\r", "\n", $emailContent);
        $emailContent = str_replace("\n.", "\n..", $emailContent);
        $emailContent = str_replace("\n", "\r\n", $emailContent);

        $this->sendCommand($socket, $emailContent . "\r\n.", '250');
        $this->sendCommand($socket, "QUIT", '221');
        fclose($socket);

        return true;
    }

    private function sendCommand($socket, string $cmd, string $expectedCode): void {
        fwrite($socket, $cmd . "\r\n");
        $this->readResponse($socket, $expectedCode);
    }

    private function readResponse($socket, string $expectedCode): void {
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) === ' ') {
                break;
            }
        }
        $code = substr($response, 0, 3);
        if ($code !== $expectedCode) {
            throw new Exception("SMTP Error: Expected code $expectedCode, got response: $response");
        }
    }
}

class MailSender {
    public static function send(array $config, string $fromEmail, string $fromName, array $toEmails, string $subject, string $htmlContent, ?string $attachmentPath = null, ?string $attachmentName = null): bool {
        $provider = $config['email_provider'] ?? 'smtp';

        if ($provider === 'mailersend_api') {
            $apiToken = trim($config['mailersend_api_token'] ?? '');
            if (empty($apiToken)) {
                throw new Exception("MailerSend API Token is not configured.");
            }
            return self::sendViaMailerSendAPI($apiToken, $fromEmail, $fromName, $toEmails, $subject, $htmlContent, $attachmentPath, $attachmentName);
        }

        $host = trim($config['smtp_host'] ?? '');
        $port = (int)($config['smtp_port'] ?? 587);
        $username = trim($config['smtp_username'] ?? '');
        $password = trim($config['smtp_password'] ?? '');
        $secure = trim($config['smtp_secure'] ?? 'tls');

        if (empty($host)) {
            throw new Exception("SMTP Host is not configured.");
        }

        $smtp = new SMTPClient($host, $port, $username, $password, $secure);
        return $smtp->send($fromEmail, $fromName, $toEmails, $subject, $htmlContent, $attachmentPath, $attachmentName);
    }

    private static function sendViaMailerSendAPI(string $apiToken, string $fromEmail, string $fromName, array $toEmails, string $subject, string $htmlContent, ?string $attachmentPath = null, ?string $attachmentName = null): bool {
        $to = [];
        foreach ($toEmails as $email) {
            $to[] = ['email' => $email];
        }

        $data = [
            'from' => [
                'email' => $fromEmail,
                'name' => $fromName
            ],
            'to' => $to,
            'subject' => $subject,
            'html' => $htmlContent
        ];

        if ($attachmentPath && file_exists($attachmentPath)) {
            $fileName = $attachmentName ?: basename($attachmentPath);
            $fileContent = base64_encode(file_get_contents($attachmentPath));
            $data['attachments'] = [
                [
                    'content' => $fileContent,
                    'filename' => $fileName,
                    'disposition' => 'attachment'
                ]
            ];
        }

        $payload = json_encode($data);

        $ch = curl_init('https://api.mailersend.com/v1/email');
        if (!$ch) {
            throw new Exception("Failed to initialize curl connection.");
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiToken
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return true;
        } else {
            $errDetail = $response ? ": " . $response : "";
            throw new Exception("MailerSend API HTTP $httpCode$errDetail");
        }
    }
}
