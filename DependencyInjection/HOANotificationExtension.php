<?php

namespace HOA\Bundle\NotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HOANotificationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (isset($config['sms_service']['active']) && $config['sms_service']['active'] ) {
            $container->setParameter('hoa_notification.sms_service.active',$config['sms_service']['active']);
            $container->setParameter('hoa_notification.sms_service.twilio',$config['sms_service']['twilio']);
        }else {
            $container->setParameter('hoa_notification.sms_service.active',false);
            $container->setParameter('hoa_notification.sms_service.twilio',null);
        }
        $container->setParameter('hoa_notification.mailer_service.hoa_from_email', $config['mailer_service']['hoa_from_email']);
        $container->setParameter('hoa_notification.mailer_service.hoa_bcc_email', $config['mailer_service']['hoa_bcc_email']);

        $loader->load('services.yml');
    }
}
