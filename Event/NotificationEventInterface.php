<?php

namespace HOA\Bundle\NotificationBundle\Event;


interface NotificationEventInterface {

    public function getEventContext();

        /**
     * Should return a User Object with phone and email at least
     * @return mixed
     */
    public function getNotificationOwner();

}
