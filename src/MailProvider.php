<?php

namespace Mrzkit\PigeonMail;

use Mrzkit\PigeonMail\Contracts\ConnectorContract;
use Mrzkit\PigeonMail\Contracts\MailConfigContract;
use Mrzkit\PigeonMail\Contracts\MailProviderContract;

class MailProvider implements MailProviderContract
{
    /**
     * @var MailConfigContract
     */
    private $mailConfigContract;

    public function __construct(MailConfigContract $mailConfigContract)
    {
        $this->mailConfigContract = $mailConfigContract;
    }

    public function getMailConfigContract() : MailConfigContract
    {
        return $this->mailConfigContract;
    }

    public function getConnectorContract() : ConnectorContract
    {
        return new MailConnector($this->getMailConfigContract());
    }

    public function getMailer() : Mailer
    {
        return new Mailer($this->getConnectorContract());
    }
}
