<?php

namespace Mrzkit\PigeonMail\Contracts;

interface MailConfigContract
{
    /**
     * @desc 调试信息
     * @return bool
     */
    public function getDebug() : bool;

    /**
     * @desc Specify main and backup SMTP servers
     * @return string
     */
    public function getHost() : string;

    /**
     * @desc TCP port to connect to
     * @return int
     */
    public function getPort() : int;

    /**
     * @desc SMTP username
     * @return string
     */
    public function getUsername() : string;

    /**
     * @desc SMTP password
     * @return string
     */
    public function getPassword() : string;

    /**
     * @desc 超时时间
     * @return int
     */
    public function getTimeout() : int;

    /**
     * @desc Create an instance; passing `true` enables exceptions
     * @return bool
     */
    public function getExceptions() : bool;

    /**
     * @desc Enable SMTP authentication
     * @return bool
     */
    public function getSMTPAuth() : bool;

    /**
     * @desc ENCRYPTION_STARTTLS, or ENCRYPTION_SMTPS.
     * @return string
     */
    public function getSMTPSecure() : string;

    /**
     * @desc Disable Auto TLS authentication
     * @return bool
     */
    public function getSMTPAutoTLS() : bool;

    /**
     * @desc Keep Alive
     * @return bool
     */
    public function getSMTPKeepAlive() : bool;

    /**
     * @desc Charset
     * @return string
     */
    public function getCharSet() : string;

    /**
     * @desc is smtp
     * @return bool
     */
    public function isSmtp() : bool;
}
