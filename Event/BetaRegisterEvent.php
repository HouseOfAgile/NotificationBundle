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

}
