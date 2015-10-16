<?php

namespace HOA\Bundle\NotificationBundle\Services;


class MailerService
{
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
     * @param array $mailAttachments (list of stwiftmail attachments
     */
    public function sendMessage($templateName, $context, $toEmail,$mailAttachments=array())
    {
        $template = $this->twig->loadTemplate($templateName);
        /* @var $template \Twig_Template */
        $context = array_merge($template->getEnvironment()->getGlobals(), $this->twig->mergeGlobals($context));
        $subject = $template->renderBlock('subject', $context);
        $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->fromEmail)
            ->setTo($toEmail)
            ->setBody($htmlBody, 'text/html')
            ->setBody(
                $this->twig->render(
                    $templateName, $context))
        ;
        if (isset($this->bccEmail)) {
            $message->addBcc($this->bccEmail);
        }
        if (count($mailAttachments)>0) {
            foreach ($mailAttachments as $mailAttachment){
                $message->attach($mailAttachment);
            }
        }

        $this->mailer->send($message);
    }
}
