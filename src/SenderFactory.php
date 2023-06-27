<?php

namespace Mrzkit\PigeonMail;

use Mrzkit\PigeonMail\Contracts\MailConfigContract;
use Mrzkit\PigeonMail\Contracts\MailTransferContract;

class SenderFactory
{
    /**
     * @desc
     * @param MailTransferContract $mailTransferContract
     * @param MailConfigContract $mailConfigContract
     * @return bool
     * @throws SenderException
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function sender(MailTransferContract $mailTransferContract, MailConfigContract $mailConfigContract) : bool
    {
        $mailProvider = new MailProvider($mailConfigContract);

        $sender = new Sender($mailTransferContract, $mailProvider);

        return $sender->send();
    }

    /**
     * @desc
     * @param array $params
     * @return bool
     * @throws SenderException
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function send(array $params) : bool
    {
        $mailTransfer = new MailTransfer();

        $mailTransfer->setFrom($params['from'])
            ->setSubject($params['subject'])
            ->setBody($params['body'])
            ->setRecipients($params['recipients'])
            ->setReplyTo($params['replyTo'] ?? $params['from'])
            ->setCC($params['cc'] ?? [])
            ->setBCC($params['bcc'] ?? [])
            ->setAttachments($params['attachments'] ?? []);

        $defaultMailConfig = new DefaultMailConfig();

        $send = static::sender($mailTransfer, $defaultMailConfig);

        return $send;
    }
}
