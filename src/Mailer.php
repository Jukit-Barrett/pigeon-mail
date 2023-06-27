<?php

namespace Mrzkit\PigeonMail;

use Mrzkit\PigeonMail\Contracts\ConnectorContract;
use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;

class Mailer
{
    /**
     * @var PHPMailer
     */
    private $phpMailer;

    public function __construct(ConnectorContract $connector)
    {
        $this->phpMailer = $connector->phpMailer();
    }

    /**
     * @desc 邮件实例
     * @return PHPMailer
     */
    public function phpMailer() : PHPMailer
    {
        return $this->phpMailer;
    }

    /**
     * @desc 发件人
     * @param string $address
     * @param string $name
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function setFrom(string $address, string $name = '') : bool
    {
        if ( !$this->phpMailer()->setFrom($address, $name)) {
            $msg = "setFrom fail. ErrorInfo:" . $this->phpMailer()->ErrorInfo;
            throw new RuntimeException($msg);
        }

        return true;
    }

    /**
     * @desc 收件人(可多个)
     * @param array $recipients
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function addRecipients(array $recipients) : bool
    {
        foreach ($recipients as $recipient) {
            if ( !$this->phpMailer()->addAddress($recipient['address'], $recipient['name'])) {
                $msg = "addRecipients fail. ErrorInfo:" . $this->phpMailer()->ErrorInfo;
                throw new RuntimeException($msg);
            }
        }

        return true;
    }

    /**
     * @desc 回复
     * @param string $address
     * @param string $name
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function addReplyTo(string $address, string $name = '') : bool
    {
        if ( !$this->phpMailer()->addReplyTo($address, $name)) {
            $msg = "addReplyTo fail. ErrorInfo:" . $this->phpMailer()->ErrorInfo;
            throw new RuntimeException($msg);
        }

        return true;
    }

    /**
     * @desc 抄送(可多个)
     * @param array $recipients
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function addCC(array $recipients) : bool
    {
        foreach ($recipients as $recipient) {
            if ( !$this->phpMailer()->addCC($recipient['address'], $recipient['name'])) {
                $msg = "addCC fail. ErrorInfo:" . $this->phpMailer()->ErrorInfo;
                throw new RuntimeException($msg);
            }
        }

        return true;
    }

    /**
     * @desc 密送
     * @param array $recipients
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function addBCC(array $recipients) : bool
    {
        foreach ($recipients as $recipient) {
            if ( !$this->phpMailer()->addBCC($recipient['address'], $recipient['name'])) {
                $msg = "addBCC fail. ErrorInfo:" . $this->phpMailer()->ErrorInfo;
                throw new RuntimeException($msg);
            }
        }

        return true;
    }

    /**
     * @desc 是否 HTML
     * @param bool $isHtml
     */
    public function isHTML($isHtml = true)
    {
        $this->phpMailer()->isHTML($isHtml);
    }

    /**
     * @desc 标题
     * @param string $subject
     * @return bool
     */
    public function setSubject(string $subject) : bool
    {
        if (empty($subject)) {
            throw new RuntimeException('Subject Empty.');
        }

        $this->phpMailer()->Subject = $subject;

        return true;
    }

    /**
     * @desc 主体
     * @param string $body
     * @return bool
     */
    public function setBody(string $body) : bool
    {
        if (empty($body)) {
            throw new RuntimeException('Body Empty.');
        }

        $this->phpMailer()->Body = $body;

        return true;
    }

    /**
     * @desc 附件
     * @param array $attachments
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function addAttachments(array $attachments) : bool
    {
        foreach ($attachments as $attachment) {
            if ( !file_exists($attachment['path'])) {
                throw new RuntimeException('Invalid argument path. File Not Exists.');
            }

            if ( !$this->phpMailer()->addAttachment($attachment['path'], $attachment['name'] ?? '', $attachment['encoding'] ?? 'base64', $attachment['type'] ?? '')) {
                $msg = "addAttachments fail. ErrorInfo:" . $this->phpMailer()->ErrorInfo;
                throw new RuntimeException($msg);
            }
        }

        return true;
    }

    /**
     * @desc 自定义头部
     * @param array $customHeaders
     * @return true
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function addCustomHeaders(array $customHeaders)
    {
        foreach ($customHeaders as $key => $value) {
            if ( !is_null($value)) {
                $this->phpMailer()->addCustomHeader($key, $value);
            }
        }

        return true;
    }

    /**
     * @desc 发送邮件
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send()
    {
        $this->phpMailer()->send();

        return $this->phpMailer()->getLastMessageID();
    }
}
