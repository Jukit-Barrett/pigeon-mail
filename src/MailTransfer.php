<?php

namespace Mrzkit\PigeonMail;

use Mrzkit\PigeonMail\Contracts\MailTransferContract;

class MailTransfer implements MailTransferContract
{
    /**
     * @var array 发送人 ['address' = '', 'name' => '']
     */
    protected $from = [];

    /**
     * @var array 收件人(可多个) [ ['address' = '', 'name' => ''], ['address' = '', 'name' => ''] ]
     */
    protected $recipients = [];

    /**
     * @var array 邮件回复地址 ['address' = '', 'name' => '']
     */
    protected $replyTo = [];

    /**
     * @var array 抄送人(可多个) [ ['address' = '', 'name' => ''], ['address' = '', 'name' => ''] ]
     */
    protected $cc = [];

    /**
     * @var array 密送人(可多个) [ ['address' = '', 'name' => ''], ['address' = '', 'name' => ''] ]
     */
    protected $bcc = [];

    /**
     * @var string 邮件标题
     */
    protected $subject = '';

    /**
     * @var string 邮件内容
     */
    protected $body = '';

    /**
     * @var array 附件
     */
    protected $attachments = [];

    /**
     * @var array 自定义头部
     */
    protected $customHeaders = [];

    /**
     * @var bool 是否HTML
     */
    protected $isHtml = true;

    /**
     * @return array
     */
    public function getFrom() : array
    {
        return $this->from;
    }

    /**
     * @param array $from
     */
    public function setFrom(array $params)
    {
        if ( !isset($params['address'])) {
            throw new \InvalidArgumentException('Invalid argument address.');
        }

        $this->from = ['address' => $params['address'], 'name' => $params['name'] ?? ''];

        return $this;
    }

    /**
     * @return array
     */
    public function getRecipients() : array
    {
        return $this->recipients;
    }

    /**
     * @param array $recipients
     */
    public function setRecipients(array $params)
    {
        foreach ($params as $param) {
            if ( !isset($param['address'])) {
                throw new \InvalidArgumentException('Invalid argument address.');
            }

            $this->recipients[] = ['address' => $param['address'], 'name' => $param['name'] ?? ''];
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getReplyTo() : array
    {
        return $this->replyTo;
    }

    /**
     * @param array $replyTo
     */
    public function setReplyTo(array $params)
    {
        if ( !isset($params['address'])) {
            throw new \InvalidArgumentException('Invalid argument address.');
        }

        $this->replyTo = ['address' => $params['address'], 'name' => $params['name'] ?? ''];

        return $this;
    }

    /**
     * @return array
     */
    public function getCc() : array
    {
        return $this->cc;
    }

    /**
     * @param array $cc
     */
    public function setCc(array $params)
    {
        foreach ($params as $param) {
            if ( !isset($param['address'])) {
                throw new \InvalidArgumentException('Invalid argument address.');
            }

            $this->cc[] = ['address' => $param['address'], 'name' => $param['name'] ?? ''];
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getBcc() : array
    {
        return $this->bcc;
    }

    /**
     * @param array $bcc
     */
    public function setBcc(array $params)
    {
        foreach ($params as $param) {
            if ( !isset($param['address'])) {
                throw new \InvalidArgumentException('Invalid argument address.');
            }

            $this->bcc[] = ['address' => $param['address'], 'name' => $param['name'] ?? ''];
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject() : string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttachments() : array
    {
        return $this->attachments;
    }

    /**
     * @param array $attachments
     */
    public function setAttachments(array $params)
    {
        foreach ($params as $param) {
            if ( !isset($param['path'])) {
                throw new \InvalidArgumentException('Invalid argument path.');
            }

            $this->attachments[] = [
                'path' => $param['path'],
            ];
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isHtml() : bool
    {
        return $this->isHtml;
    }

    /**
     * @param bool $isHtml
     */
    public function setIsHtml(bool $isHtml)
    {
        $this->isHtml = $isHtml;

        return $this;
    }

    public function getCustomHeaders() : array
    {
        return $this->customHeaders;
    }

    public function setCustomHeaders(array $customHeaders)
    {
        $this->customHeaders = $customHeaders;

        return $this;
    }

}
