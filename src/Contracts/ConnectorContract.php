<?php

namespace Mrzkit\PigeonMail\Contracts;

use PHPMailer\PHPMailer\PHPMailer;

interface ConnectorContract
{
    /**
     * @desc 获取配置
     * @return MailConfigContract
     */
    public function getMailConfigContract() : MailConfigContract;

    /**
     * @desc 获取邮件实例
     * @return PHPMailer
     */
    public function phpMailer() : PHPMailer;
}
