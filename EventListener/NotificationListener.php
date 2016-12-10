<?php

namespace HOA\Bundle\NotificationBundle\EventListener;


use HOA\Bundle\NotificationBundle\Services\MailerService;
use HOA\Bundle\NotificationBundle\Services\NotificationService;
use HOA\Bundle\NotificationBundle\Services\TwilioService;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\TranslatorInterface;

abstract class NotificationListener implements NotificationListenerInterface, EventSubscriberInterface
{

    /**
     * @var $mailer MailerService
     */
    protected $mailerService;

    /**
     * @var $twilioService TwilioService
     */
    protected $twilioService;

    /**
     * @var $notificationService NotificationService
     */
    protected $notificationService;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Translator
     */
    protected $translator;

    public function __construct(MailerService $mailer, TwilioService $twilioService, NotificationService $notificationService, Logger $logger, TranslatorInterface $translator)
    {
        $this->mailerService = $mailer;
        $this->logger = $logger;
        $this->twilioService = $twilioService;
        $this->notificationService = $notificationService;
        $this->translator = $translator;
    }

}
