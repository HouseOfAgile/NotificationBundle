<?php

namespace HOA\Bundle\NotificationBundle\Services;


class MailerService implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;
    protected $twig;

    protected $fromEmail;
    protected $bccEmail;

    public function __construct($mailer, \Twig_Environment $twig, $fromEmail, $bccEmail)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->fromEmail = $fromEmail;
        $this->bccEmail = $bccEmail;
    }

    /**
     * @return mixed
     */
    public function getBccEmail()
    {
        return $this->bccEmail;
    }

    /**
     * @param mixed $bccEmail
     */
    public function setBccEmail($bccEmail)
    {
        $this->bccEmail = $bccEmail;
    }


    /**
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     * @param array $mailAttachments
     */
    public function sendMessage($templateName, $context, $toEmail, array $mailAttachments = null)
    {
        $template = $this->twig->loadTemplate($templateName);
        /* @var $template \Twig_Template */
        $context = array_merge($this->twig->getGlobals(), $this->twig->mergeGlobals($context));

        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $swiftInstance = \Swift_Message::newInstance();
        $message = $swiftInstance
            ->setSubject($subject)
            ->setFrom($this->fromEmail)
            ->setTo($toEmail)
        ;
        if (!empty($htmlBody)) {
            $message->setBody( $this->twig->render(
                $templateName, $context), 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }
        if ($mailAttachments!=null) {
            foreach ($mailAttachments as $mailAttachment) {
                $swiftInstance->attach($mailAttachment);
            }
        }
        if (isset($this->bccEmail)) {
            $message->addBcc($this->bccEmail);
        }
        $this->mailer->send($message);
    }
}
