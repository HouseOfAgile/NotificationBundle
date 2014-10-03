<?php
namespace HOA\Bundle\NotificationBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class TwilioService extends \Services_Twilio
{

    /**
     * Container
     * @var Container
     */
    protected $container;

    protected $twig;

    protected $parameters;
    //set 'send_sms" to true in parameters.yml in order to send sms,
    protected $active;

    public function __construct(Container $container, \Twig_Environment $twig)
    {
        $this->container = $container;
        $this->twig = $twig;

        // to avoid 5.3 incompatibilty
        $this->parameters = $this->container->getParameter('twilio');
        $this->active = $this->container->getParameter('send_sms');
        parent::__construct(
            $this->parameters['sid'],
            $this->parameters['authToken'],
            $this->parameters['version'],
            null,
            $this->parameters['retryAttempts']
        );
    }

    public function sendSms($number, $template, $data)
    {
        if ($this->active) {
            $this->parameters = $this->container->getParameter('twilio');
            $message = $this->account->messages->sendMessage(
                $this->parameters['outboundNumber'],
                $number, // Text this number
                $this->twig->render($template, array('data' => $data))
            );
//            echo $this->twig->render($template, array('data' => $data));
//            echo $number;


        }
        // no else, just no sending any sms
    }
}