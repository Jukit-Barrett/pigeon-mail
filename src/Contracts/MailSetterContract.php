<?php

namespace Mrzkit\PigeonMail\Contracts;

interface MailSetterContract
{
    /**
     * @param array $from
     * @return MailSetterContract
     */
    public function setFrom(array $from);

    /**
     * @param array $recipients
     * @return MailSetterContract
     */
    public function setRecipients(array $recipients);

    /**
     * @param array $replyTo
     * @return MailSetterContract
     */
    public function setReplyTo(array $replyTo);

    /**
     * @param array $cc
     * @return MailSetterContract
     */
    public function setCc(array $cc);

    /**
     * @param array $bcc
     * @return MailSetterContract
     */
    public function setBcc(array $bcc);

    /**
     * @param string $subject
     * @return MailSetterContract
     */
    public function setSubject(string $subject);

    /**
     * @param string $body
     * @return MailSetterContract
     */
    public function setBody(string $body);

    /**
     * @param array $attachments
     * @return MailSetterContract
     */
    public function setAttachments(array $attachments);

    public function setCustomHeaders(array $customHeaders);

    /**
     * @param bool $isHtml
     * @return MailSetterContract
     */
    public function setIsHtml(bool $isHtml);

}
