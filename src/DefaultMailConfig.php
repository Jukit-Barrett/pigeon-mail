<?php

namespace Mrzkit\PigeonMail;

use Mrzkit\PigeonMail\Contracts\MailConfigContract;
use PHPMailer\PHPMailer\PHPMailer;

class DefaultMailConfig implements MailConfigContract
{
    private $config;

    public function __construct(array $config = [])
    {
        $this->config = empty($config) ? config('mail.mailers.smtp') : $config;
    }

    public function getDebug() : bool
    {
        return $this->config['debug'] ?? true;
    }

    public function getHost() : string
    {
        return $this->config['host'];
    }

    public function getPort() : int
    {
        return $this->config['port'];
    }

    public function getUsername() : string
    {
        return $this->config['username'];
    }

    public function getPassword() : string
    {
        return $this->config['password'];
    }

    public function getTimeout() : int
    {
        return $this->config['timeout'] ?? 600;
    }

    public function getExceptions() : bool
    {
        return $this->config['exceptions'] ?? true;
    }

    public function getSMTPAuth() : bool
    {
        return $this->config['SMTPAuth'] ?? ($this->config['encryption'] ?? true);
    }

    public function getSMTPSecure() : string
    {
        return $this->config['SMTPSecure'] ?? PHPMailer::ENCRYPTION_SMTPS;
    }

    public function getSMTPAutoTLS() : bool
    {
        return $this->config['SMTPAutoTLS'] ?? false;
    }

    public function getSMTPKeepAlive() : bool
    {
        return $this->config['SMTPAutoTLS'] ?? true;
    }

    public function getCharSet() : string
    {
        return $this->config['charSet'] ?? PHPMailer::CHARSET_UTF8;
    }

    public function isSmtp() : bool
    {
        return $this->config['isSmtp'] ?? true;
    }
}
