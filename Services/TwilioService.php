<?php
namespace HOA\Bundle\NotificationBundle\Services;


class TwilioService extends \Services_Twilio
{

    protected $twig;

    protected $parameters;

    //set 'send_sms" to true in parameters.yml in order to send sms,
    protected $active;

    public function __construct($twilio_conf, \Twig_Environment $twig, $active)
    {
        $this->twig = $twig;

        // to avoid 5.3 incompatibilty
        $this->parameters = $twilio_conf;
        $this->active =$active;
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
            $this->account->messages->sendMessage(
                $this->parameters['outboundNumber'],
                $number, // Text this number
                $this->twig->render($template, array('data' => $data))
            );
        }
    }
}
