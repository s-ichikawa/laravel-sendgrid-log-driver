<?php
namespace Sichikawa\LaravelSendgridLogDriver\Transport;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridV3Transport;
use Swift_Mime_Message;

class SendgridLogTransport extends SendgridV3Transport
{
    const MAXIMUM_FILE_SIZE = 7340032;
    const SMTP_API_NAME = 'sendgrid/x-smtpapi';
    const BASE_URL = 'https://api.sendgrid.com/v3/mail/send';

    private $options;
    private $logger;

    public function __construct(LoggerInterface $logger, $api_key)
    {
        parent::__construct(new Client(), $api_key, true);
        $this->logger = $logger;
        $this->options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type'  => 'application/json',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $result = parent::send($message, $failedRecipients);

        $this->logger->debug(print_r($result, true));
    }

}
