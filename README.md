# PHPMailer 封装

# Example

````PHP
<?php

require __DIR__ . '/vendor/autoload.php';

use Mrzkit\PigeonMail\DefaultMailConfig;
use Mrzkit\PigeonMail\MailProvider;
use Mrzkit\PigeonMail\MailTransfer;
use Mrzkit\PigeonMail\Sender;

$mailTransfer = new MailTransfer();

$config = [
    'transport'       => 'smtp',
    'host'            => 'smtp.163.com',
    'port'            => 465,
    'encryption'      => 'ssl', // or tls
    'username'        => 'testemail',
    'password'        => 'password',
    'timeout'         => 30,
    'debug'           => true,
    //
    'mailFromAddress' => 'testemail',
    'mailFromName'    => '杰哥',
    'exceptions'      => true,
    'SMTPAuth'        => true,
    'SMTPKeepAlive'   => true,
    'SMTPAutoTLS'     => false,
];

$params = [
    // 发件人
    'from'          => ['address' => 'testemail', 'name' => ''],
    'replyTo'       => ['address' => 'testemail', 'name' => ''],
    // 收件人
    'recipients'    => [
        ['address' => '', 'name' => '']
    ],
    'customHeaders' => [
        "Message-ID"  => null,
        "In-Reply-To" => null,
        "References"  => null,
    ],
    'cc'            => [],
    'bcc'           => [],
    'subject'       => "Mail Title",
    'body'          => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h1>Mail Content Hello World! ' . date('Y-m-d H:i:s') . '</h1>
</body>
</html>',
];

$mailTransfer->setFrom($params['from'])
    ->setRecipients($params['recipients'])
    ->setReplyTo($params['replyTo'] ?? $params['from'])
    ->setCC($params['cc'] ?? [])
    ->setBCC($params['bcc'] ?? [])
    ->setSubject($params['subject'])
    ->setBody($params['body'])
    ->setAttachments($params['attachments'] ?? [])
    ->setCustomHeaders($params['customHeaders'] ?? []);

$defaultMailConfig = new DefaultMailConfig($config);

$defaultMailProvider = new MailProvider($defaultMailConfig);

$sender = new Sender($mailTransfer, $defaultMailProvider);

$result = $sender->send();

var_dump($result);

````
