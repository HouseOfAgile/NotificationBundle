<?php

namespace HOA\Bundle\NotificationBundle\EventListener;



use HOA\Bundle\NotificationBundle\Event\NotificationEventInterface;
use HOA\Bundle\NotificationBundle\HOANotificationEvents;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Bridge\Monolog\Logger;

class ExampleNotificationListener extends NotificationListener {

    private static $emailTemplates = array(
        HOANotificationEvents::BETA_REGISTER_COMPLETED=> "HoaNotificationBundle:Mails/Register:betaRegister.html.twig",
        HOANotificationEvents::CONTACT_FORM_FILLED=> "HoaNotificationBundle:Mails/Contact:contactSenderEmail.html.twig",
    );
    private static $smsTemplates = array(
        HOANotificationEvents::CONTACT_FORM_FILLED => "HoaNotificationBundle:Sms/Contact:sendWelcomeSms.html.twig",
    );


    public static function getSubscribedEvents()
    {
        return array(
            HOANotificationEvents::CONTACT_FORM_FILLED => array(
                array('sendEMail', 0),
                array('sendSMS', 1)
                // add more notifications here for this event if needed
            ),
            HOANotificationEvents::BETA_REGISTER_COMPLETED => array(
                array('sendEMail', 0)
                // add more notifications here for this event if needed
            ),
        );
    }

    public function sendEmail(NotificationEventInterface $event){
        if (!isset(self::$emailTemplates[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known email template');
        }

        $context = array(
            'event' => $event->getEventContext()
        );

        $this->logger->info('Send a Member mail of type ['.$event->getName().']');
        $this->mailerService->sendMessage(
            self::$emailTemplates[$event->getName()],
            $context,
            $event->getNotificationOwner()->getEmail()
        );
    }

    public function sendSMS(NotificationEventInterface $event) {
        if (!isset(self::$emailTemplates[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known email template');
        }
        $phone = $event->getNotificationOwner()->getPhone();

        $this->twilioService->sendSms(
            $phone,
            self::$smsTemplates[$event->getName()],
            $event->getEventContext()
        );
    }

    public function sendPushNotification(NotificationEventInterface $event)
    {

    }
}