<?php

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
     * @var string
     */
    public $username = null;
    /**
     * @var string
     */
    public $password = null;
    /**
     * @var string
     */
    public $security = null;
    /**
     * @var string
     */
    public $swiftBasePath = '';

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
        $this->initAutoloader($this->swiftBasePath);

        $this->transport = Swift_SmtpTransport::newInstance($this->host, $this->port, $this->security);
        $this->transport->setUsername($this->username)->setPassword($this->password);

        parent::init();
    }

    /**
     * Initialize Swift Mailer autoloader
     */
    private function initAutoloader($swiftBasePath)
    {
        require_once $swiftBasePath.'/lib/swift_required.php';
        require_once $swiftBasePath.'/lib/classes/Swift.php';
        Yii::registerAutoloader(array('Swift', 'autoload'));
    }

    /**
     * @return Swift_Mailer
     */
    public function getMailer()
    {
        if (null === $this->mailer) {
            $this->mailer = Swift_Mailer::newInstance($this->transport);
        }

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
        return Swift_Message::newInstance($subject, $body, $contentType, $charset);
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

    /**
     * @param string $view
     * @param string $layout
     * @param array  $data
     *
     * @return string
     */
    public function renderBody($view, $layout = '//layouts/main', array $data = array())
    {
        $previousLayout = Yii::app()->getController()->layout;

        Yii::app()->getController()->layout = $layout;

        $body = Yii::app()->getController()->render($view, $data, true);

        Yii::app()->getController()->layout = $previousLayout;

        return $body;
    }
} 