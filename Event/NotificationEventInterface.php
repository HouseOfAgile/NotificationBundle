<?php

namespace HOA\Bundle\NotificationBundle\Event;


interface NotificationEventInterface {

    /**
     * Should return a User Object with phone and email at least
     * @return mixed
     */
    public function getNotificationOwner();

}