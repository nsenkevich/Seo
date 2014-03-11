<?php

namespace Seo;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\ControllerManager;

class Module {

  public function getAutoloaderConfig()
  {
    return array(
        'Zend\Loader\ClassMapAutoloader' => array(
            __DIR__ . '/autoload_classmap.php',
        ),
        'Zend\Loader\StandardAutoloader' => array(
            'namespaces' => array(
                __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
    )));
  }

  public function onBootstrap(MvcEvent $e)
  {
    $sm = $e->getApplication()->getServiceManager();
    $eventManager = $e->getTarget()->getEventManager();
    $eventManager->attach(new Listener\SeoListener($sm->get('seoService')));
  }

  public function getServiceConfig()
  {
    return array(
        'factories' => array(
            'seoService' => function($sm) {
      $em = $sm->get('doctrine.entitymanager.orm_default');
      $repository = $em->getRepository('Seo\Entity\Seo');
      $service = new Service\SeoService($repository);

      return $service;
    },
            'seoGrid' => 'Seo\Grid\SeoGridFactory',
            'seoForm' => 'Seo\Form\SeoFormFactory',
    ));
  }

  public function getControllerConfig()
  {
    return array(
        'factories' => array(
            'seoController' => function (ControllerManager $cm) {
      $locator = $cm->getServiceLocator();
      $controller = new Controller\SeoController($locator->get('seoService'));
      $controller->setSeoForm($locator->get('seoForm'));
      $controller->setSeoGrid($locator->get('seoGrid'));
      return $controller;
    }));
  }

  /**
   * @return array
   */
  public function getConfig()
  {
    $config = array();
    $configFiles = array(
        __DIR__ . '/config/module.config.php',
        __DIR__ . '/config/doctrine.config.php',
        __DIR__ . '/config/seo.config.php'
    );
    foreach ($configFiles as $configFile) {
      $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile);
    }
    return $config;
  }

}
