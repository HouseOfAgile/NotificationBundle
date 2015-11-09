<?php

namespace HOA\Bundle\NotificationBundle\Event;


interface NotificationEventInterface {

    public function getEventContext();

    /**
     * Should return a User Object with phone and email at least,otherwise you have to manage ur business logic
     * @return mixed
     */
    public function getNotificationOwner();

    /* return the mail address to use in order to send mail notification */
    public function getMail();

    /* return the locale used for the mail */
    public function getLocale();
}
