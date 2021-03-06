<?php
namespace BgvSessionDoctrine;

use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container;

/**
 * Class Module
 * @package BgvSessionDoctrine
 */
class Module
{
    /**
     * @param \Zend\EventManager\EventInterface $e
     */
    public function onBootstrap(\Zend\EventManager\EventInterface $e)
    {
        $sm = $e->getApplication()->getServiceManager();

        $sessionManager = $sm->get('session_save_manager');
        Container::setDefaultManager($sessionManager);
        register_shutdown_function('session_write_close');
        $sessionManager->start();
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'session_save_handler' => function ($serviceManager) {
                    $saveHandler = new SaveHandler\DoctrineORM($serviceManager);
                    return $saveHandler;
                },
                'session_options' => function ($serviceManager) {
                    $config = $serviceManager->get('config');

                    $sessionConfig = null;
                    if (array_key_exists('session_doctrine', $config) && is_array($config['session_doctrine'])) {
                        $sessionConfig = new SessionConfig();
                        $sessionConfig->setOptions($config['session_doctrine']);
                    }

                    return $sessionConfig;
                },
                'session_save_manager' => function ($serviceManager) {
                    $sessionManager = new SessionManager(
                        $serviceManager->get('session_options'),
                        null,
                        $serviceManager->get('session_save_handler'));

                    return $sessionManager;
                },
            )
        );
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
