<?php

namespace HOA\Bundle\NotificationBundle\Event;

use Symfony\Component\EventDispatcher\Event;


class NotificationEvent extends Event implements NotificationEventInterface {

    private $eventContext;
    private $mail;



    public function __construct($contextData) {
        $this->eventContext = $contextData;
    }

    public function getEventContext() {
        return $this->eventContext;
    }

    public function getNotificationOwner()
    {
        return $this->getEventContext();
    }
    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->getEventContext()->getMail();
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }
}