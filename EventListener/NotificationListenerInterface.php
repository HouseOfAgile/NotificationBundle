<?php

namespace HOA\Bundle\NotificationBundle\EventListener;


use HOA\Bundle\NotificationBundle\Event\NotificationEventInterface;


interface NotificationListenerInterface {

    public function sendEmail(NotificationEventInterface $event);

    public function sendSMS(NotificationEventInterface $event);

    public function sendPushNotification(NotificationEventInterface $event);

}