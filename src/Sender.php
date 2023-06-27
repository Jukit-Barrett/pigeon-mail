<?php

namespace Mrzkit\PigeonMail;

use Exception;
use Mrzkit\PigeonMail\Contracts\MailProviderContract;
use Mrzkit\PigeonMail\Contracts\MailTransferContract;
use Mrzkit\PigeonMail\Contracts\SenderContract;

class Sender implements SenderContract
{
    /** @var MailTransferContract */
    private $mailTransferContract;

    /** @var MailProviderContract */
    private $mailProviderContract;

    public function __construct(MailTransferContract $mailTransferContract, MailProviderContract $mailProviderContract)
    {
        $this->mailTransferContract = $mailTransferContract;

        $this->mailProviderContract = $mailProviderContract;
    }

    /**
     * @return MailTransferContract
     */
    public function getMailTransferContract() : MailTransferContract
    {
        return $this->mailTransferContract;
    }

    /**
     * @return MailProviderContract
     */
    public function getMailProviderContract() : MailProviderContract
    {
        return $this->mailProviderContract;
    }

    /**
     * @desc 发送
     * @return bool
     * @throws SenderException
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send()
    {
        try {
            $mailTransfer = $this->getMailTransferContract();

            $mailer = $this->getMailProviderContract()->getMailer();

            $from = $mailTransfer->getFrom();
            $mailer->setFrom($from['address'], $from['name']);

            $recipients = $mailTransfer->getRecipients();
            $mailer->addRecipients($recipients);

            $replyTo = $mailTransfer->getReplyTo();
            $mailer->addReplyTo($replyTo['address'], $replyTo['name']);

            $cc = $mailTransfer->getCC();
            $mailer->addCC($cc);

            $bcc = $mailTransfer->getBCC();
            $mailer->addBCC($bcc);

            $subject = $mailTransfer->getSubject();
            $mailer->setSubject($subject);

            $body = $mailTransfer->getBody();
            $mailer->setBody($body);

            $attachments = $mailTransfer->getAttachments();
            $mailer->addAttachments($attachments);

            $customHeaders = $mailTransfer->getCustomHeaders();
            $mailer->addCustomHeaders($customHeaders);

            $isHtml = $mailTransfer->isHtml();
            $mailer->isHTML($isHtml);

            return $mailer->send();
            //
        } catch (Exception $e) {
            //
            $translateSmtpErrorInfo = new TranslateSmtpErrorInfo($e->getMessage());

            $info = $translateSmtpErrorInfo->translateErrorInfo();

            throw new SenderException($info);
        }
    }
}
