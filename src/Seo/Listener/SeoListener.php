<?php

namespace Seo\Listener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Seo\Service\SeoService;

class SeoListener implements ListenerAggregateInterface {

  /**
   * @var \Zend\Stdlib\CallbackHandler[]
   */
  protected $listeners = array();

  /**
   * @var SeoService
   */
  protected $seoService;

  public function __construct(SeoService $seoService)
  {
    $this->seoService = $seoService;
  }

  /**
   * Attach to an event manager
   *
   * @param  EventManagerInterface $events
   * @param  integer $priority
   */
  public function attach(EventManagerInterface $events)
  {
    $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, array($this, 'renderSeo'), -100);
  }

  /**
   * Detach all our listeners from the event manager
   *
   * @param  EventManagerInterface $events
   * @return void
   */
  public function detach(EventManagerInterface $events)
  {
    foreach ($this->listeners as $index => $listener) {
      if ($events->detach($listener)) {
        unset($this->listeners[$index]);
      }
    }
  }

  public function renderSeo(EventInterface $e)
  {
    $sm = $e->getApplication()->getServiceManager();

    $config = $sm->get('config');
    $routes = $config['seo']['seo_routes'];

    $seoRoute = $e->getRouteMatch()->getMatchedRouteName();
    $params = $e->getRouteMatch()->getParams();
    $id = $params['id'];

    $type = $routes[$seoRoute];

    $seo = $this->seoService->getSeoByTypeId($id, $type);

    if ($seo) {
      // get view Model
      $renderer = $sm->get('Zend\View\Renderer\PhpRenderer');
      $renderer->headTitle()->append(ucfirst($seo->getTitle()));
      $renderer->headMeta()->appendName('description', $seo->getDescription());
      $renderer->headMeta()->setName('keywords', $seo->getKeywords());
    }
    // return response
    return $e->getResponse();
  }

}
