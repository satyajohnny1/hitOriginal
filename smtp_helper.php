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
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new Exception("Failed to establish TLS encryption");
            }
            $this->sendCommand($socket, "EHLO localhost", '250');
        }

        if (!empty($this->username)) {
            $this->sendCommand($socket, "AUTH LOGIN", '334');
            $this->sendCommand($socket, base64_encode($this->username), '334');
            $this->sendCommand($socket, base64_encode($this->password), '235');
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

        // Dot-stuffing according to RFC 821/822
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
