<?php

namespace HOA\Bundle\NotificationBundle\Services;


class MailerService
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
    public function sendMessage($templateName, $context, $toEmail,array $mailAttachments=null)
    {
        $template = $this->twig->loadTemplate($templateName);
        /* @var $template \Twig_Template */
        $context = array_merge($template->getEnvironment()->getGlobals(), $this->twig->mergeGlobals($context));
        $subject = $template->renderBlock('subject', $context);
        $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $swiftInstance=\Swift_Message::newInstance();
        $message = $swiftInstance
            ->setSubject($subject)
            ->setFrom($this->fromEmail)
            ->setTo($toEmail)
            ->setBody($htmlBody, 'text/html')
            ->setBody(
                $this->twig->render(
                    $templateName, $context))
        ;
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
