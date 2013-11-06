<?php

namespace Sobit\SwiftMailerComponent;

use CApplicationComponent;
use Swift_Mailer;
use Swift_Message;
use Swift_Mime_Message;
use Swift_SmtpTransport;

/**
 * Class SwiftMailerComponent
 *
 * @package Sobit\SwiftMailerComponent
 */
class SwiftMailerComponent extends CApplicationComponent
{
    /**
     * @var string
     */
    public $host = 'localhost';
    /**
     * @var int
     */
    public $port = 25;
    /**
     * @var null
     */
    public $username = null;
    /**
     * @var null
     */
    public $password = null;
    /**
     * @var null
     */
    public $security = null;

    /**
     * @var Swift_SmtpTransport
     */
    private $transport;
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * Initialize the component
     */
    public function init()
    {
        $this->transport = new Swift_SmtpTransport($this->host, $this->port, $this->security);
        $this->transport->setUsername($this->username)->setPassword($this->password);

        $this->mailer = Swift_Mailer::newInstance($this->transport);

        parent::init();
    }

    /**
     * @return Swift_Mailer
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $contentType
     * @param string $charset
     *
     * @return Swift_Message
     */
    public function createMessage($subject = null, $body = null, $contentType = null, $charset = null)
    {
        return new Swift_Message($subject, $body, $contentType, $charset);
    }

    /**
     * @param Swift_Mime_Message $message
     * @param array              $failedRecipients An array of failures by-reference
     *
     * @return integer
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        return $this->getMailer()->send($message, $failedRecipients);
    }
} 