<?php

namespace HOA\Bundle\NotificationBundle\Event;

use Symfony\Component\EventDispatcher\Event;


class BetaRegisterEvent extends Event implements NotificationEventInterface {

    private $eventContext;

    public function __construct($member) {
        $this->eventContext = $member;
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
