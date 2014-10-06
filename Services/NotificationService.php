<?php

namespace HOA\Bundle\NotificationBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * NotificationService : simple service to manage notifications
 *
 */
class NotificationService
{

    /**
     * Container
     * @var Container
     */
    protected $container;


    public function __construct(Container $container)
    {
        $this->container = $container;
    }

/**
 * should manage a notificationsystem there
 */

}
