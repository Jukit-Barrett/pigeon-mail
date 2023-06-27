<?php

namespace Mrzkit\PigeonMail;

use Mrzkit\PigeonMail\Contracts\ConnectorContract;
use Mrzkit\PigeonMail\Contracts\MailConfigContract;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailConnector implements ConnectorContract
{
    /**
     * @var PHPMailer
     */
    protected $phpMailer;

    /**
     * @var MailConfigContract
     */
    protected $mailConfigContract;

    public function __construct(MailConfigContract $mailConfigContract)
    {
        $this->mailConfigContract = $mailConfigContract;

        $this->setMailer();
    }

    /**
     * @return MailConfigContract
     */
    public function getMailConfigContract() : MailConfigContract
    {
        return $this->mailConfigContract;
    }

    /**
     * @desc 创建邮箱实例
     * @return $this
     */
    public function setMailer()
    {
        $mailConfigContract = $this->getMailConfigContract();

        $mail = new PHPMailer($mailConfigContract->getExceptions());

        $mailConfigContract->isSmtp() ? $mail->isSMTP() : $mail->isHTML();

        $mail->SMTPDebug     = $mailConfigContract->getDebug() ? SMTP::DEBUG_LOWLEVEL : SMTP::DEBUG_OFF;
        $mail->SMTPAuth      = $mailConfigContract->getSMTPAuth();
        $mail->SMTPSecure    = $mailConfigContract->getSMTPSecure();
        $mail->SMTPAutoTLS   = $mailConfigContract->getSMTPAutoTLS();
        $mail->SMTPKeepAlive = $mailConfigContract->getSMTPKeepAlive();
        $mail->CharSet       = $mailConfigContract->getCharSet();
        $mail->Host          = $mailConfigContract->getHost();
        $mail->Port          = $mailConfigContract->getPort();
        $mail->Username      = $mailConfigContract->getUsername();
        $mail->Password      = $mailConfigContract->getPassword();
        $mail->Timeout       = $mailConfigContract->getTimeout();

        $this->phpMailer = $mail;

        return $this;
    }

    /**
     * @desc 获取邮箱实例
     * @return PHPMailer
     */
    public function phpMailer() : PHPMailer
    {
        return $this->phpMailer;
    }
}
